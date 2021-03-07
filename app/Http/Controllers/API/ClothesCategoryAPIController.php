<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ClothesCategoryRepository;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

class ClothesCategoryAPIController extends Controller
{
    /** @var  ClothesCategoryRepository */
    private $clothesCategoryRepository;

    public function __construct(ClothesCategoryRepository $clothesCategoryRepo)
    {
        parent::__construct();
        $this->clothesCategoryRepository = $clothesCategoryRepo;
    }

    public function index(Request $request)
    {
        try{
            $this->clothesCategoryRepository->pushCriteria(new RequestCriteria($request));
            $this->clothesCategoryRepository->pushCriteria(new LimitOffsetCriteria($request));

            $clothesCategory = $this->clothesCategoryRepository->get();
        } catch (RepositoryException $e) {
            return '$this->sendError($e->getMessage())';
        }

        return $this->sendResponse($clothesCategory->toArray(), 'Clothes Category retrieved successfully');
    }
}
