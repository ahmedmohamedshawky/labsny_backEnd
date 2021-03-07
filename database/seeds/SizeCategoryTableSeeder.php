<?php

use Illuminate\Database\Seeder;

class SizeCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('size_categories')->delete();

        factory(\App\Models\SizeCategory::class,10)->create();
    }
}
