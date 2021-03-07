<?php

namespace App\Http\Controllers\API;


use App\Models\ClothesReview;
use App\Repositories\ClothesReviewRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\Response;
use Prettus\Repository\Exceptions\RepositoryException;
use Flash;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class ClothesReviewController
 * @package App\Http\Controllers\API
 */

class ClothesReviewAPIController extends Controller
{
    /** @var  ClothesReviewRepository */
    private $clothesReviewRepository;

    public function __construct(ClothesReviewRepository $clothesReviewRepo)
    {
        $this->clothesReviewRepository = $clothesReviewRepo;
    }

    /**
     * Display a listing of the ClothesReview.
     * GET|HEAD /clothesReviews
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try{
            $this->clothesReviewRepository->pushCriteria(new RequestCriteria($request));
            $this->clothesReviewRepository->pushCriteria(new LimitOffsetCriteria($request));
        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }
        $clothesReviews = $this->clothesReviewRepository->all();

        return $this->sendResponse($clothesReviews->toArray(), 'Clothes Reviews retrieved successfully');
    }

    /**
     * Display the specified ClothesReview.
     * GET|HEAD /clothesReviews/{id}
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var ClothesReview $clothesReview */
        if (!empty($this->clothesReviewRepository)) {
            $clothesReview = $this->clothesReviewRepository->findWithoutFail($id);
        }

        if (empty($clothesReview)) {
            return $this->sendError('Clothes Review not found');
        }

        return $this->sendResponse($clothesReview->toArray(), 'Clothes Review retrieved successfully');
    }

    /**
     * Store a newly created ClothesReview in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $uniqueInput = $request->only("user_id","clothes_id");
        $otherInput = $request->except("user_id","clothes_id");
        try {
            $clothesReview = $this->clothesReviewRepository->updateOrCreate($uniqueInput,$otherInput);
        } catch (ValidatorException $e) {
            return $this->sendError('Clothes Review not found');
        }

        return $this->sendResponse($clothesReview->toArray(),__('lang.saved_successfully',['operator' => __('lang.clothes_review')]));
    }
}
