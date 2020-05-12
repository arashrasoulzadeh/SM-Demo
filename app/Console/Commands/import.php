<?php

namespace App\Console\Commands;

use App\Services\ProductsService;
use Illuminate\Console\Command;

class import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:csv {--file=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import from csv file';
    /**
     * @var ProductsService
     */
    private $productsService;

    /**
     * Create a new command instance.
     *
     * @param ProductsService $productsService
     */
    public function __construct(ProductsService $productsService)
    {
        parent::__construct();
        $this->productsService = $productsService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $argumentPath = ($this->option('file'));
            if (is_null($argumentPath)) {
                $path = public_path("file.csv");
            } else {
                $path = $argumentPath;
            }
            if (($handle = fopen($path, "r")) !== FALSE) {
                $this->process($handle);
            } else {
                $this->info($path);
                $this->error("cannot open file for reading.");
            }
        } catch (\Exception $err) {
            dd($err);
            $this->error("error importing $path");
        }

    }


    public function process($handle)
    {
        $row = 1;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $count = count($data);
            if ($count == 5) {
                $category = $data[0];
                $name = $data[1];
                $price = $data[2];
                $description = $data[3];
                $quantity = $data[4];
                if ($this->productsService->createProduct(
                    $category,
                    $name,
                    $price,
                    $description,
                    $quantity
                )) {
                    $this->info("created $name.");
                } else {
                    $this->warn("cant create $name");

                }
            } else {
                $this->error("invalid count on row $row");
            }
            $row++;
        }
    }
}
