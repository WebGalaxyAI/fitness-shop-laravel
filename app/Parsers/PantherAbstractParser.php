<?php

namespace App\Parsers;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Panther\Client;

abstract class PantherAbstractParser extends AbstractParser
{
    protected Client $client;

    private function initClient()
    {
        $chromeOptions = new ChromeOptions();
        $chromeOptions->setExperimentalOption('w3c', false);

        $this->client = Client::createChromeClient(null, [],
            [
                'capabilities' => [
                    ChromeOptions::CAPABILITY => $chromeOptions,
                ],
            ]);
    }

    protected function request(string $method, string $url): Crawler
    {
        if (!isset($this->client)) {
            $this->initClient();
        }
        $this->client->request($method, $url);
        return $this->client->getCrawler();
    }
}
