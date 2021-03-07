<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ColourCategoryRepository;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

class ColourCategoryAPIController extends Controller
{
    /** @var  ColourCategoryRepository */
    private $colourCategoryRepository;

    public function __construct(ColourCategoryRepository $colourCategoryRepo)
    {
        parent::__construct();
        $this->colourCategoryRepository = $colourCategoryRepo;
    }

    public function index(Request $request)
    {
        try{
            $this->colourCategoryRepository->pushCriteria(new RequestCriteria($request));
            $this->colourCategoryRepository->pushCriteria(new LimitOffsetCriteria($request));

            $colourCategory = $this->colourCategoryRepository->get();
        } catch (RepositoryException $e) {
            return '$this->sendError($e->getMessage())';
        }

        return $this->sendResponse($colourCategory->toArray(), 'Colours Category retrieved successfully');
    }
}
