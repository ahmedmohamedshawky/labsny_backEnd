<?php

use Illuminate\Database\Seeder;

class ShopsPayoutsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('shops_payouts')->delete();
        
    }
}