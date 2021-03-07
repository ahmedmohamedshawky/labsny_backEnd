<?php

namespace App\Repositories;

use App\Models\Like;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class LikeRepository
 * @package App\Repositories
 * @version April 11, 2020, 1:57 pm UTC
 *
 * @method Like findWithoutFail($id, $columns = ['*'])
 * @method Like find($id, $columns = ['*'])
 * @method Like first($columns = ['*'])
*/
class LikeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'manager_id',
        'clothes_id',
        'client_id',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Like::class;
    }
}
