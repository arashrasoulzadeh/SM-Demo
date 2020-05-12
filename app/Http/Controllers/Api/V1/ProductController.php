<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductIndexRequest;
use App\Http\Resources\ProductsCollectionResource;
use App\Http\Resources\ProductsResource;
use App\ProductCategory;
use App\Services\ProductsService;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{

    /**
     * @var ProductsService
     */
    private $ProductsService;

    public function __construct(ProductsService $ProductsService)
    {
        $this->ProductsService = $ProductsService;
    }

    /**
     * @OA\Get(
     *     tags={"products"},
     *     path="/guest/list",
     *     @OA\RequestBody(
     *         description="Product Index",
     *         required=false,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/ProductIndex")
     *         )
     *     ),
     *     @OA\Response(response="200", description="success")
     * )
     */
    /**
     * list products
     * @param ProductIndexRequest $request
     * @return array
     */
    public function index(ProductIndexRequest $request)
    {
        $page = $request->has("page") ? $request->input("page") : 1;
        $category = $request->input("category");
        /** @var LengthAwarePaginator $list */
        $list = $this->ProductsService->listProducts($page, $category);
        return [
            "metadata" => [
                "total" => $list->total(),
                "perPage" => $list->perPage(),
                "currentPage" => $list->currentPage(),
                "last_page" => $list->lastPage(),
                "categories" => array_map(function ($cat) {
                    return ["id" => $cat['id'], "name" => $cat['name']];
                }, ProductCategory::all()->toArray())
            ],
            "data" => ProductsResource::collection(new ProductsResource($list)),
        ];
    }
}
