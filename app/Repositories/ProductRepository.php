<?php


namespace App\Repositories;


use App\Interfaces\ProductRepositoryInterface;
use App\Price;
use App\Product;

/**
 * Class ProductRepository
 * @package App\Repositories
 */
class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function list(int $page, $category)
    {
        return Product::ofCategory($category)->paginate(10, ['*'], 'page', $page);
    }

    /**
     * @inheritDoc
     */
    public function create(int $category, string $name, int $price, string $description, int $quantity): bool
    {
        $product = new Product();
        $product->category_id = $category;
        $product->name = $name;
        $product->description = $description;
        $product->quantity = $quantity;
        $status = $product->save();
        if ($status) {
            $price_model = new Price();
            $price_model->price = $price;
            $price_model->product_id = $product->id;
            return $price_model->save();
        } else {
            return $status;
        }
    }
}
