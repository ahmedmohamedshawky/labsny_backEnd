<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ShopCategoryRepository;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

class ShopCategoryAPIController extends Controller
{
    /** @var  ShopCategoryRepository */
    private $shopCategoryRepository;

    public function __construct(ShopCategoryRepository $shopCategoryRepo)
    {
        parent::__construct();
        $this->shopCategoryRepository = $shopCategoryRepo;
    }

    public function index(Request $request)
    {
        try{
            $this->shopCategoryRepository->pushCriteria(new RequestCriteria($request));
            $this->shopCategoryRepository->pushCriteria(new LimitOffsetCriteria($request));

            $shopCategory = $this->shopCategoryRepository->get();
        } catch (RepositoryException $e) {
            return '$this->sendError($e->getMessage())';
        }

        return $this->sendResponse($shopCategory->toArray(), 'Shops Category retrieved successfully');
    }
}
