<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SampleCategoriesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        array_map(function ($name) {
            DB::table("product_categories")->insert([
                'name' => $name
            ]);
        }, ['fruit','vegetables','drinks','dairy']);
    }
}
