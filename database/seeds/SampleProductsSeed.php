<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SampleProductsSeed extends Seeder
{
    /**
     * generate random fruit names
     * @return string
     */
    function randomFruitNames()
    {
        $names = array(
            'Banana',
            'Apple',
            'Pomegranate',
            'orange',
            'coconut',
            'cucumber',
        );
        return $names[rand(0, count($names) - 1)];
    }
  /**
     * generate random fruit names
     * @return string
     */
    function randomDairyNames()
    {
        $names = array(
            'soy milk',
            'milk',
        );
        return $names[rand(0, count($names) - 1)];
    }
  /**
     * generate random fruit names
     * @return string
     */
    function randomVegetablesName()
    {
        $names = array(
            'corn',
            'pepper',
            'mushroom',
            'carrot',
        );
        return $names[rand(0, count($names) - 1)];
    }
  /**
     * generate random fruit names
     * @return string
     */
    function randomDrinkNames()
    {
        $names = array(
            'Choopan',
            'mahsham',
            'hype',
            'redbull',
            'alis',
        );
        return $names[rand(0, count($names) - 1)];
    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        array_map(function ($category_id) {
            $count = rand(4, 10);
            for ($i = 0; $i < $count;
                 $i++) {
                DB::table("products")->insert([
                    'name' => [
                        $this->randomFruitNames(),$this->randomVegetablesName(),
                        $this->randomDrinkNames(),$this->randomDairyNames()
                    ][$category_id-1],
                    'description' => Str::random(),
                    'quantity' => rand(1, 10),
                    'category_id' => $category_id
                ]);
            }
        }, [1, 2, 3, 4]);// fruit vegetables drinks dairy respectively
    }
}
