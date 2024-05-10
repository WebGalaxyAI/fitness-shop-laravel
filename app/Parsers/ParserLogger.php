<?php

namespace App\Parsers;

class ParserLogger
{
    public function log(string $v): void
    {
        dump($v);
    }
}
