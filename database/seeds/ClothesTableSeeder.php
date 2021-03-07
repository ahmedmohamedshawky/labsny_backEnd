<?php

use Illuminate\Database\Seeder;

class ClothesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('clothes')->delete();

        factory(\App\Models\Clothes::class,30)->create();
        
    }
}