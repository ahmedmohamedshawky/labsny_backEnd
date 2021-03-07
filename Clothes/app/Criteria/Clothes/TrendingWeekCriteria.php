<?php
/**
 * File name: TrendingWeekCriteria.php
 * Last modified: 2020.05.04 at 09:04:18
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App\Criteria\Clothes;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class TrendingWeekCriteria.
 *
 * @package namespace App\Criteria\Clothes;
 */
class TrendingWeekCriteria implements CriteriaInterface
{
    /**
     * @var array
     */
    private $request;

    /**
     * TrendingWeekCriteria constructor.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply criteria in query repository
     *
     * @param string $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if ($this->request->has(['myLon', 'myLat', 'areaLon', 'areaLat'])) {

            $myLat = $this->request->get('myLat', 0);
            $myLon = $this->request->get('myLon', 0);
            $areaLat = $this->request->get('areaLat', 0);
            $areaLon = $this->request->get('areaLon', 0);

            return $model->join('shops', 'shops.id', '=', 'clothes.shop_id')->select(DB::raw("SQRT(
            POW(69.1 * (shops.latitude - $myLat), 2) +
            POW(69.1 * ($myLon - shops.longitude) * COS(shops.latitude / 57.3), 2)) AS distance, SQRT(
            POW(69.1 * (shops.latitude - $areaLat), 2) +
            POW(69.1 * ($areaLon - shops.longitude) * COS(shops.latitude / 57.3), 2)) AS area, count(clothes.id) as clothes_count"), 'clothes.*')
                ->join('clothes_orders', 'clothes.id', '=', 'clothes_orders.clothes_id')
                ->whereBetween('clothes_orders.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->where('shops.active','1')
                ->orderBy('clothes_count', 'desc')
                ->orderBy('area')
                ->groupBy('clothes.id');
        } else {
            return $model->join('clothes_orders', 'clothes.id', '=', 'clothes_orders.clothes_id')
                ->whereBetween('clothes_orders.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->join('shops', 'shops.id', '=', 'clothes.shop_id')
                ->where('shops.active','1')
                ->groupBy('clothes.id')
                ->orderBy('clothes_count', 'desc')
                ->select('clothes.*', DB::raw('count(clothes.id) as clothes_count'));
        }
    }
}
