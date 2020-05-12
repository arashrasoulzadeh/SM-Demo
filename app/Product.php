<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Product
 * @property int category_id
 * @property string name
 * @property string description
 * @property int price
 * @property int quantity
 * @property int id
 * @package App
 */

/**
 * @OA\Schema(
 *     required={"file"},
 *     type="object",
 *     schema="Product",
 * ),
 * @OA\Property(
 *          property="file",
 *          type="file",
 *          description="Your csv file",
 *    ),
 *
 * ),
 * @OA\Schema(
 *     type="object",
 *     schema="ProductIndex",
 * ),
 * @OA\Property(
 *          property="page",
 *          type="int",
 *          description="page",
 *    ),
 * @OA\Property(
 *          property="category",
 *          type="int",
 *          description="category id",
 *    ),
 *
 * )
 */
class Product extends Model
{
    /**
     * get price of product
     * @return int
     */
    public function getPriceAttribute()
    {
        $priceObject = Price::where("product_id", $this->id)->latest();
        if ($priceObject->count())
            return Price::where("product_id", $this->id)->latest()->first()->price;
        return -1;
    }

    /**
     * get category
     * @return HasOne
     */
    public function category()
    {
        return $this->hasOne(ProductCategory::class, "id", "category_id");
    }

    /**
     * scope for category
     * @param $query
     * @param $category
     * @return mixed
     */
    public function scopeOfCategory($query, $category)
    {
        if (!is_null($category))
            $query->where("category_id", $category);
    }
}
