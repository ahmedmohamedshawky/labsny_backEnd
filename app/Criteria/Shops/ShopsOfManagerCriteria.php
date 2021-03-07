<?php

namespace App\Criteria\Shops;

use App\Models\User;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ShopsOfManagerCriteria.
 *
 * @package namespace App\Criteria\Shops;
 */
class ShopsOfManagerCriteria implements CriteriaInterface
{
    /**
     * @var User
     */
    private $userId;

    /**
     * ShopsOfManagerCriteria constructor.
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
        return $model->join('user_shops','user_shops.shop_id','=','shops.id')
            ->where('user_shops.user_id',$this->userId);
    }
}
