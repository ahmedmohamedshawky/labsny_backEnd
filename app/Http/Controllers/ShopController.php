<?php
/**
 * File name: ShopController.php
 * Last modified: 2020.04.30 at 08:21:08
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App\Http\Controllers;

use App\Criteria\Shops\ShopsOfUserCriteria;
use App\Criteria\Users\AdminsCriteria;
use App\Criteria\Users\ClientsCriteria;
use App\Criteria\Users\ManagersClientsCriteria;
use App\Criteria\Users\ManagersCriteria;
use App\DataTables\ShopDataTable;
use App\DataTables\RequestedShopDataTable;
use App\Events\ShopChangedEvent;
use App\Http\Requests\CreateShopRequest;
use App\Http\Requests\UpdateShopRequest;
use App\Repositories\CustomFieldRepository;
use App\Repositories\ShopRepository;
use App\Repositories\UploadRepository;
use App\Repositories\UserRepository;
use App\Repositories\ShopCategoryRepository;
use App\Repositories\ShopCategoryShopRepository;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class ShopController extends Controller
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
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var ShopCategoryRepository
     */
    private $shopCategoryRepository;

    /**
     * @var ShopCategoryShopRepository
     */
    private $shopCategoryShopRepository;

    public function __construct(ShopRepository $shopRepo, CustomFieldRepository $customFieldRepo, 
            UploadRepository $uploadRepo, UserRepository $userRepo, ShopCategoryRepository $shopCategoryRepo,
            ShopCategoryShopRepository $shopCategoryShopRepo)
    {
        parent::__construct();
        $this->shopRepository = $shopRepo;
        $this->customFieldRepository = $customFieldRepo;
        $this->uploadRepository = $uploadRepo;
        $this->userRepository = $userRepo;
        $this->shopCategoryRepository = $shopCategoryRepo;
        $this->shopCategoryShopRepository = $shopCategoryShopRepo;
    }

    /**
     * Display a listing of the Shop.
     *
     * @param ShopDataTable $shopDataTable
     * @return Response
     */
    public function index(ShopDataTable $shopDataTable)
    {
        return $shopDataTable->render('shops.index');
    }

    /**
     * Display a listing of the Shop.
     *
     * @param ShopDataTable $shopDataTable
     * @return Response
     */
    public function requestedShops(RequestedShopDataTable $requestedShopDataTable)
    {
        return $requestedShopDataTable->render('shops.requested');
    }

    /**
     * Show the form for creating a new Shop.
     *
     * @return Response
     */
    public function create()
    {
        $user = $this->userRepository->getByCriteria(new ManagersCriteria())->pluck('name', 'id');
        $shopCategory = $this->shopCategoryRepository->pluck('name', 'id');
        $usersSelected = [];
        $driversSelected = [];
        $shopCategorySelected = [];
        $hasCustomField = in_array($this->shopRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->shopRepository->model());
            $html = generateCustomField($customFields);
        }
        return view('shops.create')->with("customFields", isset($html) ? $html : false)
                ->with("user", $user)
                ->with("usersSelected", $usersSelected)
                ->with("driversSelected", $driversSelected)
                ->with('shopCategory', $shopCategory)
                ->with('shopCategorySelected', $shopCategorySelected);
    }

    /**
     * Store a newly created Shop in storage.
     *
     * @param CreateShopRequest $request
     *
     * @return Response
     */
    public function store(CreateShopRequest $request)
    {
        \DB::beginTransaction();
        $input = $request->all();
        if (auth()->user()->hasRole(['manager','client'])) {
            $input['users'] = [auth()->id()];
        }
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->shopRepository->model());
        try {
            $shop = $this->shopRepository->create($input);
            foreach($input['shopCategory'] as $shopCategory){
                $this->shopCategoryShopRepository->create(array(
                    'shop_id' => $shop->id,
                    'shop_category_id' => $shopCategory
                ));
            }
            $shop->customFieldsValues()->createMany(getCustomFieldsValues($customFields, $request));
            if (isset($input['image']) && $input['image']) {
                $cacheUpload = $this->uploadRepository->getByUuid($input['image']);
                $mediaItem = $cacheUpload->getMedia('image')->first();
                $mediaItem->copy($shop, 'image');
            }
            event(new ShopChangedEvent($shop, $shop));
            \DB::commit();
        } catch (ValidatorException $e) {
            \DB::rollBack();
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.saved_successfully', ['operator' => __('lang.shop')]));

        return redirect(route('shops.index'));
    }

    /**
     * Display the specified Shop.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function show($id)
    {
        $this->shopRepository->pushCriteria(new ShopsOfUserCriteria(auth()->id()));
        $shop = $this->shopRepository->findWithoutFail($id);

        if (empty($shop)) {
            Flash::error('Shop not found');

            return redirect(route('shops.index'));
        }

        return view('shops.show')->with('shop', $shop);
    }

    /**
     * Show the form for editing the specified Shop.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function edit($id)
    {
        $this->shopRepository->pushCriteria(new ShopsOfUserCriteria(auth()->id()));
        $shop = $this->shopRepository->findWithoutFail($id);

        if (empty($shop)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.shop')]));
            return redirect(route('shops.index'));
        }
        if($shop['active'] == 0){
            $user = $this->userRepository->getByCriteria(new ManagersClientsCriteria())->pluck('name', 'id');
        } else {
        $user = $this->userRepository->getByCriteria(new ManagersCriteria())->pluck('name', 'id');
        }

        $usersSelected = $shop->users()->pluck('users.id')->toArray();
        $shopCategory = $this->shopCategoryRepository->pluck('name', 'id');
        // $shopCategorySelected = $this->shopCategoryShopRepository->with('shop_category')->where('shop_id', $shop->id)->get()->toArray();
        $shopCategorySelected = [];
        $customFieldsValues = $shop->customFieldsValues()->with('customField')->get();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->shopRepository->model());
        $hasCustomField = in_array($this->shopRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $html = generateCustomField($customFields, $customFieldsValues);
        }

        return view('shops.edit')->with('shop', $shop)->with("customFields", isset($html) ? $html : false)
            ->with("user", $user)
            ->with("usersSelected", $usersSelected)
            ->with('shopCategory', $shopCategory)
            ->with('shopCategorySelected', $shopCategorySelected);
    }

    /**
     * Update the specified Shop in storage.
     *
     * @param int $id
     * @param UpdateShopRequest $request
     *
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function update($id, UpdateShopRequest $request)
    {
        \DB::beginTransaction();
        $this->shopRepository->pushCriteria(new ShopsOfUserCriteria(auth()->id()));
        $oldShop = $this->shopRepository->findWithoutFail($id);

        if (empty($oldShop)) {
            Flash::error('Shop not found');
            return redirect(route('shops.index'));
        }
        $input = $request->all();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->shopRepository->model());
        try {
            $oldShop = $this->shopRepository->find($id);
            $shop = $this->shopRepository->update($input, $id);

            $this->shopCategoryShopRepository->where('shop_id', $shop->id)->delete();
            if(isset($input['shopCategory']))
                foreach($input['shopCategory'] as $shopCategory){
                    $this->shopCategoryShopRepository->create(array(
                        'shop_id' => $shop->id,
                        'shop_category_id' => $shopCategory
                    ));
                }

            if (isset($input['image']) && $input['image']) {
                $cacheUpload = $this->uploadRepository->getByUuid($input['image']);
                // return $cacheUpload;
                $mediaItem = $cacheUpload->getMedia('image')->first();
                $mediaItem->copy($shop, 'image');
            }
            foreach (getCustomFieldsValues($customFields, $request) as $value) {
                $shop->customFieldsValues()
                    ->updateOrCreate(['custom_field_id' => $value['custom_field_id']], $value);
            }
            event(new ShopChangedEvent($shop, $oldShop));
            \DB::commit();
        } catch (ValidatorException $e) {
            \DB::rollBack();
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.updated_successfully', ['operator' => __('lang.shop')]));

        return redirect(route('shops.index'));
    }

    /**
     * Remove the specified Shop from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function destroy($id)
    {
        if (!env('APP_DEMO', false)) {
            $this->shopRepository->pushCriteria(new ShopsOfUserCriteria(auth()->id()));
            $shop = $this->shopRepository->findWithoutFail($id);

            if (empty($shop)) {
                Flash::error('Shop not found');

                return redirect(route('shops.index'));
            }

            $this->shopRepository->delete($id);

            Flash::success(__('lang.deleted_successfully', ['operator' => __('lang.shop')]));
        } else {
            Flash::warning('This is only demo app you can\'t change this section ');
        }
        return redirect(route('shops.index'));
    }

    /**
     * Remove Media of Shop
     * @param Request $request
     */
    public function removeMedia(Request $request)
    {
        $input = $request->all();
        $shop = $this->shopRepository->findWithoutFail($input['id']);
        try {
            if ($shop->hasMedia($input['collection'])) {
                $shop->getFirstMedia($input['collection'])->delete();
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
