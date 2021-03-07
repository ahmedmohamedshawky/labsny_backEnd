<?php
/**
 * File name: ClothesReviewsOfUserCriteria.php
 * Last modified: 2020.05.04 at 09:04:18
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App\Criteria\ClothesReviews;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ClothesReviewsOfUserCriteria.
 *
 * @package namespace App\Criteria\ClothesReviews;
 */
class ClothesReviewsOfUserCriteria implements CriteriaInterface
{
    /**
     * @var int
     */
    private $userId;

    /**
     * ClothesReviewsOfUserCriteria constructor.
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Apply criteria in query repository
     *
     * @param string $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if (auth()->user()->hasRole('admin')) {
            return $model->select('clothes_reviews.*');
        } else if (auth()->user()->hasRole('manager')) {
            return $model->join("clothes", "clothes.id", "=", "clothes_reviews.clothes_id")
                ->join("user_shops", "user_shops.shop_id", "=", "clothes.shop_id")
                ->where('user_shops.user_id', $this->userId)
                ->groupBy('clothes_reviews.id')
                ->select('clothes_reviews.*');
        } else if (auth()->user()->hasRole('client')) {
            return $model->newQuery()->where('clothes_reviews.user_id', $this->userId)
                ->select('clothes_reviews.*');
        } else {
            return $model->select('clothes_reviews.*');
        }
    }
}
