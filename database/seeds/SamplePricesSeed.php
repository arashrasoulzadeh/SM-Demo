<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SamplePricesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = \App\Product::all()->pluck("id")->toArray(); // not safe for long list of items
        array_map(function ($product_id) {
            DB::table("prices")->insert([
                'price' => rand(1000, 200000),
                'product_id' => $product_id
            ]);
        }, $products);
    }
}
