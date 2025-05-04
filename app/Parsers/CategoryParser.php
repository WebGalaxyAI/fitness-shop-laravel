<?php

namespace App\Parsers;

use App\Managers\CategoryManager;
use App\Models\Category;
use Symfony\Component\DomCrawler\Crawler;

class CategoryParser extends SimpleHttpAbstractParser
{
    public function __construct(
        ParserLogger              $logger,
        protected CategoryManager $categoryManager
    )
    {
        parent::__construct($logger);
    }

    public function parse()
    {
        //Save root cat
        $mainSportCat = Category::firstOrCreate(
            [
                'slug' => 'trenazhery',
            ],
            [
                'name' => 'Тренажери Епіцентр',
            ]);
        if (!$mainSportCat->image) {
            $this->categoryManager->saveCategoryImg('https://epicentrk.ua/upload/iblock/9d1/Trenazheri.jpg', $mainSportCat);
        }

        $this->parseFirstLevelCats($mainSportCat);

        $mainSportCat->children->map(function (Category $category) {
            $this->parseSecondLevelCats($category);
        });

    }

    private function saveCat(Category $rootCategory, string $slug, string $categoryTitle, string $imageUrl): Category
    {
        /** @var Category $childCat */
        $childCat = Category::firstOrCreate(
            [
                'slug' => $slug,
            ],
            [
                'name' => $categoryTitle,
                'parent_id' => $rootCategory->id,
            ]);
        if (!$childCat->wasRecentlyCreated) {
            $this->log("$childCat->name already exist!");
            return $childCat;
        }

        $childCat->appendTo($rootCategory)->save();
        if (!$childCat->image && !empty($imageUrl)) {
            $this->categoryManager->saveCategoryImg($imageUrl, $childCat);
        }

        $this->log("$childCat->name saved! Parent $rootCategory->name");

        return $childCat;
    }

    private function parseFirstLevelCats(Category $rootCategory)
    {
        $url = "https://epicentrk.ua/ua/shop/{$rootCategory->slug}/";
        $this->log($url);
        $crawler = $this->request('GET', $url);
        $crawler->filter('section')->first()->filter('ul li')->each(function (Crawler $node) use ($rootCategory) {
            if (!$node->filter('nav div a')->first()->count()) {
                return;
            }
            $categoryTitle = $node->filter('nav div a')->first()->attr('title');

            $categoryLink = $node->filter('nav div a')->first()->attr('href');
            $slug = str($categoryLink)->after('shop/')->trim('/');

            $imageUrl = $node->filter('nav div img')->first()->attr('src');

            $this->saveCat($rootCategory, $slug, $categoryTitle, $imageUrl);
        });
    }

    private function parseSecondLevelCats(Category $rootCategory)
    {
        $url = "https://epicentrk.ua/ua/shop/{$rootCategory->slug}/";
        $this->log($url);
        $crawler = $this->request('GET', $url);
        $crawler->filter('main')->first()->filter('ul li')->each(function (Crawler $node) use ($rootCategory) {
            if (!$node->filter('a div')->first()->count()) {
                return;
            }
            $categoryTitle = $node->filter('a')->first()->attr('title');
            $categoryLink = $node->filter('a')->first()->attr('href');
            $slug = str($categoryLink)->after('shop/')->trim('/');

            $style = $node->filter('a div')->first()->attr('style');
            $imageUrl = str($style)->match('/background-image:url\((.*?)\);/')->value();

            $this->saveCat($rootCategory, $slug, $categoryTitle, $imageUrl);
        });
    }
}
