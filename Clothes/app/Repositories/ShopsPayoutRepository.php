<?php

namespace App\Repositories;

use App\Models\ShopsPayout;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ShopsPayoutRepository
 * @package App\Repositories
 * @version March 25, 2020, 9:48 am UTC
 *
 * @method ShopsPayout findWithoutFail($id, $columns = ['*'])
 * @method ShopsPayout find($id, $columns = ['*'])
 * @method ShopsPayout first($columns = ['*'])
*/
class ShopsPayoutRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'shop_id',
        'method',
        'amount',
        'paid_date',
        'note'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ShopsPayout::class;
    }
}
