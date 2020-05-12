<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportRequest;
use Illuminate\Support\Facades\Artisan;

/**
 * Class ImportController
 * @package App\Http\Controllers
 */
class ImportController extends Controller
{

    /**
     * Create a new ImportController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * @OA\Post(
     *     tags={"products"},
     *     path="/import",
     *     @OA\RequestBody(
     *         description="Login",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/Product")
     *         )
     *     ),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="200", description="success")
     * )
     */
    /**
     * import from csv file
     * @param ImportRequest $request
     * @return string|string[]
     */
    public function import(ImportRequest $request)
    {
        Artisan::call('import:csv', [
            '--file' => $request->file("file")
        ]);
        return str_replace("\n", "<br>", Artisan::output());
    }
}
