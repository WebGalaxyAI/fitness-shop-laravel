<?php

namespace App\Parsers;

use App\Managers\CategoryManager;
use App\Models\Category;
use Symfony\Component\DomCrawler\Crawler;

class CategoryParser extends PantherAbstractParser
{
    public function __construct(
        ParserLogger $logger,
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

        $this->saveCats($mainSportCat);

    }

    public function saveCats(Category $rootCategory)
    {
        $url = "https://epicentrk.ua/ua/shop/{$rootCategory->slug}/";
        $this->log($url);
        $crawler = $this->request('GET', $url);
        $crawler->filter('._ZIUN._EDde._OMtO._Nu8y')
            ->each(function (Crawler $node) use ($rootCategory) {
                $firstImgNode = $node->filter('a')->first();
                $slug = str($firstImgNode->attr('href'))->after('shop/')->trim('/');
                $imgNode = $firstImgNode->filter('img')->first();
                //Save cat
                $childCat = Category::firstOrCreate(
                    [
                        'slug' => $slug,
                    ],
                    [
                        'name' => $imgNode->attr('alt'),
                    ]);
                if($childCat->wasRecentlyCreated) {
                    $childCat->appendTo($rootCategory);
                }

                //Save cat img
                $imgUrl = $imgNode->attr('src');
                if (!$childCat->image && !empty($imgUrl)) {
                    $this->categoryManager->saveCategoryImg($imgUrl, $childCat);
                }
                $this->log("$childCat->name saved");

                //Рекурсивно дістаємо дітей
                $this->saveCats($childCat);
            });
    }
}
