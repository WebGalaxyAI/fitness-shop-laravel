<?php

namespace App\Parsers;

use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

abstract class SimpleHttpAbstractParser extends AbstractParser
{
    protected function request(string $method, string $url): Crawler
    {
        $method = strtolower($method);
        $response = Http::{$method}($url);
        $html = $response->body();
        return new Crawler($html);
    }
}
