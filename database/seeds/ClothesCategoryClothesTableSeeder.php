<?php

use Illuminate\Database\Seeder;

class ClothesCategoryClothesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('clothes_category_clothes')->delete();

        factory(\App\Models\ClothesCategoryClothes::class,10)->create();
    }
}
