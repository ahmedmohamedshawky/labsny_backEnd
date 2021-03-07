<?php

use Illuminate\Database\Seeder;

class ShopCategoryShopTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('shop_category_shops')->delete();

        factory(\App\Models\ShopCategoryShop::class,10)->create();
    }
}
