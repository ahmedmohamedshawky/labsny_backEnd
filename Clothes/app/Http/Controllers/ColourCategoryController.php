<?php

namespace App\Http\Controllers;

use App\DataTables\ColourCategoryDataTable;
use App\Repositories\UploadRepository;
use App\Http\Requests\CreateColourCategoryRequest;
use App\Http\Requests\UpdateColourCategoryRequest;
use App\Models\ColourCategory;
use App\Repositories\ColourCategoryRepository;
use Flash;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class ColourCategoryController extends Controller
{
    /** @var  ColourCategoryRepository */
    private $colourCategoryRepository;

    /**
     * @var UploadRepository
     */
    private $uploadRepository;

    public function __construct(ColourCategoryRepository $colourCategoryRepo, UploadRepository $uploadRepo)
    {
        parent::__construct();
        $this->colourCategoryRepository = $colourCategoryRepo;
        $this->uploadRepository = $uploadRepo;
    }

    /**
     * Display a listing of the Category.
     *
     * @param ColourCategoryDataTable $colourCategoryDataTable
     * @return Response
     */
    public function index(ColourCategoryDataTable $colourCategoryDataTable)
    {
        return $colourCategoryDataTable->render('colourCategories.index');
    }

    /**
     * Show the form for creating a new Category.
     *
     * @return Response
     */
    public function create()
    {
        return view('colourCategories.create');
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param CreateCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateColourCategoryRequest $request)
    {
        $input = $request->all();
        try {
            $colourCategories = $this->colourCategoryRepository->create($input);
            if (isset($input['image']) && $input['image']) {
                $cacheUpload = $this->uploadRepository->getByUuid($input['image']);
                $mediaItem = $cacheUpload->getMedia('image')->first();
                $mediaItem->copy($colourCategories, 'image');
            }
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.saved_successfully', ['operator' => __('lang.colour_category')]));

        return redirect(route('colourCategories.index'));
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
        $colourCategory = $this->colourCategoryRepository->findWithoutFail($id);

        if (empty($colourCategories)) {
            Flash::error('Category not found');

            return redirect(route('colourCategories.index'));
        }

        return view('colourCategories.show')->with('colourCategories', $colourCategory);
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
        $colourCategory = $this->colourCategoryRepository->findWithoutFail($id);

        if (empty($colourCategory)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.colour_category')]));

            return redirect(route('colourCategories.index'));
        }
        return view('colourCategories.edit')->with('colourCategory', $colourCategory);
    }

    /**
     * Update the specified Category in storage.
     *
     * @param int $id
     * @param UpdateColourCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateColourCategoryRequest $request)
    {
        $colourCategories = $this->colourCategoryRepository->findWithoutFail($id);

        if (empty($colourCategories)) {
            Flash::error('Category not found');
            return redirect(route('colourCategories.index'));
        }
        $input = $request->all();
        try {
            $colourCategories = $this->colourCategoryRepository->update($input, $id);
            if (isset($input['image']) && $input['image']) {
                $cacheUpload = $this->uploadRepository->getByUuid($input['image']);
                $mediaItem = $cacheUpload->getMedia('image')->first();
                $mediaItem->copy($colourCategories, 'image');
            }

        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.updated_successfully', ['operator' => __('lang.colour_category')]));

        return redirect(route('colourCategories.index'));
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
        $colourCategories = $this->colourCategoryRepository->findWithoutFail($id);

        if (empty($colourCategories)) {
            Flash::error('Category not found');

            return redirect(route('colourCategories.index'));
        }

        $this->colourCategoryRepository->delete($id);

        Flash::success(__('lang.deleted_successfully', ['operator' => __('lang.colour_category')]));

        return redirect(route('colourCategories.index'));
    }
}
