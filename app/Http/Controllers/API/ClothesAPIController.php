<?php
/**
 * File name: ClothesAPIController.php
 * Last modified: 2020.05.04 at 09:04:19
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App\Http\Controllers\API;


use App\Criteria\Clothes\NearCriteria;
use App\Criteria\Clothes\ClothesOfCategoriesCriteria;
use App\Criteria\Clothes\TrendingWeekCriteria;
use App\Http\Controllers\Controller;
use App\Models\Clothes;
use App\Repositories\CustomFieldRepository;
use App\Repositories\ClothesRepository;
use App\Repositories\UploadRepository;
use Flash;
use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class ClothesController
 * @package App\Http\Controllers\API
 */
class ClothesAPIController extends Controller
{
    /** @var  ClothesRepository */
    private $clothesRepository;
    /**
     * @var CustomFieldRepository
     */
    private $customFieldRepository;
    /**
     * @var UploadRepository
     */
    private $uploadRepository;


    public function __construct(ClothesRepository $clothesRepo, CustomFieldRepository $customFieldRepo, UploadRepository $uploadRepo)
    {
        parent::__construct();
        $this->clothesRepository = $clothesRepo;
        $this->customFieldRepository = $customFieldRepo;
        $this->uploadRepository = $uploadRepo;
    }

    /**
     * Display a listing of the Clothes.
     * GET|HEAD /clothes
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try{
            $this->clothesRepository->pushCriteria(new RequestCriteria($request));
            $this->clothesRepository->pushCriteria(new LimitOffsetCriteria($request));
            if ($request->get('trending', null) == 'week') {
                $this->clothesRepository->pushCriteria(new TrendingWeekCriteria($request));
            } else {
                $this->clothesRepository->pushCriteria(new NearCriteria($request));
            }
            $clothes = $this->clothesRepository->with('clothesSizes')->all();

        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($clothes->toArray(), 'Clothes retrieved successfully');
    }

    /**
     * Display a listing of the Clothes.
     * GET|HEAD /clothes/categories
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function categories(Request $request)
    {
        try{
            $this->clothesRepository->pushCriteria(new RequestCriteria($request));
            $this->clothesRepository->pushCriteria(new LimitOffsetCriteria($request));

            $clothes = $this->clothesRepository->all();

        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($clothes->toArray(), 'Clothes retrieved successfully');
    }

    /**
     * Display the specified Clothes.
     * GET|HEAD /clothes/{id}
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        /** @var Clothes $clothes */
        if (!empty($this->clothesRepository)) {
            try{
                $this->clothesRepository->pushCriteria(new RequestCriteria($request));
                $this->clothesRepository->pushCriteria(new LimitOffsetCriteria($request));
            } catch (RepositoryException $e) {
                return $this->sendError($e->getMessage());
            }
            $clothes = $this->clothesRepository->findWithoutFail($id);
        }

        if (empty($clothes)) {
            return $this->sendError('Clothes not found');
        }

        return $this->sendResponse($clothes->toArray(), 'Clothes retrieved successfully');
    }

    /**
     * Store a newly created Clothes in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->clothesRepository->model());
        try {
            $clothes = $this->clothesRepository->create($input);
            $clothes->customFieldsValues()->createMany(getCustomFieldsValues($customFields, $request));
            if (isset($input['image']) && $input['image']) {
                $cacheUpload = $this->uploadRepository->getByUuid($input['image']);
                $mediaItem = $cacheUpload->getMedia('image')->first();
                $mediaItem->copy($clothes, 'image');
            }
        } catch (ValidatorException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($clothes->toArray(), __('lang.saved_successfully', ['operator' => __('lang.clothes')]));
    }

    /**
     * Update the specified Clothes in storage.
     *
     * @param int $id
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $clothes = $this->clothesRepository->findWithoutFail($id);

        if (empty($clothes)) {
            return $this->sendError('Clothes not found');
        }
        $input = $request->all();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->clothesRepository->model());
        try {
            $clothes = $this->clothesRepository->update($input, $id);

            if (isset($input['image']) && $input['image']) {
                $cacheUpload = $this->uploadRepository->getByUuid($input['image']);
                $mediaItem = $cacheUpload->getMedia('image')->first();
                $mediaItem->copy($clothes, 'image');
            }
            foreach (getCustomFieldsValues($customFields, $request) as $value) {
                $clothes->customFieldsValues()
                    ->updateOrCreate(['custom_field_id' => $value['custom_field_id']], $value);
            }
        } catch (ValidatorException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($clothes->toArray(), __('lang.updated_successfully', ['operator' => __('lang.clothes')]));

    }

    /**
     * Remove the specified Clothes from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $clothes = $this->clothesRepository->findWithoutFail($id);

        if (empty($clothes)) {
            return $this->sendError('Clothes not found');
        }

        $clothes = $this->clothesRepository->delete($id);

        return $this->sendResponse($clothes, __('lang.deleted_successfully', ['operator' => __('lang.clothes')]));

    }

}
