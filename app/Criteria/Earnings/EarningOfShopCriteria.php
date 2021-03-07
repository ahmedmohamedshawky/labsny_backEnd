<?php

namespace App\Criteria\Earnings;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class EarningOfShopCriteriaCriteria.
 *
 * @package namespace App\Criteria\Earnings;
 */
class EarningOfShopCriteria implements CriteriaInterface
{
    private $shopId;

    /**
     * EarningOfShopCriteriaCriteria constructor.
     */
    public function __construct($shopId)
    {
        $this->shopId = $shopId;
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
        return $model->where("shop_id",$this->shopId);
    }
}
