<?php

namespace App\Http\Controllers;

use App\DataTables\OfferDataTable;
use App\Http\Requests\CreateOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Repositories\OfferRepository;
use App\Repositories\CustomFieldRepository;
use App\Repositories\UploadRepository;
use App\Repositories\ShopRepository;
use App\Repositories\UserRepository;
use App\Repositories\CoinRepository;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class OfferController extends Controller
{
    /** @var  OfferRepository */
    private $offerRepository;

    /**
     * @var CustomFieldRepository
     */
    private $customFieldRepository;

    /**
     * @var ShopRepository
     */
    private $shopRepository;

    /**
     * @var UploadRepository
     */
    private $uploadRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var CoinRepository
     */
    private $coinRepository;

    public function __construct(OfferRepository $offerRepo, CustomFieldRepository $customFieldRepo, UploadRepository $uploadRepo,
                                ShopRepository $shopRepo, UserRepository $userRepo, CoinRepository $coinRepo)
    {
        parent::__construct();
        $this->offerRepository = $offerRepo;
        $this->customFieldRepository = $customFieldRepo;
        $this->uploadRepository = $uploadRepo;
        $this->shopRepository = $shopRepo;
        $this->userRepository = $userRepo;
        $this->coinRepository = $coinRepo;
    }

    /**
     * Display a listing of the Offer.
     *
     * @param OfferDataTable $offerDataTable
     * @return Response
     */
    public function index(OfferDataTable $offerDataTable)
    {
        return $offerDataTable->render('offers.index');
    }

    /**
     * Show the form for creating a new Offer.
     *
     * @return Response
     */
    public function create()
    {
        $hasCustomField = in_array($this->offerRepository->model(), setting('custom_field_models', []));
        if (auth()->user()->hasRole('admin')) {
            $shop = $this->shopRepository->pluck('name', 'id');
        } else {
            $shop = $this->shopRepository->myActiveShops()->pluck('name', 'id');
        }
        if ($hasCustomField) {
            $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->offerRepository->model());
            $html = generateCustomField($customFields);
        }
        return view('offers.create')->with("shop", $shop)->with("customFields", isset($html) ? $html : false);
    }

    /**
     * Store a newly created Offer in storage.
     *
     * @param CreateOfferRequest $request
     *
     * @return Response
     */
    public function store(CreateOfferRequest $request)
    {
        $input = $request->all();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->offerRepository->model());
        try {
            $input['manager_id'] = auth()->user()->id;
            $offer = $this->offerRepository->create($input);
            $offer->customFieldsValues()->createMany(getCustomFieldsValues($customFields, $request));
            return $offer;
            if (isset($input['image']) && $input['image']) {
                $cacheUpload = $this->uploadRepository->getByUuid($input['image']);
                $mediaItem = $cacheUpload->getMedia('image')->first();
                $mediaItem->copy($offer, 'image');
            }
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.saved_successfully', ['operator' => __('lang.offer')]));

        return redirect(route('offers.index'));
    }

    /**
     * Display the specified Offer.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $offer = $this->offerRepository->findWithoutFail($id);

        if (empty($offer)) {
            Flash::error('Offer not found');

            return redirect(route('offers.index'));
        }

        return view('offers.show')->with('offer', $offer);
    }

    /**
     * Show the form for editing the specified Offer.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $offer = $this->offerRepository->findWithoutFail($id);

        if (empty($offer)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.offer')]));

            return redirect(route('offers.index'));
        }
        if (auth()->user()->hasRole('admin')) {
            $shop = $this->shopRepository->pluck('name', 'id');
        } else {
            $shop = $this->shopRepository->myShops()->pluck('name', 'id');
        }
        $customFieldsValues = $offer->customFieldsValues()->with('customField')->get();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->offerRepository->model());
        $hasCustomField = in_array($this->offerRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $html = generateCustomField($customFields, $customFieldsValues);
        }

        return view('offers.edit')->with('offer', $offer)->with("shop", $shop)->with("customFields", isset($html) ? $html : false);
    }

    /**
     * Update the specified Offer in storage.
     *
     * @param int $id
     * @param UpdateOfferRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOfferRequest $request)
    {
        \DB::beginTransaction();
        $offer = $this->offerRepository->findWithoutFail($id);

        if (empty($offer)) {
            Flash::error('Offer not found');
            return redirect(route('offers.index'));
        }
        $input = $request->all();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->offerRepository->model());
        try {
            $oldOfferStatus = $this->offerRepository->find($id);
            $offer = $this->offerRepository->update($input, $id);
            if (auth()->user()->hasRole('admin') && json_encode($offer->active) == 'true' && 
                json_encode($oldOfferStatus->active) == 'false') {
                $manager = $this->userRepository->find($offer->manager_id);
                $offerCoins = $this->coinRepository->first();
                $manager->coins -= $offerCoins->offers;
                if ($manager->coins < 0){
                    Flash::error('Manager has\'nt coins enough');
                    return redirect(route('offers.index'));
                }
                $manager->save();
            }

            if (isset($input['image']) && $input['image']) {
                $cacheUpload = $this->uploadRepository->getByUuid($input['image']);
                $mediaItem = $cacheUpload->getMedia('image')->first();
                $mediaItem->copy($offer, 'image');
            }
            foreach (getCustomFieldsValues($customFields, $request) as $value) {
                $offer->customFieldsValues()
                    ->updateOrCreate(['custom_field_id' => $value['custom_field_id']], $value);
            }
            \DB::commit();
        } catch (ValidatorException $e) {
            \DB::rollBack();
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.updated_successfully', ['operator' => __('lang.offer')]));

        return redirect(route('offers.index'));
    }

    /**
     * Remove the specified Offer from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $offer = $this->offerRepository->findWithoutFail($id);

        if (empty($offer)) {
            Flash::error('Offer not found');

            return redirect(route('offers.index'));
        }

        $this->offerRepository->delete($id);

        Flash::success(__('lang.deleted_successfully', ['operator' => __('lang.offer')]));

        return redirect(route('offers.index'));
    }

    /**
     * Remove Media of Offer
     * @param Request $request
     */
    public function removeMedia(Request $request)
    {
        $input = $request->all();
        $offer = $this->offerRepository->findWithoutFail($input['id']);
        try {
            if ($offer->hasMedia($input['collection'])) {
                $offer->getFirstMedia($input['collection'])->delete();
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
