<?php
/**
 * File name: OrderShopReviewsOfUserCriteria.php
 * Last modified: 2020.05.04 at 09:04:19
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App\Criteria\ShopReviews;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OrderShopReviewsOfUserCriteria.
 *
 * @package namespace App\Criteria\ShopReviews;
 */
class OrderShopReviewsOfUserCriteria implements CriteriaInterface
{
    /**
     * @var int
     */
    private $userId;

    /**
     * OrderShopReviewsOfUserCriteria constructor.
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
            return $model->select('shop_reviews.*');
        } else if (auth()->user()->hasRole('manager')) {
            return $model->join("user_shops", "user_shops.shop_id", "=", "shop_reviews.shop_id")
                ->where('user_shops.user_id', $this->userId)
                ->groupBy('shop_reviews.id')
                ->select('shop_reviews.*');
        } else if (auth()->user()->hasRole('driver')) {
            return $model->join("driver_shops", "driver_shops.shop_id", "=", "shop_reviews.shop_id")
                ->where('driver_shops.user_id', $this->userId)
                ->groupBy('shop_reviews.id')
                ->select('shop_reviews.*');
        } else if (auth()->user()->hasRole('client')) {
            return $model->newQuery()->join("clothes", "clothes.shop_id", "=", "shop_reviews.shop_id")
                ->join("clothes_orders", "clothes.id", "=", "clothes_orders.clothes_id")
                ->join("orders", "orders.id", "=", "clothes_orders.order_id")
                ->where('orders.user_id', $this->userId)
                ->groupBy("shop_reviews.id")
                ->select("shop_reviews.*");
        }
    }
}
