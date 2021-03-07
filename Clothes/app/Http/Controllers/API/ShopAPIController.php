<?php
/**
 * File name: ShopAPIController.php
 * Last modified: 2020.05.04 at 09:04:19
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App\Http\Controllers\API;


use App\Criteria\Shops\ActiveCriteria;
use App\Criteria\Shops\NearCriteria;
use App\Criteria\Shops\PopularCriteria;
use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Repositories\CustomFieldRepository;
use App\Repositories\ShopRepository;
use App\Repositories\UploadRepository;
use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class ShopController
 * @package App\Http\Controllers\API
 */
class ShopAPIController extends Controller
{
    /** @var  ShopRepository */
    private $shopRepository;

    /**
     * @var CustomFieldRepository
     */
    private $customFieldRepository;

    /**
     * @var UploadRepository
     */
    private $uploadRepository;


    public function __construct(ShopRepository $shopRepo, CustomFieldRepository $customFieldRepo, UploadRepository $uploadRepo)
    {
        parent::__construct();
        $this->shopRepository = $shopRepo;
        $this->customFieldRepository = $customFieldRepo;
        $this->uploadRepository = $uploadRepo;

    }

    /**
     * Display a listing of the Shop.
     * GET|HEAD /shops
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $this->shopRepository->pushCriteria(new RequestCriteria($request));
            $this->shopRepository->pushCriteria(new LimitOffsetCriteria($request));
            if ($request->has('popular')) {
                $this->shopRepository->pushCriteria(new PopularCriteria($request));
            } else {
                $this->shopRepository->pushCriteria(new NearCriteria($request));
            }
            $this->shopRepository->pushCriteria(new ActiveCriteria());
            $shops = $this->shopRepository->all();

        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($shops->toArray(), 'Shops retrieved successfully');
    }

    /**
     * Display the specified Shop.
     * GET|HEAD /shops/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        /** @var Shop $shop */
        if (!empty($this->shopRepository)) {
            try {
                $this->shopRepository->pushCriteria(new RequestCriteria($request));
                $this->shopRepository->pushCriteria(new LimitOffsetCriteria($request));
                if ($request->has(['myLon', 'myLat', 'areaLon', 'areaLat'])) {
                    $this->shopRepository->pushCriteria(new NearCriteria($request));
                }
            } catch (RepositoryException $e) {
                return $this->sendError($e->getMessage());
            }
            $shop = $this->shopRepository->findWithoutFail($id);
        }

        if (empty($shop)) {
            return $this->sendError('Shop not found');
        }

        return $this->sendResponse($shop->toArray(), 'Shop retrieved successfully');
    }

    /**
     * Store a newly created Shop in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();
        if (auth()->user()->hasRole('manager')) {
            $input['users'] = [auth()->id()];
        }
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->shopRepository->model());
        try {
            $shop = $this->shopRepository->create($input);
            $shop->customFieldsValues()->createMany(getCustomFieldsValues($customFields, $request));
            if (isset($input['image']) && $input['image']) {
                $cacheUpload = $this->uploadRepository->getByUuid($input['image']);
                $mediaItem = $cacheUpload->getMedia('image')->first();
                $mediaItem->copy($shop, 'image');
            }
        } catch (ValidatorException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($shop->toArray(), __('lang.saved_successfully', ['operator' => __('lang.shop')]));
    }

    /**
     * Update the specified Shop in storage.
     *
     * @param int $id
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $shop = $this->shopRepository->findWithoutFail($id);

        if (empty($shop)) {
            return $this->sendError('Shop not found');
        }
        $input = $request->all();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->shopRepository->model());
        try {
            $shop = $this->shopRepository->update($input, $id);
            $input['users'] = isset($input['users']) ? $input['users'] : [];
            $input['drivers'] = isset($input['drivers']) ? $input['drivers'] : [];
            if (isset($input['image']) && $input['image']) {
                $cacheUpload = $this->uploadRepository->getByUuid($input['image']);
                $mediaItem = $cacheUpload->getMedia('image')->first();
                $mediaItem->copy($shop, 'image');
            }
            foreach (getCustomFieldsValues($customFields, $request) as $value) {
                $shop->customFieldsValues()
                    ->updateOrCreate(['custom_field_id' => $value['custom_field_id']], $value);
            }
        } catch (ValidatorException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($shop->toArray(), __('lang.updated_successfully', ['operator' => __('lang.shop')]));
    }

    /**
     * Remove the specified Shop from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $shop = $this->shopRepository->findWithoutFail($id);

        if (empty($shop)) {
            return $this->sendError('Shop not found');
        }

        $shop = $this->shopRepository->delete($id);

        return $this->sendResponse($shop, __('lang.deleted_successfully', ['operator' => __('lang.shop')]));
    }
}
