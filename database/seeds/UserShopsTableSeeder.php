<?php

use Illuminate\Database\Seeder;

class UserShopsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {


        \DB::table('user_shops')->delete();

        \DB::table('user_shops')->insert(array(
            0 =>
                array(
                    'user_id' => 1,
                    'shop_id' => 2,
                ),
            1 =>
                array(
                    'user_id' => 1,
                    'shop_id' => 5,
                ),
            2 =>
                array(
                    'user_id' => 2,
                    'shop_id' => 3,
                ),
            3 =>
                array(
                    'user_id' => 2,
                    'shop_id' => 4,
                ),
            5 =>
                array(
                    'user_id' => 1,
                    'shop_id' => 6,
                ),
            6 =>
                array(
                    'user_id' => 1,
                    'shop_id' => 3,
                ),
        ));


    }
}