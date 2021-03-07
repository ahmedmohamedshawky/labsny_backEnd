<?php
/**
 * File name: OffersAPIController.php
 * Last modified: 2020.05.04 at 09:04:19
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App\Http\Controllers\API;


use App\Criteria\Offers\NearCriteria;
use App\Criteria\Offers\OffersOfCategoriesCriteria;
use App\Criteria\Offers\OffersOfCuisinesCriteria;
use App\Criteria\Offers\TrendingWeekCriteria;
use App\Http\Controllers\Controller;
use App\Models\Offers;
use App\Repositories\CustomFieldRepository;
use App\Repositories\ShopRepository;
use App\Repositories\UploadRepository;
use App\Repositories\OfferRepository;
use Flash;
use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class OffersController
 * @package App\Http\Controllers\API
 */
class OfferAPIController extends Controller
{
     /** @var  OfferRepository */
     private $offerRepository;

     /**
      * @var CustomFieldRepository
      */
     private $customFieldRepository;
 
     /**
      * @var ShopRepository
      */
     private $shopRepository;
 
     /**
      * @var UploadRepository
      */
     private $uploadRepository;
 
     public function __construct(OfferRepository $offerRepo, CustomFieldRepository $customFieldRepo, UploadRepository $uploadRepo,
                                 ShopRepository $shopRepo)
     {
         parent::__construct();
         $this->offersRepository = $offerRepo;
         $this->customFieldRepository = $customFieldRepo;
         $this->uploadRepository = $uploadRepo;
         $this->shopRepository = $shopRepo;
     }
 
     /**
      * Display a listing of the Offer.
      *
      * @param OfferDataTable $offerDataTable
      * @return Response
      */
 
    public function index(Request $request)
    {
        try{
            $this->offersRepository->pushCriteria(new RequestCriteria($request));
            $this->offersRepository->pushCriteria(new LimitOffsetCriteria($request));

            $offers = $this->offersRepository->where('active', true)->get();

        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($offers->toArray(), 'Offers retrieved successfully');
    }

    /**
     * Display a listing of the Offers.
     * GET|HEAD /offers/categories
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function categories(Request $request)
    {
        try{
            $this->offersRepository->pushCriteria(new RequestCriteria($request));
            $this->offersRepository->pushCriteria(new LimitOffsetCriteria($request));

            $offers = $this->offersRepository->all();

        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($offers->toArray(), 'Offers retrieved successfully');
    }

    /**
     * Display the specified Offers.
     * GET|HEAD /offers/{id}
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        /** @var Offers $offers */
        if (!empty($this->offersRepository)) {
            try{
                $this->offersRepository->pushCriteria(new RequestCriteria($request));
                $this->offersRepository->pushCriteria(new LimitOffsetCriteria($request));
            } catch (RepositoryException $e) {
                return $this->sendError($e->getMessage());
            }
            $offers = $this->offersRepository->findWithoutFail($id);
        }

        if (empty($offers)) {
            return $this->sendError('Offers not found');
        }

        return $this->sendResponse($offers->toArray(), 'Offers retrieved successfully');
    }

    /**
     * Store a newly created Offers in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->offersRepository->model());
        try {
            $offers = $this->offersRepository->create($input);
            $offers->customFieldsValues()->createMany(getCustomFieldsValues($customFields, $request));
            if (isset($input['image']) && $input['image']) {
                $cacheUpload = $this->uploadRepository->getByUuid($input['image']);
                $mediaItem = $cacheUpload->getMedia('image')->first();
                $mediaItem->copy($offers, 'image');
            }
        } catch (ValidatorException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($offers->toArray(), __('lang.saved_successfully', ['operator' => __('lang.offers')]));
    }

    /**
     * Update the specified Offers in storage.
     *
     * @param int $id
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $offers = $this->offersRepository->findWithoutFail($id);

        if (empty($offers)) {
            return $this->sendError('Offers not found');
        }
        $input = $request->all();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->offersRepository->model());
        try {
            $offers = $this->offersRepository->update($input, $id);

            if (isset($input['image']) && $input['image']) {
                $cacheUpload = $this->uploadRepository->getByUuid($input['image']);
                $mediaItem = $cacheUpload->getMedia('image')->first();
                $mediaItem->copy($offers, 'image');
            }
            foreach (getCustomFieldsValues($customFields, $request) as $value) {
                $offers->customFieldsValues()
                    ->updateOrCreate(['custom_field_id' => $value['custom_field_id']], $value);
            }
        } catch (ValidatorException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($offers->toArray(), __('lang.updated_successfully', ['operator' => __('lang.offers')]));

    }

    /**
     * Remove the specified Offers from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $offers = $this->offersRepository->findWithoutFail($id);

        if (empty($offers)) {
            return $this->sendError('Offers not found');
        }

        $offers = $this->offersRepository->delete($id);

        return $this->sendResponse($offers, __('lang.deleted_successfully', ['operator' => __('lang.offers')]));

    }

}
