<?php

namespace App\Console\Commands;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;

class FitnessdomImport extends Command
{
    protected $signature = 'fitnessdom:import
        {category? : One of: treadmills, exercise-bikes, elliptical-trainers, rowing-machines, dumbbells. Omit to import all.}
        {--limit=10 : Max products per category}
        {--force : Re-import even if SKU already exists}';

    protected $description = 'Import demo products from fitnessdom.ua into local categories';

    private const BASE = 'https://fitnessdom.ua';
    private const CHALLENGE_COOKIE = '59506a70c42d1000628a60ebcc7680846d52afb37cd7b19396ce8d53883aea68';
    private const UA = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0 Safari/537.36';

    /** local category slug => fitnessdom.ua category slug */
    private const CATEGORY_MAP = [
        'treadmills'          => 'bihovi-dorizhky',
        'exercise-bikes'      => 'velotrenazhery',
        'elliptical-trainers' => 'eliptychni-trenazhery',
        'rowing-machines'     => 'hrebni-trenazhery',
        'dumbbells'           => 'hanteli',
    ];

    private Client $http;

    public function handle(): int
    {
        $this->http = new Client([
            'headers' => [
                'User-Agent' => self::UA,
                'Cookie'     => 'challenge_passed=' . self::CHALLENGE_COOKIE,
                'Accept'     => 'text/html,application/xhtml+xml,application/xml;q=0.9',
            ],
            'timeout'         => 30,
            'allow_redirects' => true,
        ]);

        $only  = $this->argument('category');
        $limit = (int) $this->option('limit');

        $targets = $only
            ? array_intersect_key(self::CATEGORY_MAP, [$only => true])
            : self::CATEGORY_MAP;

        if (empty($targets)) {
            $this->error("Unknown category '$only'. Allowed: " . implode(', ', array_keys(self::CATEGORY_MAP)));
            return self::FAILURE;
        }

        foreach ($targets as $localSlug => $remoteSlug) {
            $this->importCategory($localSlug, $remoteSlug, $limit);
        }

        return self::SUCCESS;
    }

    private function importCategory(string $localSlug, string $remoteSlug, int $limit): void
    {
        $category = Category::findBySlug($localSlug);
        if (!$category) {
            $this->warn("Local category '$localSlug' not found, skipping.");
            return;
        }

        $this->info("→ {$localSlug}  (fitnessdom.ua/{$remoteSlug}/)");

        $links = $this->collectProductLinks(self::BASE . "/{$remoteSlug}/", $limit);
        $links = array_slice($links, 0, $limit);

        foreach ($links as $i => $url) {
            try {
                $this->importProduct($url, $category);
                $this->line(sprintf('  [%d/%d] ok  %s', $i + 1, count($links), basename(rtrim($url, '/'))));
            } catch (\Throwable $e) {
                $this->warn(sprintf('  [%d/%d] fail %s — %s', $i + 1, count($links), $url, $e->getMessage()));
            }
        }
    }

    /**
     * @throws GuzzleException
     */
    private function importProduct(string $ukUrl, Category $category): void
    {
        $uk = $this->parseProductPage($ukUrl);

        if (!$this->option('force') && Product::where('name->uk', $uk['name'])->exists()) {
            return;
        }

        $ru = $this->parseProductPage($this->langUrl($ukUrl, 'ru'));
        $en = $this->parseProductPage($this->langUrl($ukUrl, 'en'));

        $brand = $this->resolveBrand($uk['brand'] ?? null);

        $product = Product::create([
            'brand_id'   => $brand?->id,
            'sku'        => $uk['sku'],
            'name'       => ['uk' => $uk['name'], 'ru' => $ru['name'], 'en' => $en['name']],
            'description'=> ['uk' => $uk['description'], 'ru' => $ru['description'], 'en' => $en['description']],
            'quantity'   => random_int(5, 30),
            'price'      => $uk['price'],
            'sale_price' => null,
            'active'     => true,
        ]);

        $product->categories()->syncWithoutDetaching([$category->id]);

        if (!empty($uk['image'])) {
            try {
                $product->addMediaFromUrl($uk['image'])
                    ->usingFileName($product->sku . '-' . basename(parse_url($uk['image'], PHP_URL_PATH)))
                    ->toMediaCollection();
            } catch (\Throwable $e) {
                $this->warn('    image failed: ' . $e->getMessage());
            }
        }
    }

