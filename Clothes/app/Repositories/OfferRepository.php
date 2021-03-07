<?php

namespace App\Repositories;

use App\Models\Offer;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class OfferRepository
 * @package App\Repositories
 * @version April 11, 2020, 1:57 pm UTC
 *
 * @method Offer findWithoutFail($id, $columns = ['*'])
 * @method Offer find($id, $columns = ['*'])
 * @method Offer first($columns = ['*'])
*/
class OfferRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'shop_id',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Offer::class;
    }
}
