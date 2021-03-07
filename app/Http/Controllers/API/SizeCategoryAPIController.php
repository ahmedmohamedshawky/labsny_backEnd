<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SizeCategoryRepository;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

class SizeCategoryAPIController extends Controller
{
    /** @var  SizeCategoryRepository */
    private $sizeCategoryRepository;

    public function __construct(SizeCategoryRepository $sizeCategoryRepo)
    {
        parent::__construct();
        $this->sizeCategoryRepository = $sizeCategoryRepo;
    }

    public function index(Request $request)
    {
        try{
            $this->sizeCategoryRepository->pushCriteria(new RequestCriteria($request));
            $this->sizeCategoryRepository->pushCriteria(new LimitOffsetCriteria($request));

            $sizeCategory = $this->sizeCategoryRepository->get();
        } catch (RepositoryException $e) {
            return '$this->sendError($e->getMessage())';
        }

        return $this->sendResponse($sizeCategory->toArray(), 'Sizes Category retrieved successfully');
    }
}
