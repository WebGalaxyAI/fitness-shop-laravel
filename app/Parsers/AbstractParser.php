<?php

namespace App\Parsers;

use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractParser
{
    public function __construct(protected ParserLogger $logger)
    {
    }

    abstract protected function request(string $method, string $url): Crawler;

    protected function log(string $v): void
    {
        $this->logger->log($v);
    }
}
