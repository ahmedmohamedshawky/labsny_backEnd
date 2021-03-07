<?php
/**
 * File name: ClothesReviewController.php
 * Last modified: 2020.06.11 at 16:10:52
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 */

namespace App\Http\Controllers;

use App\Criteria\ClothesReviews\ClothesReviewsOfUserCriteria;
use App\DataTables\ClothesReviewDataTable;
use App\Http\Requests\CreateClothesReviewRequest;
use App\Http\Requests\UpdateClothesReviewRequest;
use App\Repositories\CustomFieldRepository;
use App\Repositories\ClothesRepository;
use App\Repositories\ClothesReviewRepository;
use App\Repositories\UserRepository;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class ClothesReviewController extends Controller
{
    /** @var  ClothesReviewRepository */
    private $clothesReviewRepository;

    /**
     * @var CustomFieldRepository
     */
    private $customFieldRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ClothesRepository
     */
    private $clothesRepository;

    public function __construct(ClothesReviewRepository $clothesReviewRepo, CustomFieldRepository $customFieldRepo, UserRepository $userRepo
        , ClothesRepository $clothesRepo)
    {
        parent::__construct();
        $this->clothesReviewRepository = $clothesReviewRepo;
        $this->customFieldRepository = $customFieldRepo;
        $this->userRepository = $userRepo;
        $this->clothesRepository = $clothesRepo;
    }

    /**
     * Display a listing of the ClothesReview.
     *
     * @param ClothesReviewDataTable $clothesReviewDataTable
     * @return Response
     */
    public function index(ClothesReviewDataTable $clothesReviewDataTable)
    {
        return $clothesReviewDataTable->render('clothes_reviews.index');
    }

    /**
     * Show the form for creating a new ClothesReview.
     *
     * @return Response
     */
    public function create()
    {
        $user = $this->userRepository->pluck('name', 'id');
        $clothes = $this->clothesRepository->groupedByShops();

        $hasCustomField = in_array($this->clothesReviewRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->clothesReviewRepository->model());
            $html = generateCustomField($customFields);
        }
        return view('clothes_reviews.create')->with("customFields", isset($html) ? $html : false)->with("user", $user)->with("clothes", $clothes);
    }

    /**
     * Store a newly created ClothesReview in storage.
     *
     * @param CreateClothesReviewRequest $request
     *
     * @return Response
     */
    public function store(CreateClothesReviewRequest $request)
    {
        $input = $request->all();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->clothesReviewRepository->model());
        try {
            $clothesReview = $this->clothesReviewRepository->create($input);
            $clothesReview->customFieldsValues()->createMany(getCustomFieldsValues($customFields, $request));

        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.saved_successfully', ['operator' => __('lang.clothes_review')]));

        return redirect(route('clothesReviews.index'));
    }

    /**
     * Display the specified ClothesReview.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function show($id)
    {
        $this->clothesReviewRepository->pushCriteria(new ClothesReviewsOfUserCriteria(auth()->id()));
        $clothesReview = $this->clothesReviewRepository->findWithoutFail($id);

        if (empty($clothesReview)) {
            Flash::error('Clothes Review not found');

            return redirect(route('clothesReviews.index'));
        }

        return view('clothes_reviews.show')->with('clothesReview', $clothesReview);
    }

    /**
     * Show the form for editing the specified ClothesReview.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function edit($id)
    {
        $this->clothesReviewRepository->pushCriteria(new ClothesReviewsOfUserCriteria(auth()->id()));
        $clothesReview = $this->clothesReviewRepository->findWithoutFail($id);
        if (empty($clothesReview)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.clothes_review')]));
            return redirect(route('clothesReviews.index'));
        }
        $user = $this->userRepository->pluck('name', 'id');
        $clothes = $this->clothesRepository->groupedByShops();


        $customFieldsValues = $clothesReview->customFieldsValues()->with('customField')->get();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->clothesReviewRepository->model());
        $hasCustomField = in_array($this->clothesReviewRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $html = generateCustomField($customFields, $customFieldsValues);
        }

        return view('clothes_reviews.edit')->with('clothesReview', $clothesReview)->with("customFields", isset($html) ? $html : false)->with("user", $user)->with("clothes", $clothes);
    }

    /**
     * Update the specified ClothesReview in storage.
     *
     * @param int $id
     * @param UpdateClothesReviewRequest $request
     *
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function update($id, UpdateClothesReviewRequest $request)
    {
        $this->clothesReviewRepository->pushCriteria(new ClothesReviewsOfUserCriteria(auth()->id()));
        $clothesReview = $this->clothesReviewRepository->findWithoutFail($id);

        if (empty($clothesReview)) {
            Flash::error('Clothes Review not found');
            return redirect(route('clothesReviews.index'));
        }
        $input = $request->all();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->clothesReviewRepository->model());
        try {
            $clothesReview = $this->clothesReviewRepository->update($input, $id);


            foreach (getCustomFieldsValues($customFields, $request) as $value) {
                $clothesReview->customFieldsValues()
                    ->updateOrCreate(['custom_field_id' => $value['custom_field_id']], $value);
            }
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.updated_successfully', ['operator' => __('lang.clothes_review')]));

        return redirect(route('clothesReviews.index'));
    }

    /**
     * Remove the specified ClothesReview from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function destroy($id)
    {
        $this->clothesReviewRepository->pushCriteria(new ClothesReviewsOfUserCriteria(auth()->id()));
        $clothesReview = $this->clothesReviewRepository->findWithoutFail($id);

        if (empty($clothesReview)) {
            Flash::error('Clothes Review not found');

            return redirect(route('clothesReviews.index'));
        }

        $this->clothesReviewRepository->delete($id);

        Flash::success(__('lang.deleted_successfully', ['operator' => __('lang.clothes_review')]));

        return redirect(route('clothesReviews.index'));
    }

    /**
     * Remove Media of ClothesReview
     * @param Request $request
     */
    public function removeMedia(Request $request)
    {
        $input = $request->all();
        $clothesReview = $this->clothesReviewRepository->findWithoutFail($input['id']);
        try {
            if ($clothesReview->hasMedia($input['collection'])) {
                $clothesReview->getFirstMedia($input['collection'])->delete();
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
