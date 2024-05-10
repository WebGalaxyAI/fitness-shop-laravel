<?php

namespace App\Parsers;

use App\Managers\AttributeManager;
use App\Managers\ProductManager;
use App\Models\Product;
use Symfony\Component\DomCrawler\Crawler;

class ProductParser extends SimpleHttpAbstractParser
{
    public function __construct(
        ParserLogger               $logger,
        protected AttributeManager $attributeManager,
        protected ProductManager   $productManager
    )
    {
        parent::__construct($logger);
    }

    public function parse()
    {
        foreach (Product::where('id', '>', 12)->cursor() as $product) {
            $this->saveProductDetails($product);
        }
    }

    public function saveProductDetails(Product $product)
    {
        $url = "https://epicentrk.ua/ua/shop/{$product->slug}.html";
        $this->log($url);
        $crawler = $this->request('GET', $url);
        $this->saveAttributes($crawler, $product);
        $this->saveImages($crawler, $product);
        $this->log("{$product->name} saved details");
    }

    public function saveAttributes(Crawler $crawler, Product $product)
    {
        $properties = [];
        $crawler->filter('._tpM6._Gq8f._vt94._hAAm')
            ->first()
            ->filter('li._5CbM')
            ->each(function (Crawler $node) use ($product, &$properties) {
                $node->filter('li._kdIO')->each(function (Crawler $node) use (&$properties) {
                    $attName = str($node->filter('div._UF8f > span')->text(''))
                        ->before(':')->trim();
                    $attValue = str($node->filter('ul._mvYC > li > span')->text(''))
                        ->before(':')->trim();
                    if ($attValue->isEmpty() || $attName->isEmpty() || $attValue->length() > 70 || $attName->length() > 50) {
                        return;
                    }
                    $properties[$attName->toString()] = $attValue->toString();
                });
            });

        //Save attributes
        $attrValIds = $this->attributeManager->massCreateOrUpdateWithValues($properties);
        $this->productManager->syncWithoutDetachingAttributeValues($attrValIds, $product);
    }

    public function saveImages(Crawler $crawler, Product $product): void
    {
        if ($product->media->count() > 1) {
            return;
        }
        $crawler->filter('.swiper-wrapper')->first()
            ->filter('.swiper-slide')
            ->each(function (Crawler $node) use ($product) {
                try {
                    $imgUrl = $node->filter('img')->first()?->attr('src');
                    if (!$imgUrl) {
                        return;
                    }
                    $this->productManager->addProductMediaFromUrl($product, $imgUrl);
                } catch (\Throwable $e) {
                    $this->log("Error: {$e->getMessage()}");
                }
            });
    }
}
