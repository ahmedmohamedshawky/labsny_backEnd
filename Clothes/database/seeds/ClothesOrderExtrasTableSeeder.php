<?php

use Illuminate\Database\Seeder;

class ClothesOrderExtrasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('clothes_order_extras')->delete();
    }
}