    /**
     * Collect product page URLs from a listing. If the listing only shows subcategory tiles
     * (`.catalogCard.__category`), descend one level and aggregate from each subcategory.
     *
     * @return string[] absolute URLs
     * @throws GuzzleException
     */
    private function collectProductLinks(string $listingUrl, int $needed): array
    {
        $crawler = $this->fetchCrawler($listingUrl);

        $productLinks = $crawler->filter('.catalogCard.j-catalog-card .catalogCard-title a')
            ->each(fn(Crawler $a) => $a->attr('href'));
        $productLinks = array_values(array_unique(array_filter($productLinks)));

        if ($productLinks) {
            return array_map(fn($h) => $this->absoluteUrl($h), $productLinks);
        }

        $subLinks = $crawler->filter('.catalogCard.__category a.catalogCard-a')
            ->each(fn(Crawler $a) => $a->attr('href'));
        $subLinks = array_values(array_unique(array_filter($subLinks)));

        $aggregated = [];
        foreach ($subLinks as $sub) {
            if (count($aggregated) >= $needed) {
                break;
            }
            try {
                $found = $this->collectProductLinks($this->absoluteUrl($sub), $needed - count($aggregated));
                foreach ($found as $f) {
                    if (!in_array($f, $aggregated, true)) {
                        $aggregated[] = $f;
                    }
                }
            } catch (\Throwable) {
                // skip broken subcategory
            }
        }

        return $aggregated;
    }

    /**
     * @return array{name:string,description:?string,sku:?string,brand:?string,price:?float,image:?string}
     * @throws GuzzleException
     */
    private function parseProductPage(string $url): array
    {
        $crawler = $this->fetchCrawler($url);

        $name = $this->metaContent($crawler, 'og:title')
            ?? $this->trimOrNull($crawler->filter('h1')->first()->text(''));

        $description = $this->metaContent($crawler, 'og:description');
        $image       = $this->metaContent($crawler, 'og:image');

        $sku   = $this->trimOrNull($crawler->filter('[itemprop="sku"]')->first()->attr('content'));
        $price = $this->trimOrNull($crawler->filter('[itemprop="price"]')->first()->attr('content'));

        // brand: og:title meta has product name, but a `<span itemprop="brand"><meta itemprop="name" content="...">`
        // would shadow it; pull brand from the catalog card mention instead via a labelled selector.
        $brand = null;
        $crawler->filter('meta[itemprop="name"]')->each(function (Crawler $m) use (&$brand) {
            if ($brand === null) {
                $brand = trim((string) $m->attr('content')) ?: null;
            }
        });

        return [
            'name'        => (string) ($name ?? ''),
            'description' => $description,
            'sku'         => $sku,
            'brand'       => $brand,
            'price'       => $price !== null ? (float) $price : null,
            'image'       => $image,
        ];
    }

    private function resolveBrand(?string $name): ?Brand
    {
        if (!$name) {
            return null;
        }
        $slug = \Illuminate\Support\Str::slug($name);
        return Brand::firstOrCreate(
            ['slug' => $slug],
            ['name' => $name]
        );
    }

    private function metaContent(Crawler $c, string $property): ?string
    {
        $node = $c->filter('meta[property="' . $property . '"]')->first();
        return $node->count() ? trim((string) $node->attr('content')) ?: null : null;
    }

    private function trimOrNull(?string $v): ?string
    {
        $v = trim((string) $v);
        return $v === '' ? null : $v;
    }

    private function langUrl(string $ukUrl, string $lang): string
    {
        $path = parse_url($ukUrl, PHP_URL_PATH) ?? '/';
        return self::BASE . '/' . $lang . $path;
    }

    private function absoluteUrl(string $href): string
    {
        if (str_starts_with($href, 'http')) {
            return $href;
        }
        return self::BASE . '/' . ltrim($href, '/');
    }

    /**
     * @throws GuzzleException
     */
    private function fetchCrawler(string $url): Crawler
    {
        $body = (string) $this->http->get($url)->getBody();
        return new Crawler($body, $url);
    }
}
