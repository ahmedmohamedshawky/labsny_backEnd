<?php

namespace App\Http\Controllers;

use App\DataTables\ShopCategoryDataTable;
use App\Http\Requests\CreateShopCategoryRequest;
use App\Http\Requests\UpdateShopCategoryRequest;
use App\Repositories\ShopCategoryRepository;
use Flash;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class ShopCategoryController extends Controller
{
    /** @var  ShopCategoryRepository */
    private $shopCategoryRepository;

    public function __construct(ShopCategoryRepository $shopCategoryRepo)
    {
        parent::__construct();
        $this->shopCategoryRepository = $shopCategoryRepo;
    }

    /**
     * Display a listing of the Category.
     *
     * @param ShopCategoryDataTable $shopCategoryDataTable
     * @return Response
     */
    public function index(ShopCategoryDataTable $shopCategoryDataTable)
    {
        return $shopCategoryDataTable->render('shopCategories.index');
    }

    /**
     * Show the form for creating a new Category.
     *
     * @return Response
     */
    public function create()
    {
        return view('shopCategories.create');
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param CreateCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateShopCategoryRequest $request)
    {
        $input = $request->all();
        try {
            $shopCategories = $this->shopCategoryRepository->create($input);
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.saved_successfully', ['operator' => __('lang.shop_category')]));

        return redirect(route('shopCategories.index'));
    }

    /**
     * Display the specified Category.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $shopCategory = $this->shopCategoryRepository->findWithoutFail($id);

        if (empty($shopCategories)) {
            Flash::error('Category not found');

            return redirect(route('shopCategories.index'));
        }

        return view('shopCategories.show')->with('shopCategories', $shopCategory);
    }

    /**
     * Show the form for editing the specified Category.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $shopCategory = $this->shopCategoryRepository->findWithoutFail($id);

        if (empty($shopCategory)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.shop_category')]));

            return redirect(route('shopCategories.index'));
        }
        return view('shopCategories.edit')->with('shopCategory', $shopCategory);
    }

    /**
     * Update the specified Category in storage.
     *
     * @param int $id
     * @param UpdateShopCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateShopCategoryRequest $request)
    {
        $shopCategories = $this->shopCategoryRepository->findWithoutFail($id);

        if (empty($shopCategories)) {
            Flash::error('Category not found');
            return redirect(route('shopCategories.index'));
        }
        $input = $request->all();
        try {
            $shopCategories = $this->shopCategoryRepository->update($input, $id);

        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.updated_successfully', ['operator' => __('lang.shop_category')]));

        return redirect(route('shopCategories.index'));
    }

    /**
     * Remove the specified Category from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $shopCategories = $this->shopCategoryRepository->findWithoutFail($id);

        if (empty($shopCategories)) {
            Flash::error('Category not found');

            return redirect(route('shopCategories.index'));
        }

        $this->shopCategoryRepository->delete($id);

        Flash::success(__('lang.deleted_successfully', ['operator' => __('lang.shop_category')]));

        return redirect(route('shopCategories.index'));
    }
}
