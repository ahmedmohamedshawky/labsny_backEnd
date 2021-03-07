<?php
/**
 * File name: ShopReviewController.php
 * Last modified: 2020.05.04 at 09:04:19
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App\Http\Controllers;

use App\Criteria\ShopReviews\ShopReviewsOfUserCriteria;
use App\DataTables\ShopReviewDataTable;
use App\Http\Requests\CreateShopReviewRequest;
use App\Http\Requests\UpdateShopReviewRequest;
use App\Repositories\CustomFieldRepository;
use App\Repositories\ShopReviewRepository;
use App\Repositories\ShopRepository;
use App\Repositories\UserRepository;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class ShopReviewController extends Controller
{
    /** @var  ShopReviewRepository */
    private $shopReviewRepository;

    /**
     * @var CustomFieldRepository
     */
    private $customFieldRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ShopRepository
     */
    private $shopRepository;

    public function __construct(ShopReviewRepository $shopReviewRepo, CustomFieldRepository $customFieldRepo, UserRepository $userRepo
        , ShopRepository $shopRepo)
    {
        parent::__construct();
        $this->shopReviewRepository = $shopReviewRepo;
        $this->customFieldRepository = $customFieldRepo;
        $this->userRepository = $userRepo;
        $this->shopRepository = $shopRepo;
    }

    /**
     * Display a listing of the ShopReview.
     *
     * @param ShopReviewDataTable $shopReviewDataTable
     * @return Response
     */
    public function index(ShopReviewDataTable $shopReviewDataTable)
    {
        return $shopReviewDataTable->render('shop_reviews.index');
    }

    /**
     * Show the form for creating a new ShopReview.
     *
     * @return Response
     */
    public function create()
    {
        $user = $this->userRepository->pluck('name', 'id');
        $shop = $this->shopRepository->pluck('name', 'id');

        $hasCustomField = in_array($this->shopReviewRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->shopReviewRepository->model());
            $html = generateCustomField($customFields);
        }
        return view('shop_reviews.create')->with("customFields", isset($html) ? $html : false)->with("user", $user)->with("shop", $shop);
    }

    /**
     * Store a newly created ShopReview in storage.
     *
     * @param CreateShopReviewRequest $request
     *
     * @return Response
     */
    public function store(CreateShopReviewRequest $request)
    {
        $input = $request->all();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->shopReviewRepository->model());
        try {
            $shopReview = $this->shopReviewRepository->create($input);
            $shopReview->customFieldsValues()->createMany(getCustomFieldsValues($customFields, $request));

        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.saved_successfully', ['operator' => __('lang.shop_review')]));

        return redirect(route('shopReviews.index'));
    }

    /**
     * Display the specified ShopReview.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $shopReview = $this->shopReviewRepository->findWithoutFail($id);

        if (empty($shopReview)) {
            Flash::error('Shop Review not found');

            return redirect(route('shopReviews.index'));
        }

        return view('shop_reviews.show')->with('shopReview', $shopReview);
    }

    /**
     * Show the form for editing the specified ShopReview.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function edit($id)
    {
        $this->shopReviewRepository->pushCriteria(new ShopReviewsOfUserCriteria(auth()->id()));
        $shopReview = $this->shopReviewRepository->findWithoutFail($id);
        if (empty($shopReview)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.shop_review')]));

            return redirect(route('shopReviews.index'));
        }
        $user = $this->userRepository->pluck('name', 'id');
        $shop = $this->shopRepository->pluck('name', 'id');


        $customFieldsValues = $shopReview->customFieldsValues()->with('customField')->get();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->shopReviewRepository->model());
        $hasCustomField = in_array($this->shopReviewRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $html = generateCustomField($customFields, $customFieldsValues);
        }

        return view('shop_reviews.edit')->with('shopReview', $shopReview)->with("customFields", isset($html) ? $html : false)->with("user", $user)->with("shop", $shop);
    }

    /**
     * Update the specified ShopReview in storage.
     *
     * @param int $id
     * @param UpdateShopReviewRequest $request
     *
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function update($id, UpdateShopReviewRequest $request)
    {
        $this->shopReviewRepository->pushCriteria(new ShopReviewsOfUserCriteria(auth()->id()));
        $shopReview = $this->shopReviewRepository->findWithoutFail($id);

        if (empty($shopReview)) {
            Flash::error('Shop Review not found');
            return redirect(route('shopReviews.index'));
        }
        $input = $request->all();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->shopReviewRepository->model());
        try {
            $shopReview = $this->shopReviewRepository->update($input, $id);


            foreach (getCustomFieldsValues($customFields, $request) as $value) {
                $shopReview->customFieldsValues()
                    ->updateOrCreate(['custom_field_id' => $value['custom_field_id']], $value);
            }
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.updated_successfully', ['operator' => __('lang.shop_review')]));

        return redirect(route('shopReviews.index'));
    }

    /**
     * Remove the specified ShopReview from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function destroy($id)
    {
        $this->shopReviewRepository->pushCriteria(new ShopReviewsOfUserCriteria(auth()->id()));
        $shopReview = $this->shopReviewRepository->findWithoutFail($id);

        if (empty($shopReview)) {
            Flash::error('Shop Review not found');

            return redirect(route('shopReviews.index'));
        }

        $this->shopReviewRepository->delete($id);

        Flash::success(__('lang.deleted_successfully', ['operator' => __('lang.shop_review')]));

        return redirect(route('shopReviews.index'));
    }

    /**
     * Remove Media of ShopReview
     * @param Request $request
     */
    public function removeMedia(Request $request)
    {
        $input = $request->all();
        $shopReview = $this->shopReviewRepository->findWithoutFail($input['id']);
        try {
            if ($shopReview->hasMedia($input['collection'])) {
                $shopReview->getFirstMedia($input['collection'])->delete();
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
