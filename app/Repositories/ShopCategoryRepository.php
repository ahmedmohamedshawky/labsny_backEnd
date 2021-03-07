<?php

namespace App\Repositories;

use App\Models\ShopCategory;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ShopCategoryRepository
 * @package App\Repositories
 * @version May 29, 2018, 5:23 pm UTC
 *
 * @method ShopCategory findWithoutFail($id, $columns = ['*'])
 * @method ShopCategory find($id, $columns = ['*'])
 * @method ShopCategory first($columns = ['*'])
*/
class ShopCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ShopCategory::class;
    }
}
