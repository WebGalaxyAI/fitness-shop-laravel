<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Services\ElasticsearhProductService;
use Illuminate\Console\Command;

class ElasticAddIndexProduct extends Command
{
    protected $signature = 'app:elastic-add-index-product';

    protected $description = 'Elastic add index product';

    public function handle(ElasticsearhProductService $elastic)
    {
        $this->info('Start adding Elastic index to products. This might take a while...');

        $elastic->deleteIndex();
        $elastic->createIndexWithMapping();

        foreach (Product::cursor() as $product) {
            $result = $elastic->indexProduct($product);
            $this->info("Product id {$product->id} - {$result}");
        }

        $this->info('Done!');
        return self::SUCCESS;
    }
}
