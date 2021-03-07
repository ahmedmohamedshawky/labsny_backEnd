<?php

use Illuminate\Database\Seeder;

class ClothesCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('clothes_categories')->delete();

        factory(\App\Models\ClothesCategory::class,10)->create();
    }
}
