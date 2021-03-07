<?php

namespace App\Http\Controllers;

use App\DataTables\SizeCategoryDataTable;
use App\Http\Requests\CreateSizeCategoryRequest;
use App\Http\Requests\UpdateSizeCategoryRequest;
use App\Repositories\SizeCategoryRepository;
use Flash;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class SizeCategoryController extends Controller
{
    /** @var  SizeCategoryRepository */
    private $sizeCategoryRepository;

    public function __construct(SizeCategoryRepository $sizeCategoryRepo)
    {
        parent::__construct();
        $this->sizeCategoryRepository = $sizeCategoryRepo;
    }

    /**
     * Display a listing of the Category.
     *
     * @param SizeCategoryDataTable $sizeCategoryDataTable
     * @return Response
     */
    public function index(SizeCategoryDataTable $sizeCategoryDataTable)
    {
        return $sizeCategoryDataTable->render('sizeCategories.index');
    }

    /**
     * Show the form for creating a new Category.
     *
     * @return Response
     */
    public function create()
    {
        return view('sizeCategories.create');
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param CreateCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateSizeCategoryRequest $request)
    {
        $input = $request->all();
        try {
            $sizeCategories = $this->sizeCategoryRepository->create($input);
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.saved_successfully', ['operator' => __('lang.size_category')]));

        return redirect(route('sizeCategories.index'));
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
        $sizeCategory = $this->sizeCategoryRepository->findWithoutFail($id);

        if (empty($sizeCategories)) {
            Flash::error('Category not found');

            return redirect(route('sizeCategories.index'));
        }

        return view('sizeCategories.show')->with('sizeCategories', $sizeCategory);
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
        $sizeCategory = $this->sizeCategoryRepository->findWithoutFail($id);

        if (empty($sizeCategory)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.size_category')]));

            return redirect(route('sizeCategories.index'));
        }
        return view('sizeCategories.edit')->with('sizeCategory', $sizeCategory);
    }

    /**
     * Update the specified Category in storage.
     *
     * @param int $id
     * @param UpdateSizeCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSizeCategoryRequest $request)
    {
        $sizeCategories = $this->sizeCategoryRepository->findWithoutFail($id);

        if (empty($sizeCategories)) {
            Flash::error('Category not found');
            return redirect(route('sizeCategories.index'));
        }
        $input = $request->all();
        try {
            $sizeCategories = $this->sizeCategoryRepository->update($input, $id);

        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.updated_successfully', ['operator' => __('lang.size_category')]));

        return redirect(route('sizeCategories.index'));
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
        $sizeCategories = $this->sizeCategoryRepository->findWithoutFail($id);

        if (empty($sizeCategories)) {
            Flash::error('Category not found');

            return redirect(route('sizeCategories.index'));
        }

        $this->sizeCategoryRepository->delete($id);

        Flash::success(__('lang.deleted_successfully', ['operator' => __('lang.size_category')]));

        return redirect(route('sizeCategories.index'));
    }
}
