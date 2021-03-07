<?php

namespace App\Repositories;

use App\Models\CoinStructure;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CoinRepository
 * @package App\Repositories
 * @version April 11, 2020, 1:57 pm UTC
 *
 * @method Coin findWithoutFail($id, $columns = ['*'])
 * @method Coin find($id, $columns = ['*'])
 * @method Coin first($columns = ['*'])
*/
class CoinRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'clothes',
        'clothes_featured',
        'offers'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CoinStructure::class;
    }
}
