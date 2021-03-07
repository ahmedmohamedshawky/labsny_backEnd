<?php

namespace App\Http\Controllers\API;


use App\Http\Requests\CreateShopReviewRequest;
use App\Models\ShopReview;
use App\Repositories\ShopReviewRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\Response;
use Prettus\Repository\Exceptions\RepositoryException;
use Flash;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class ShopReviewController
 * @package App\Http\Controllers\API
 */

class ShopReviewAPIController extends Controller
{
    /** @var  ShopReviewRepository */
    private $shopReviewRepository;

    public function __construct(ShopReviewRepository $shopReviewRepo)
    {
        $this->shopReviewRepository = $shopReviewRepo;
    }

    /**
     * Display a listing of the ShopReview.
     * GET|HEAD /shopReviews
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try{
            $this->shopReviewRepository->pushCriteria(new RequestCriteria($request));
            $this->shopReviewRepository->pushCriteria(new LimitOffsetCriteria($request));
        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }
        $shopReviews = $this->shopReviewRepository->all();

        return $this->sendResponse($shopReviews->toArray(), 'Shop Reviews retrieved successfully');
    }

    /**
     * Display the specified ShopReview.
     * GET|HEAD /shopReviews/{id}
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var ShopReview $shopReview */
        if (!empty($this->shopReviewRepository)) {
            $shopReview = $this->shopReviewRepository->findWithoutFail($id);
        }

        if (empty($shopReview)) {
            return $this->sendError('Shop Review not found');
        }

        return $this->sendResponse($shopReview->toArray(), 'Shop Review retrieved successfully');
    }

    /**
     * Store a newly created ShopReview in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $uniqueInput = $request->only("user_id","shop_id");
        $otherInput = $request->except("user_id","shop_id");
        try {
            $shopReview = $this->shopReviewRepository->updateOrCreate($uniqueInput,$otherInput);
        } catch (ValidatorException $e) {
            return $this->sendError('Shop Review not found');
        }

        return $this->sendResponse($shopReview->toArray(),__('lang.saved_successfully',['operator' => __('lang.shop_review')]));
    }
}
