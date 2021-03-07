<?php

use Illuminate\Database\Seeder;

class ShopCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('shop_categories')->delete();

        factory(\App\Models\ShopCategory::class,10)->create();
    }
}
