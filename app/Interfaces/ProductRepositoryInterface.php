<?php


namespace App\Interfaces;

/**
 * Interface ProductRepositoryInterface
 * @package App\Interfaces
 */
interface ProductRepositoryInterface
{
    /**
     * list products
     * @param int $page
     * @param int $category
     * @return mixed
     */
    public function list(int $page, $category);

    /**
     * create new product
     * @param int $category
     * @param string $name
     * @param int $price
     * @param string $description
     * @param int $quantity
     * @return bool
     */
    public function create(int $category, string $name, int $price, string $description, int $quantity): bool;
}
