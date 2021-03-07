<?php

use Illuminate\Database\Seeder;

class ClothesOrdersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('clothes_orders')->delete();

    }
}