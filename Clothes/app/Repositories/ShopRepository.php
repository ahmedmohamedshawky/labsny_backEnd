<?php

namespace App\Repositories;

use App\Models\Shop;
use InfyOm\Generator\Common\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class ShopRepository
 * @package App\Repositories
 * @version August 29, 2019, 9:38 pm UTC
 *
 * @method Shop findWithoutFail($id, $columns = ['*'])
 * @method Shop find($id, $columns = ['*'])
 * @method Shop first($columns = ['*'])
 */
class ShopRepository extends BaseRepository implements CacheableInterface
{

    use CacheableRepository;
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'address',
        'latitude',
        'longitude',
        'phone',
        'mobile',
        'information',
        'delivery_fee',
        'default_tax',
        'delivery_range',
        'available_for_delivery',
        'closed',
        'admin_commission',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Shop::class;
    }

    /**
     * get my shops
     */

    public function myShops()
    {
        return Shop::join("user_shops", "shop_id", "=", "shops.id")
            ->where('user_shops.user_id', auth()->id())->get();
    }

    public function myActiveShops()
    {
        return Shop::join("user_shops", "shop_id", "=", "shops.id")
            ->where('user_shops.user_id', auth()->id())
            ->where('shops.active','=','1')->get();
    }

}
