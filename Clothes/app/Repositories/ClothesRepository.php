<?php

namespace App\Repositories;

use App\Models\Clothes;
use Illuminate\Container\Container as Application;
use InfyOm\Generator\Common\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class ClothesRepository
 * @package App\Repositories
 * @version August 29, 2019, 9:38 pm UTC
 *
 * @method Clothes findWithoutFail($id, $columns = ['*'])
 * @method Clothes find($id, $columns = ['*'])
 * @method Clothes first($columns = ['*'])
 */
class ClothesRepository extends BaseRepository implements CacheableInterface
{

    use CacheableRepository;
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'price',
        'discount_price',
        'description',
        'ingredients',
        'weight',
        'package_items_count',
        'unit',
        'featured',
        'shop_id',
        'coin',
        'amount',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Clothes::class;
    }

    /**
     * get my clothes
     **/
    public function myClothes()
    {
        return Clothes::join("user_shops", "user_shops.shop_id", "=", "clothes.shop_id")
            ->where('user_shops.user_id', auth()->id())->get();
    }

    public function groupedByShops()
    {
        $clothes = [];
        foreach ($this->all() as $model) {
            if(!empty($model->shop)){
                $clothes[$model->shop->name][$model->id] = $model->name;
            }
        }
        return $clothes;
    }
}
