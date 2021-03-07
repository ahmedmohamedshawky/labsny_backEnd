<?php
/**
 * File name: CouponsOfUserCriteria.php
 * Last modified: 2020.08.27 at 22:18:49
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 */

namespace App\Criteria\Coupons;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CouponsOfUserCriteria.
 *
 * @package namespace App\Criteria\Coupons;
 */
class CouponsOfUserCriteria implements CriteriaInterface
{
    /**
     * @var int
     */
    private $userId;

    /**
     * CouponsOfUserCriteria constructor.
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if (auth()->user()->hasRole('admin')) {
            return $model;
        }elseif (auth()->user()->hasRole('manager')){
            $shops = $model->join("discountables", "discountables.coupon_id", "=", "coupons.id")
                ->join("user_shops", "user_shops.shop_id", "=", "discountables.discountable_id")
                ->where('discountable_type','App\\Models\\Shop')
                ->where("user_shops.user_id",$this->userId)
                ->select("coupons.*");

            $clothes = $model->join("discountables", "discountables.coupon_id", "=", "coupons.id")
                ->join("clothes", "clothes.id", "=", "discountables.discountable_id")
                ->where('discountable_type','App\\Models\\Clothes')
                ->join("user_shops", "user_shops.shop_id", "=", "clothes.shop_id")
                ->where("user_shops.user_id",$this->userId)
                ->select("coupons.*")
                ->union($shops);
            return $clothes;
        }else{
            return $model;
        }

    }
}
