<?php

namespace App\Http\Controllers;

use App\DataTables\ClothesCategoryDataTable;
use App\Http\Requests\CreateClothesCategoryRequest;
use App\Http\Requests\UpdateClothesCategoryRequest;
use App\Repositories\ClothesCategoryRepository;
use Flash;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class ClothesCategoryController extends Controller
{
    /** @var  ClothesCategoryRepository */
    private $clothesCategoryRepository;

    public function __construct(ClothesCategoryRepository $clothesCategoryRepo)
    {
        parent::__construct();
        $this->clothesCategoryRepository = $clothesCategoryRepo;
    }

    /**
     * Display a listing of the Category.
     *
     * @param ClothesCategoryDataTable $clothesCategoryDataTable
     * @return Response
     */
    public function index(ClothesCategoryDataTable $clothesCategoryDataTable)
    {
        return $clothesCategoryDataTable->render('clothesCategories.index');
    }

    /**
     * Show the form for creating a new Category.
     *
     * @return Response
     */
    public function create()
    {
        return view('clothesCategories.create');
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param CreateCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateClothesCategoryRequest $request)
    {
        $input = $request->all();
        try {
            $clothesCategories = $this->clothesCategoryRepository->create($input);
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.saved_successfully', ['operator' => __('lang.clothes_category')]));

        return redirect(route('clothesCategories.index'));
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
        $clothesCategory = $this->clothesCategoryRepository->findWithoutFail($id);

        if (empty($clothesCategories)) {
            Flash::error('Category not found');

            return redirect(route('clothesCategories.index'));
        }

        return view('clothesCategories.show')->with('clothesCategories', $clothesCategory);
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
        $clothesCategory = $this->clothesCategoryRepository->findWithoutFail($id);

        if (empty($clothesCategory)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.clothes_category')]));

            return redirect(route('clothesCategories.index'));
        }
        return view('clothesCategories.edit')->with('clothesCategory', $clothesCategory);
    }

    /**
     * Update the specified Category in storage.
     *
     * @param int $id
     * @param UpdateClothesCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateClothesCategoryRequest $request)
    {
        $clothesCategories = $this->clothesCategoryRepository->findWithoutFail($id);

        if (empty($clothesCategories)) {
            Flash::error('Category not found');
            return redirect(route('clothesCategories.index'));
        }
        $input = $request->all();
        try {
            $clothesCategories = $this->clothesCategoryRepository->update($input, $id);

        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.updated_successfully', ['operator' => __('lang.clothes_category')]));

        return redirect(route('clothesCategories.index'));
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
        $clothesCategories = $this->clothesCategoryRepository->findWithoutFail($id);

        if (empty($clothesCategories)) {
            Flash::error('Category not found');

            return redirect(route('clothesCategories.index'));
        }

        $this->clothesCategoryRepository->delete($id);

        Flash::success(__('lang.deleted_successfully', ['operator' => __('lang.clothes_category')]));

        return redirect(route('clothesCategories.index'));
    }
}
