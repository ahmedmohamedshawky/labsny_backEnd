<?php

namespace App\Http\Controllers\API;

use App\Criteria\Earnings\EarningOfUserCriteria;
use App\Criteria\Clothes\ClothesOfUserCriteria;
use App\Criteria\Orders\OrdersOfUserCriteria;
use App\Criteria\Shops\ShopsOfManagerCriteria;
use App\Http\Controllers\Controller;
use App\Repositories\EarningRepository;
use App\Repositories\ClothesRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ShopRepository;
use Illuminate\Http\Request;
use Prettus\Repository\Exceptions\RepositoryException;

class DashboardAPIController extends Controller
{
    /** @var  OrderRepository */
    private $orderRepository;

    /** @var  ShopRepository */
    private $shopRepository;
    /**
     * @var ClothesRepository
     */
    private $clothesRepository;
    /**
     * @var EarningRepository
     */
    private $earningRepository;

    public function __construct(OrderRepository $orderRepo, EarningRepository $earningRepository, ShopRepository $shopRepo, ClothesRepository $clothesRepository)
    {
        parent::__construct();
        $this->orderRepository = $orderRepo;
        $this->shopRepository = $shopRepo;
        $this->clothesRepository = $clothesRepository;
        $this->earningRepository = $earningRepository;
    }

    /**
     * Display a listing of the Faq.
     * GET|HEAD /faqs
     * @param  int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function manager($id, Request $request)
    {
        $statistics = [];
        try{

            $this->earningRepository->pushCriteria(new EarningOfUserCriteria(auth()->id()));
            $earning['description'] = 'total_earning';
            $earning['value'] = $this->earningRepository->all()->sum('shop_earning');
            $statistics[] = $earning;

            $this->orderRepository->pushCriteria(new OrdersOfUserCriteria(auth()->id()));
            $ordersCount['description'] = "total_orders";
            $ordersCount['value'] = $this->orderRepository->all('orders.id')->count();
            $statistics[] = $ordersCount;

            $this->shopRepository->pushCriteria(new ShopsOfManagerCriteria(auth()->id()));
            $shopsCount['description'] = "total_shops";
            $shopsCount['value'] = $this->shopRepository->all('shops.id')->count();
            $statistics[] = $shopsCount;

            $this->clothesRepository->pushCriteria(new ClothesOfUserCriteria(auth()->id()));
            $clothesCount['description'] = "total_clothes";
            $clothesCount['value'] = $this->clothesRepository->all('clothes.id')->count();
            $statistics[] = $clothesCount;


        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($statistics, 'Statistics retrieved successfully');
    }
}
