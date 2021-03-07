<?php

namespace App\Http\Controllers\API;


use App\Models\ShopsPayout;
use App\Repositories\ShopsPayoutRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\Response;
use Prettus\Repository\Exceptions\RepositoryException;
use Flash;

/**
 * Class ShopsPayoutController
 * @package App\Http\Controllers\API
 */

class ShopsPayoutAPIController extends Controller
{
    /** @var  ShopsPayoutRepository */
    private $shopsPayoutRepository;

    public function __construct(ShopsPayoutRepository $shopsPayoutRepo)
    {
        $this->shopsPayoutRepository = $shopsPayoutRepo;
    }

    /**
     * Display a listing of the ShopsPayout.
     * GET|HEAD /shopsPayouts
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try{
            $this->shopsPayoutRepository->pushCriteria(new RequestCriteria($request));
            $this->shopsPayoutRepository->pushCriteria(new LimitOffsetCriteria($request));
        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }
        $shopsPayouts = $this->shopsPayoutRepository->all();

        return $this->sendResponse($shopsPayouts->toArray(), 'Shops Payouts retrieved successfully');
    }

    /**
     * Display the specified ShopsPayout.
     * GET|HEAD /shopsPayouts/{id}
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var ShopsPayout $shopsPayout */
        if (!empty($this->shopsPayoutRepository)) {
            $shopsPayout = $this->shopsPayoutRepository->findWithoutFail($id);
        }

        if (empty($shopsPayout)) {
            return $this->sendError('Shops Payout not found');
        }

        return $this->sendResponse($shopsPayout->toArray(), 'Shops Payout retrieved successfully');
    }
}
