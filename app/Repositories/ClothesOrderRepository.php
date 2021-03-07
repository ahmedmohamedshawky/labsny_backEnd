<?php

namespace App\Repositories;

use App\Models\ClothesOrder;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ClothesOrderRepository
 * @package App\Repositories
 * @version August 31, 2019, 11:18 am UTC
 *
 * @method ClothesOrder findWithoutFail($id, $columns = ['*'])
 * @method ClothesOrder find($id, $columns = ['*'])
 * @method ClothesOrder first($columns = ['*'])
*/
class ClothesOrderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'price',
        'quantity',
        'clothes_id',
        'order_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ClothesOrder::class;
    }
}
