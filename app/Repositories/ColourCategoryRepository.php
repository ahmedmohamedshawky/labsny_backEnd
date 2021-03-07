<?php

namespace App\Repositories;

use App\Models\ColourCategory;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ColourCategoryRepository
 * @package App\Repositories
 * @version May 29, 2018, 5:23 pm UTC
 *
 * @method ColourCategory findWithoutFail($id, $columns = ['*'])
 * @method ColourCategory find($id, $columns = ['*'])
 * @method ColourCategory first($columns = ['*'])
*/
class ColourCategoryRepository extends BaseRepository
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
        return ColourCategory::class;
    }
}
