<?php

namespace App\Console\Commands;

use App\Parsers\CatalogProductParser;
use App\Parsers\CategoryParser;
use App\Parsers\ProductParser;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Casts\Json;

class Parser extends Command
{
    protected $signature = 'app:parser {type}';

    protected $description = 'Parser';

    public function handle()
    {
        $parserType = $this->argument('type');

        match ($parserType) {
            'category' => app(CategoryParser::class)->parse(),
            'catalog-product' => app(CatalogProductParser::class)->parse(),
            'product' => app(ProductParser::class)->parse(),
            default => $this->error('Invalid parser type'),
        };

        return self::SUCCESS;
    }
}
