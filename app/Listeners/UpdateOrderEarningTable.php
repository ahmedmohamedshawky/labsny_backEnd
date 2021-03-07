<?php
/**
 * File name: UpdateOrderEarningTable.php
 * Last modified: 2020.05.05 at 17:03:49
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App\Listeners;

use App\Criteria\Earnings\EarningOfShopCriteria;
use App\Repositories\EarningRepository;

class UpdateOrderEarningTable
{
    /**
     * @var EarningRepository
     */
    private $earningRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(EarningRepository $earningRepository)
    {
        //
        $this->earningRepository = $earningRepository;
    }

    /**
     * Handle the event.
     *oldOrder
     * updatedOrder
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        if ($event->oldStatus != $event->updatedOrder->payment->status) {
            $this->earningRepository->pushCriteria(new EarningOfShopCriteria($event->updatedOrder->clothesOrders[0]->clothes->shop->id));
            $shop = $this->earningRepository->first();
//            dd($shop);
            $amount = 0;

            // test if order delivered to client
            if (!empty($shop)) {
                foreach ($event->updatedOrder->clothesOrders as $clothesOrder) {
                    $amount += $clothesOrder['price'] * $clothesOrder['quantity'];
                }
                if ($event->updatedOrder->payment->status == 'Paid') {
                    $shop->total_orders++;
                    $shop->total_earning += $amount;
                    $shop->admin_earning += ($shop->shop->admin_commission / 100) * $amount;
                    $shop->shop_earning += ($amount - $shop->admin_earning);
                    $shop->delivery_fee += $event->updatedOrder->delivery_fee;
                    $shop->tax += $amount * $event->updatedOrder->tax / 100;
                    $shop->save();
                } elseif ($event->oldStatus == 'Paid') {
                    $shop->total_orders--;
                    $shop->total_earning -= $amount;
                    $shop->admin_earning -= ($shop->shop->admin_commission / 100) * $amount;
                    $shop->shop_earning -= $amount - (($shop->shop->admin_commission / 100) * $amount);
                    $shop->delivery_fee -= $event->updatedOrder->delivery_fee;
                    $shop->tax -= $amount * $event->updatedOrder->tax / 100;
                    $shop->save();
                }
            }

        }
    }
}
