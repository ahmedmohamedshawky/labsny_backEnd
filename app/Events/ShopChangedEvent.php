<?php

namespace App\Events;

use App\Models\Shop;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ShopChangedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $newShop;

    public $oldShop;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Shop $newShop, Shop $oldShop)
    {
        //
        $this->newShop = $newShop;
        $this->oldShop = $oldShop;
    }

}
