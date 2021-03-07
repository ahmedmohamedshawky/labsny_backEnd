<?php

use Illuminate\Database\Seeder;

class ClothesSizeCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('clothes_size_categories')->delete();

        factory(\App\Models\ClothesSizeCategory::class,10)->create();
    }
}
