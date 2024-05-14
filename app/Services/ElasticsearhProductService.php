<?php

namespace App\Services;

use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use Elastic\Elasticsearch\Client;

class ElasticsearhProductService
{
    const INDEX = 'products';

    public function __construct(private Client $elasticsearch)
    {
    }

    public function deleteIndex()
    {
        $params = [
            'index' => self::INDEX,
        ];

        $this->elasticsearch->indices()->delete($params);
    }

    public function createIndexWithMapping(): void
    {
        /**
         * 'type' => 'keyword'
         * поля, що містять ключові слова або фіксований список значень.
         * шукатиме по точному співпадінню
         */
        $params = [
            'index' => self::INDEX,
            'body' => [
                'mappings' => [
                    'properties' => [
                        'category' => [
                            'type' => 'keyword',
                        ],
                        'created_at' => [
                            'type' => 'date',
                        ],
                        'price' => [
                            'type' => 'double',
                        ],
                        'label' => [
                            'type' => 'keyword',
                        ],
                        'string_facets' => [
                            'type' => 'nested',
                            'properties' => [
                                'name' => ['type' => 'keyword'],
                                'value' => ['type' => 'keyword'],
                            ],
                        ],
                    ]
                ]
            ]
        ];

        $this->elasticsearch->indices()->create($params);
    }

    public function indexProduct(Product $product): string
    {
        $product->load('attributeValues', 'attributeValues.attribute', 'labels', 'categories', 'brand');

        $attributeValues = $product->attributeValues
            ->map(function (AttributeValue $value) {
                return [
                    'name' => $value->attribute->code,
                    'value' => $value->code,
                ];
            })
            ->toArray();
        $catSlugs = collect();
        $product->categories
            ->map(function (Category $category) use ($catSlugs) {
                $catSlugs->push(...$category->parents(0)->pluck('slug'));
                $catSlugs->push($category->slug);
            });
        $body = [
            'name' => array_values($product->getTranslations('name')),
            'description' => array_values($product->getTranslations('description')),
            'label' => $product->labels->pluck('code')->toArray(),
            'category' => $catSlugs->unique()->toArray(),
            'price' => $product->sale_price,
            'created_at' => $product->created_at,
        ];

        if ($product->brand) {
            $body['brand'] = $product->brand->slug;
        }

        $body['string_facets'] = $attributeValues;

        $document = [
            'index' => self::INDEX,
            'id' => $product->id,
            'body' => $body,
        ];

        try {
            $result = $this->elasticsearch->index($document);
            return $result['result'];
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
