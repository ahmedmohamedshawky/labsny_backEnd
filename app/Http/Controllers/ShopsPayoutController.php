<?php

namespace App\Http\Controllers;

use App\Criteria\Earnings\EarningOfShopCriteria;
use App\Criteria\Shops\ShopsOfManagerCriteria;
use App\DataTables\ShopsPayoutDataTable;
use App\Http\Requests\CreateShopsPayoutRequest;
use App\Http\Requests\UpdateShopsPayoutRequest;
use App\Repositories\CustomFieldRepository;
use App\Repositories\EarningRepository;
use App\Repositories\ShopRepository;
use App\Repositories\ShopsPayoutRepository;
use Carbon\Carbon;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class ShopsPayoutController extends Controller
{
    /** @var  ShopsPayoutRepository */
    private $shopsPayoutRepository;

    /**
     * @var CustomFieldRepository
     */
    private $customFieldRepository;

    /**
     * @var ShopRepository
     */
    private $shopRepository;
    /**
     * @var EarningRepository
     */
    private $earningRepository;

    public function __construct(ShopsPayoutRepository $shopsPayoutRepo, CustomFieldRepository $customFieldRepo, ShopRepository $shopRepo, EarningRepository $earningRepository)
    {
        parent::__construct();
        $this->shopsPayoutRepository = $shopsPayoutRepo;
        $this->customFieldRepository = $customFieldRepo;
        $this->shopRepository = $shopRepo;
        $this->earningRepository = $earningRepository;
    }

    /**
     * Display a listing of the ShopsPayout.
     *
     * @param ShopsPayoutDataTable $shopsPayoutDataTable
     * @return Response
     */
    public function index(ShopsPayoutDataTable $shopsPayoutDataTable)
    {
        return $shopsPayoutDataTable->render('shops_payouts.index');
    }

    /**
     * Show the form for creating a new ShopsPayout.
     *
     * @return Response
     */
    public function create()
    {
        if(auth()->user()->hasRole('manager')){
            $this->shopRepository->pushCriteria(new ShopsOfManagerCriteria(auth()->id()));
        }
        $shop = $this->shopRepository->pluck('name', 'id');

        $hasCustomField = in_array($this->shopsPayoutRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->shopsPayoutRepository->model());
            $html = generateCustomField($customFields);
        }
        return view('shops_payouts.create')->with("customFields", isset($html) ? $html : false)->with("shop", $shop);
    }

    /**
     * Store a newly created ShopsPayout in storage.
     *
     * @param CreateShopsPayoutRequest $request
     *
     * @return Response
     */
    public function store(CreateShopsPayoutRequest $request)
    {
        $input = $request->all();
        $earning = $this->earningRepository->findByField('shop_id',$input['shop_id'])->first();
        if($input['amount'] > $earning->shop_earning){
            Flash::error('The payout amount must be less than shop earning');
            return redirect(route('shopsPayouts.create'))->withInput($input);
        }
        $input['paid_date'] = Carbon::now();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->shopsPayoutRepository->model());
        try {
            $this->earningRepository->update(['shop_earning'=>$earning->shop_earning - $input['amount']], $earning->id);
            $shopsPayout = $this->shopsPayoutRepository->create($input);
            $shopsPayout->customFieldsValues()->createMany(getCustomFieldsValues($customFields, $request));

        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.saved_successfully', ['operator' => __('lang.shops_payout')]));

        return redirect(route('shopsPayouts.index'));
    }

    /**
     * Display the specified ShopsPayout.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $shopsPayout = $this->shopsPayoutRepository->findWithoutFail($id);

        if (empty($shopsPayout)) {
            Flash::error('Shops Payout not found');

            return redirect(route('shopsPayouts.index'));
        }

        return view('shops_payouts.show')->with('shopsPayout', $shopsPayout);
    }

    /**
     * Show the form for editing the specified ShopsPayout.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $shopsPayout = $this->shopsPayoutRepository->findWithoutFail($id);
        $shop = $this->shopRepository->pluck('name', 'id');


        if (empty($shopsPayout)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.shops_payout')]));

            return redirect(route('shopsPayouts.index'));
        }
        $customFieldsValues = $shopsPayout->customFieldsValues()->with('customField')->get();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->shopsPayoutRepository->model());
        $hasCustomField = in_array($this->shopsPayoutRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $html = generateCustomField($customFields, $customFieldsValues);
        }

        return view('shops_payouts.edit')->with('shopsPayout', $shopsPayout)->with("customFields", isset($html) ? $html : false)->with("shop", $shop);
    }

    /**
     * Update the specified ShopsPayout in storage.
     *
     * @param int $id
     * @param UpdateShopsPayoutRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateShopsPayoutRequest $request)
    {
        $shopsPayout = $this->shopsPayoutRepository->findWithoutFail($id);

        if (empty($shopsPayout)) {
            Flash::error('Shops Payout not found');
            return redirect(route('shopsPayouts.index'));
        }
        $input = $request->all();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->shopsPayoutRepository->model());
        try {
            $shopsPayout = $this->shopsPayoutRepository->update($input, $id);


            foreach (getCustomFieldsValues($customFields, $request) as $value) {
                $shopsPayout->customFieldsValues()
                    ->updateOrCreate(['custom_field_id' => $value['custom_field_id']], $value);
            }
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.updated_successfully', ['operator' => __('lang.shops_payout')]));

        return redirect(route('shopsPayouts.index'));
    }

    /**
     * Remove the specified ShopsPayout from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $shopsPayout = $this->shopsPayoutRepository->findWithoutFail($id);

        if (empty($shopsPayout)) {
            Flash::error('Shops Payout not found');

            return redirect(route('shopsPayouts.index'));
        }

        $this->shopsPayoutRepository->delete($id);

        Flash::success(__('lang.deleted_successfully', ['operator' => __('lang.shops_payout')]));

        return redirect(route('shopsPayouts.index'));
    }

    /**
     * Remove Media of ShopsPayout
     * @param Request $request
     */
    public function removeMedia(Request $request)
    {
        $input = $request->all();
        $shopsPayout = $this->shopsPayoutRepository->findWithoutFail($input['id']);
        try {
            if ($shopsPayout->hasMedia($input['collection'])) {
                $shopsPayout->getFirstMedia($input['collection'])->delete();
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
