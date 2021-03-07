<?php

namespace App\Repositories;

use App\Models\ClothesReview;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ClothesReviewRepository
 * @package App\Repositories
 * @version August 29, 2019, 9:38 pm UTC
 *
 * @method ClothesReview findWithoutFail($id, $columns = ['*'])
 * @method ClothesReview find($id, $columns = ['*'])
 * @method ClothesReview first($columns = ['*'])
*/
class ClothesReviewRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'review',
        'rate',
        'user_id',
        'clothes_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ClothesReview::class;
    }
}
