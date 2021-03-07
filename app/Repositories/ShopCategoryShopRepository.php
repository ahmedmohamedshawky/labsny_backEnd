<?php

namespace App\Repositories;

use App\Models\ShopCategoryShop;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class RoleRepository
 * @package App\Repositories
 * @version May 29, 2018, 5:23 pm UTC
 *
 * @method Role findWithoutFail($id, $columns = ['*'])
 * @method Role find($id, $columns = ['*'])
 * @method Role first($columns = ['*'])
*/
class ShopCategoryShopRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'shop_id',
        'shop_category_id',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ShopCategoryShop::class;
    }
}
