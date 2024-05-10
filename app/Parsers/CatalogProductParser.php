<?php

namespace App\Parsers;

use App\Managers\AttributeManager;
use App\Managers\ProductManager;
use App\Models\Category;
use Facebook\WebDriver\Exception\StaleElementReferenceException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Symfony\Component\DomCrawler\Crawler;

class CatalogProductParser extends SimpleHttpAbstractParser
{
    public function __construct(
        ParserLogger $logger,
        protected AttributeManager $attributeManager,
        protected ProductManager $productManager
    )
    {
        parent::__construct($logger);
    }

    public function parse()
    {
        $rootCat = Category::findBySlug('trenazhery');

        if (!$rootCat) {
            throw new ModelNotFoundException("Root category for scraping not found!");
        }

        foreach (Category::where('id', '>', $rootCat->id)->cursor() as $category) {
            $this->parseCategoryProductPage($category);
        }

    }

    public function parseCategoryProductPage(Category $category)
    {
        $url = $this->getCatalogUrl($category);
        $crawler = $this->request('GET', $url);
        $this->log("Start scraping url: {$url} ...");
        $productCards = $crawler->filter('ul._3xJS._ySy9 li');
        $productCards->each(function (Crawler $node, $i) use ($category) {
            try {
                $this->saveProduct($node, $category);
            } catch (StaleElementReferenceException $e) {
                $this->log("StaleElementReferenceException!");
            } catch (QueryException $e) {
                $this->log("QueryException: {$e->getMessage()}");
            }
        });
    }

    public function getCatalogUrl(Category $category): string
    {
        return "https://epicentrk.ua/ua/shop/{$category->slug}/";
    }

    public function saveProduct(Crawler $node, Category $category)
    {
        // Отримання даних з елементу
        if (!$node->filter('img')->count()) {
            return;
        }
        $imgUrl = $node->filter('img')->attr('src');
        $title = $node->filter('h2 a')->text();
        $url = $node->filter('h2 a')->attr('href');
        $newPrice = $node->filter('div._tqVy')->text('');
        $oldPrice = null;

        // Перевірка наявності знижки
        if ($node->filter('div._OHyb')->count() > 0) {
            $oldPrice = $node->filter('div._OHyb s')->text();
        }

        $properties = [];
        $node->filter('div._q3Rf div._8zly dl div')->each(function (Crawler $propertyNode, $i) use (&$properties) {
            $name = $propertyNode->filter('dt')->text();
            $value = $propertyNode->filter('dd')->text();
            if (empty($value)) {
                $oldPriceCrawler = new Crawler();
                $oldPriceCrawler->addHtmlContent($propertyNode->filter('dd')->html());
                $value = $oldPriceCrawler->text();
            }
            $properties[$name] = $value;
        });


        // Збереження даних у базу даних
        $product = $this->productManager->updateOrCreateProduct(
            $category,
            [
                'slug' => str($url)->after('shop/')->trim('.html'),
            ],
            [
                'name' => $title,
                'price' => $oldPrice ? str($oldPrice)->trim()->replace(['₴', ' '], '')->toInteger() : null,
                'sale_price' => $newPrice ? str($newPrice)->trim()->replace(['₴', ' '], '')->toInteger() : null,
            ]);

        //Save cat img
        if ($product->media->isEmpty() && !empty($imgUrl)) {
            $this->productManager->addProductMediaFromUrl($product, $imgUrl);
        }

        //Save attributes
        $attrValIds = $this->attributeManager->massCreateOrUpdateWithValues($properties);
        $this->productManager->syncWithoutDetachingAttributeValues($attrValIds, $product);
        $this->log("$product->name saved");
    }
}
