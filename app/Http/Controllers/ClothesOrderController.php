<?php

namespace App\Http\Controllers;

use App\DataTables\ClothesOrderDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateClothesOrderRequest;
use App\Http\Requests\UpdateClothesOrderRequest;
use App\Repositories\ClothesOrderRepository;
use App\Repositories\CustomFieldRepository;
use App\Repositories\ClothesRepository;
                use App\Repositories\ExtraRepository;
                use App\Repositories\OrderRepository;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class ClothesOrderController extends Controller
{
    /** @var  ClothesOrderRepository */
    private $clothesOrderRepository;

    /**
     * @var CustomFieldRepository
     */
    private $customFieldRepository;

    /**
  * @var ClothesRepository
  */
private $clothesRepository;/**
  * @var ExtraRepository
  */
private $extraRepository;/**
  * @var OrderRepository
  */
private $orderRepository;

    public function __construct(ClothesOrderRepository $clothesOrderRepo, CustomFieldRepository $customFieldRepo , ClothesRepository $clothesRepo
                , ExtraRepository $extraRepo
                , OrderRepository $orderRepo)
    {
        parent::__construct();
        $this->clothesOrderRepository = $clothesOrderRepo;
        $this->customFieldRepository = $customFieldRepo;
        $this->clothesRepository = $clothesRepo;
                $this->extraRepository = $extraRepo;
                $this->orderRepository = $orderRepo;
    }

    /**
     * Display a listing of the ClothesOrder.
     *
     * @param ClothesOrderDataTable $clothesOrderDataTable
     * @return Response
     */
    public function index(ClothesOrderDataTable $clothesOrderDataTable)
    {
        return $clothesOrderDataTable->render('clothes_orders.index');
    }

    /**
     * Show the form for creating a new ClothesOrder.
     *
     * @return Response
     */
    public function create()
    {
        $clothes = $this->clothesRepository->pluck('name','id');
                $extra = $this->extraRepository->pluck('name','id');
                $order = $this->orderRepository->pluck('id','id');
        $extrasSelected = [];
        $hasCustomField = in_array($this->clothesOrderRepository->model(),setting('custom_field_models',[]));
            if($hasCustomField){
                $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->clothesOrderRepository->model());
                $html = generateCustomField($customFields);
            }
        return view('clothes_orders.create')->with("customFields", isset($html) ? $html : false)->with("clothes",$clothes)->with("extra",$extra)->with("extrasSelected",$extrasSelected)->with("order",$order);
    }

    /**
     * Store a newly created ClothesOrder in storage.
     *
     * @param CreateClothesOrderRequest $request
     *
     * @return Response
     */
    public function store(CreateClothesOrderRequest $request)
    {
        $input = $request->all();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->clothesOrderRepository->model());
        try {
            $clothesOrder = $this->clothesOrderRepository->create($input);
            $clothesOrder->customFieldsValues()->createMany(getCustomFieldsValues($customFields,$request));
            
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.saved_successfully',['operator' => __('lang.clothes_order')]));

        return redirect(route('clothesOrders.index'));
    }

    /**
     * Display the specified ClothesOrder.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $clothesOrder = $this->clothesOrderRepository->findWithoutFail($id);

        if (empty($clothesOrder)) {
            Flash::error('Clothes Order not found');

            return redirect(route('clothesOrders.index'));
        }

        return view('clothes_orders.show')->with('clothesOrder', $clothesOrder);
    }

    /**
     * Show the form for editing the specified ClothesOrder.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $clothesOrder = $this->clothesOrderRepository->findWithoutFail($id);
        $clothes = $this->clothesRepository->pluck('name','id');
                $extra = $this->extraRepository->pluck('name','id');
                $order = $this->orderRepository->pluck('id','id');
        $extrasSelected = $clothesOrder->extras()->pluck('extras.id')->toArray();

        if (empty($clothesOrder)) {
            Flash::error(__('lang.not_found',['operator' => __('lang.clothes_order')]));

            return redirect(route('clothesOrders.index'));
        }
        $customFieldsValues = $clothesOrder->customFieldsValues()->with('customField')->get();
        $customFields =  $this->customFieldRepository->findByField('custom_field_model', $this->clothesOrderRepository->model());
        $hasCustomField = in_array($this->clothesOrderRepository->model(),setting('custom_field_models',[]));
        if($hasCustomField) {
            $html = generateCustomField($customFields, $customFieldsValues);
        }

        return view('clothes_orders.edit')->with('clothesOrder', $clothesOrder)->with("customFields", isset($html) ? $html : false)->with("clothes",$clothes)->with("extra",$extra)->with("extrasSelected",$extrasSelected)->with("order",$order);
    }

    /**
     * Update the specified ClothesOrder in storage.
     *
     * @param  int              $id
     * @param UpdateClothesOrderRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateClothesOrderRequest $request)
    {
        $clothesOrder = $this->clothesOrderRepository->findWithoutFail($id);

        if (empty($clothesOrder)) {
            Flash::error('Clothes Order not found');
            return redirect(route('clothesOrders.index'));
        }
        $input = $request->all();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->clothesOrderRepository->model());
        try {
            $clothesOrder = $this->clothesOrderRepository->update($input, $id);
            $input['extras'] = isset($input['extras']) ? $input['extras'] : [];
            
            foreach (getCustomFieldsValues($customFields, $request) as $value){
                $clothesOrder->customFieldsValues()
                    ->updateOrCreate(['custom_field_id'=>$value['custom_field_id']],$value);
            }
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.updated_successfully',['operator' => __('lang.clothes_order')]));

        return redirect(route('clothesOrders.index'));
    }

    /**
     * Remove the specified ClothesOrder from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $clothesOrder = $this->clothesOrderRepository->findWithoutFail($id);

        if (empty($clothesOrder)) {
            Flash::error('Clothes Order not found');

            return redirect(route('clothesOrders.index'));
        }

        $this->clothesOrderRepository->delete($id);

        Flash::success(__('lang.deleted_successfully',['operator' => __('lang.clothes_order')]));

        return redirect(route('clothesOrders.index'));
    }

        /**
     * Remove Media of ClothesOrder
     * @param Request $request
     */
    public function removeMedia(Request $request)
    {
        $input = $request->all();
        $clothesOrder = $this->clothesOrderRepository->findWithoutFail($input['id']);
        try {
            if($clothesOrder->hasMedia($input['collection'])){
                $clothesOrder->getFirstMedia($input['collection'])->delete();
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
