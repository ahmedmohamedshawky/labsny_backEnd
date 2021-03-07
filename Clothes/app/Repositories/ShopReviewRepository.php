<?php

namespace App\Repositories;

use App\Models\ShopReview;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ShopReviewRepository
 * @package App\Repositories
 * @version August 29, 2019, 9:39 pm UTC
 *
 * @method ShopReview findWithoutFail($id, $columns = ['*'])
 * @method ShopReview find($id, $columns = ['*'])
 * @method ShopReview first($columns = ['*'])
*/
class ShopReviewRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'review',
        'rate',
        'user_id',
        'shop_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ShopReview::class;
    }
}
