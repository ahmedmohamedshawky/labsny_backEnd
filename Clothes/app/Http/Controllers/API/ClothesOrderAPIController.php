<?php

namespace App\Http\Controllers\API;


use App\Models\ClothesOrder;
use App\Repositories\ClothesOrderRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\Response;
use Prettus\Repository\Exceptions\RepositoryException;
use Flash;

/**
 * Class ClothesOrderController
 * @package App\Http\Controllers\API
 */

class ClothesOrderAPIController extends Controller
{
    /** @var  ClothesOrderRepository */
    private $clothesOrderRepository;

    public function __construct(ClothesOrderRepository $clothesOrderRepo)
    {
        $this->clothesOrderRepository = $clothesOrderRepo;
    }

    /**
     * Display a listing of the ClothesOrder.
     * GET|HEAD /clothesOrders
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try{
            $this->clothesOrderRepository->pushCriteria(new RequestCriteria($request));
            $this->clothesOrderRepository->pushCriteria(new LimitOffsetCriteria($request));
        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }
        $clothesOrders = $this->clothesOrderRepository->all();

        return $this->sendResponse($clothesOrders->toArray(), 'Clothes Orders retrieved successfully');
    }

    /**
     * Display the specified ClothesOrder.
     * GET|HEAD /clothesOrders/{id}
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var ClothesOrder $clothesOrder */
        if (!empty($this->clothesOrderRepository)) {
            $clothesOrder = $this->clothesOrderRepository->findWithoutFail($id);
        }

        if (empty($clothesOrder)) {
            return $this->sendError('Clothes Order not found');
        }

        return $this->sendResponse($clothesOrder->toArray(), 'Clothes Order retrieved successfully');
    }
}
