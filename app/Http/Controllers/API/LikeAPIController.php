<?php
/**
 * File name: likesAPIController.php
 * Last modified: 2020.05.04 at 09:04:19
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\like;
use App\Repositories\LikeRepository;
use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class likesController
 * @package App\Http\Controllers\API
 */
class LikeAPIController extends Controller
{
     /** @var  LikeRepository */
     private $likesRepository;
 
     public function __construct(LikeRepository $likeRepo)
     {
         parent::__construct();
         $this->likesRepository = $likeRepo;
     }
 
     /**
      * Display a listing of the like.
      *
      * @param likeDataTable $likeDataTable
      * @return Response
      */
 
    public function index(Request $request)
    {
        try{
            $this->likesRepository->pushCriteria(new RequestCriteria($request));
            $this->likesRepository->pushCriteria(new LimitOffsetCriteria($request));

            $likes = $this->likesRepository->get();

        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($likes->toArray(), 'likes retrieved successfully');
    }

    /**
     * Display the specified likes.
     * GET|HEAD /likes/{id}
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        /** @var likes $likes */
        if (!empty($this->likesRepository)) {
            try{
                $this->likesRepository->pushCriteria(new RequestCriteria($request));
                $this->likesRepository->pushCriteria(new LimitOffsetCriteria($request));
            } catch (RepositoryException $e) {
                return $this->sendError($e->getMessage());
            }
            $likes = $this->likesRepository->findWithoutFail($id);
        }

        if (empty($likes)) {
            return $this->sendError('likes not found');
        }

        return $this->sendResponse($likes->toArray(), 'likes retrieved successfully');
    }

    /**
     * Store a newly created likes in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();
        try {
            $likes = $this->likesRepository->create($input);
        } catch (ValidatorException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($likes->toArray(), __('lang.saved_successfully', ['operator' => __('lang.like')]));
    }

    /**
     * Update the specified likes in storage.
     *
     * @param int $id
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $likes = $this->likesRepository->findWithoutFail($id);

        if (empty($likes)) {
            return $this->sendError('likes not found');
        }
        $input = $request->all();
        try {
            $likes = $this->likesRepository->update($input, $id);
        } catch (ValidatorException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($likes->toArray(), __('lang.updated_successfully', ['operator' => __('lang.like')]));

    }

    /**
     * Remove the specified likes from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $likes = $this->likesRepository->findWithoutFail($id);

        if (empty($likes)) {
            return $this->sendError('likes not found');
        }

        $likes = $this->likesRepository->delete($id);

        return $this->sendResponse($likes, __('lang.deleted_successfully', ['operator' => __('lang.like')]));

    }

}
