<?php

namespace App\Criteria\Categories;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CategoriesOfShopCriteria.
 *
 * @package namespace App\Criteria\Categories;
 */
class CategoriesOfShopCriteria implements CriteriaInterface
{
    /**
     * @var array
     */
    private $request;

    /**
     * CategoriesOfShopCriteria constructor.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
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
        if (!$this->request->has('shop_id')) {
            return $model;
        } else {
            $id = $this->request->get('shop_id');
            return $model->join('clothes', 'clothes.category_id', '=', 'categories.id')
                ->where('clothes.shop_id', $id)
                ->select('categories.*')
                ->groupBy('categories.id');
        }
    }
}
