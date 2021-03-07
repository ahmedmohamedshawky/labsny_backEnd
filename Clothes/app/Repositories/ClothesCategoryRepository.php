<?php

namespace App\Repositories;

use App\Models\ClothesCategory;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ClothesCategoryRepository
 * @package App\Repositories
 * @version May 29, 2018, 5:23 pm UTC
 *
 * @method ClothesCategory findWithoutFail($id, $columns = ['*'])
 * @method ClothesCategory find($id, $columns = ['*'])
 * @method ClothesCategory first($columns = ['*'])
*/
class ClothesCategoryRepository extends BaseRepository
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
        return ClothesCategory::class;
    }
}
