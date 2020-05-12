<?php


namespace App\Services;


use App\Interfaces\ProductRepositoryInterface;

class ProductsService
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * ProductsService constructor.
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }


    /**
     * @param int $page
     * @param int $category
     * @return mixed
     */
    public function listProducts(int $page, $category)
    {
        return $this->productRepository->list($page, $category);
    }

    /**
     * create new product
     * @param int $category
     * @param string $name
     * @param int $price
     * @param string $description
     * @param int $quantity
     * @return bool
     */
    public function createProduct(int $category, string $name, int $price, string $description, int $quantity): bool
    {
        return $this->productRepository->create(
            $category, $name, $price, $description, $quantity
        );
    }
}
