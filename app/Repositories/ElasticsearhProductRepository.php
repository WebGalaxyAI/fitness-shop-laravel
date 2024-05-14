<?php

namespace App\Repositories;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use Elastic\Elasticsearch\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ElasticsearhProductRepository implements ProductRepository
{
    const INDEX = 'products';
    private Collection $filters;
    private array $prices;

    public function __construct(private Client $elasticsearch)
    {
    }

    public function availableSortFields(): Collection
    {
        return collect([
            'popularity' => 'created_at',
            'novelty' => 'created_at',
            'price' => 'price',
            'rating' => 'created_at',
        ]);
    }

    public function search(array $requestParams, int $perPage = 10): LengthAwarePaginator
    {
        $currentPage = Arr::get($requestParams, 'page', 1);
        $search = Arr::get($requestParams, 'search');
        $category = Arr::get($requestParams, 'category');
        $priceMinMax = Arr::get($requestParams, 'price');
        if ($priceMinMax) {
            $priceMinMax = str($priceMinMax)->explode('_')
                ->map(fn($v) => str($v)->toInteger());
        }

        $params = [
            'index' => self::INDEX,
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [],
                    ],
                ],
                'size' => $perPage,
                'from' => ($currentPage - 1) * $perPage,
                'sort' => [],
            ],
        ];

        // Sorting
        if (Arr::get($requestParams, 'sort')) {
            [$field, $direction] = str(Arr::get($requestParams, 'sort'))->explode('_');
            if (in_array($direction, ['asc', 'desc']) && $this->availableSortFields()->has($field)) {
                $params['body']['sort'] = [
                    [
                        $this->availableSortFields()->get($field) => [
                            'order' => $direction,
                        ]
                    ]
                ];
            }
        }


        //search
        if ($search) {
            $params['body']['query']['bool']['must'][] = [
                'multi_match' => [
                    'query' => $search,
                    'fields' => ['name', 'description'],
                    'type' => 'most_fields', // Ви можете вибрати інший тип пошуку
                ],
            ];
        }

        //category
        if ($category) {
            $params['body']['query']['bool']['must'][] = [
                'match' => [
                    'category' => $category,
                ],
            ];
        }

        //min max price
        if ($priceMinMax && $priceMinMax->count() === 2) {
            $params['body']['query']['bool']['filter']['range'] = [
                'price' => [
                    'gte' => $priceMinMax[0],
                    'lte' => $priceMinMax[1]
                ],
            ];
        }

        //attributes
        foreach (Arr::except($requestParams, ['page', 'search', 'category', 'price', 'sort']) as $field => $values) {
            if (empty($values)) {
                continue;
            }
            $values = array_filter(explode(',', $values));
            if (!count($values)) {
                continue;
            }

            $attributeConditions = [];

            foreach ($values as $value) {
                /**
                 * Кожна умова для пошуку атрибута конкретного продукта знаходиться всередині nested запиту Elasticsearch.
                 * Це означає, що ми шукаємо вкладене поле (nested field) в документах.
                 * У цьому випадку, string_facets - це вкладене поле, яке містить ключ-значення атрибутів.
                 * Ми створюємо умову, де:
                 * string_facets.name = $field (назвою атрибута) і
                 * string_facets.value = $value (значенням атрибута).
                 */
                $attributeConditions[] = [
                    'nested' => [
                        'path' => 'string_facets',
                        'query' => [
                            'bool' => [
                                'must' => [
                                    ['match' => ['string_facets.name' => $field]],
                                    ['match' => ['string_facets.value' => $value]],
                                ],
                            ],
                        ],
                    ],
                ];
            }

            /**
             * Кожна умова для пошуку, яку ми створили в попередньому кроці, додається до $params['body']['query']['bool']['must'].
             * Elasticsearch очікує параметри запиту в певному форматі, де 'bool' - це булева логіка, яка вказує, що всі умови мають виконатися.
             * В даному випадку, 'should' вказує, що хоча б одна з умов повинна виконатися, щоб запит повернув результат.
             */
            $params['body']['query']['bool']['must'][] = ['bool' => ['should' => $attributeConditions]];
        }

        //facets
        // Умови на агрегацію з вибраними фільтрами
        $params['body']['aggs'] = [
            'global_agg' => [
                'global' => new \stdClass(),
                'aggs' => [
                    'founded_products_aggs' => [
                        'filter' => $params['body']['query'],
                        'aggs' => [
                            'aggs_text_facets' => [
                                'nested' => [
                                    'path' => 'string_facets',
                                ],
                                'aggs' => [
                                    'name' => [
                                        'terms' => [
                                            'field' => 'string_facets.name',
                                            'size' => 1000
                                        ],
                                        'aggs' => [
                                            'value' => [
                                                'terms' => [
                                                    'field' => 'string_facets.value',
                                                    'size' => 1000
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        // min max price
        $minMaxPriceFilter = $params['body']['query'];
        if (Arr::has($minMaxPriceFilter, 'bool.filter.range.price')) {
            Arr::forget($minMaxPriceFilter, 'bool.filter.range.price');
            if (!count(Arr::get($minMaxPriceFilter, 'bool.filter.range'))) {
                Arr::forget($minMaxPriceFilter, 'bool.filter.range');
            }
            if (!count(Arr::get($minMaxPriceFilter, 'bool.filter'))) {
                Arr::forget($minMaxPriceFilter, 'bool.filter');
            }
        }
        $params['body']['aggs']['global_agg']['aggs']['min_max_price'] = [
            'filter' => $minMaxPriceFilter,
            'aggs' => [
                'min_price' => [
                    'min' => [
                        'field' => 'price'
                    ]
                ],
                'max_price' => [
                    'max' => [
                        'field' => 'price'
                    ]
                ],
            ],
        ];

        $requestFilterAllValues = Attribute::whereIn('code', array_keys(Arr::except($requestParams, ['page', 'search', 'category', 'price', 'sort'])))
            ->with('values')
            ->get();

        // Додаткові умови для обчислення значень сусідів
        foreach ($this->processFacetsWithNeighbors($requestParams, $requestFilterAllValues) as $filterName => $aggs) {
            $params['body']['aggs']['global_agg']['aggs'][$filterName] = $aggs;
        }

        $res = $this->elasticsearch->search($params);

        $this->processFacetsResult(Arr::get($res, 'aggregations.global_agg'), $requestFilterAllValues);

        $total = Arr::get($res, 'hits.total.value');
        $products = collect();

        if ($total > 0) {
            $idArray = Arr::pluck(Arr::get($res, 'hits.hits'), '_id');

            $products = Product::query()
                ->with(['media', 'attributeValues', 'attributeValues.attribute'])
                ->whereIn('id', $idArray)
                ->orderByRaw("FIELD(id, " . implode(",", $idArray) . ")")
                ->get();
        }

        return new LengthAwarePaginator(
            $products,
            $total,
            $perPage,
            $currentPage
        );
    }

    public function processFacetsWithNeighbors(array $requestParams, Collection $requestFilterAllValues): array
    {
        $search = Arr::get($requestParams, 'search');
        $category = Arr::get($requestParams, 'category');

        //search
        if ($search) {
            $startParams['bool']['must'][] = [
                'multi_match' => [
                    'query' => $search,
                    'fields' => ['name', 'description'],
                    'type' => 'most_fields', // Ви можете вибрати інший тип пошуку
                ],
            ];
        }

        //category
        if ($category) {
            $startParams['bool']['must'][] = [
                'match' => [
                    'category' => $category,
                ],
            ];
        }

        $requestSelectedFilters = collect(Arr::except($requestParams, ['page', 'search', 'category', 'price', 'sort']))
            ->filter(fn($values) => !empty($values))
            ->mapWithKeys(function ($values, $k) {
                $values = array_filter(explode(',', $values));
                return [$k => $values];
            })
            ->filter(fn($values) => !empty($values))->toArray();
        if (!count($requestSelectedFilters)) {
            return [];
        }

        $neighborParams = [];
        foreach ($requestFilterAllValues as $outerFilter) {
            if ($outerFilter->values->isEmpty()) {
                continue;
            }
            $neighborParams[$outerFilter->code]['filter'] = $startParams;
            foreach ($requestSelectedFilters as $filter => $values) {
                /**
                 * Якщо фільтр поточний вибраний, то замість нього підставляємо сусідів
                 */
                if ($filter === $outerFilter->code) {
                    $values = $outerFilter->values->pluck('code')->toArray();
                }
                $attributeConditions = [];
                foreach ($values as $value) {
                    $attributeConditions[] = [
                        'nested' => [
                            'path' => 'string_facets',
                            'query' => [
                                'bool' => [
                                    'must' => [
                                        ['match' => ['string_facets.name' => $filter]],
                                        ['match' => ['string_facets.value' => $value]],
                                    ],
                                ],
                            ],
                        ],
                    ];


                }
                $neighborParams[$outerFilter->code]['filter']['bool']['must'][] = ['bool' => ['should' => $attributeConditions]];
            }

            $neighborParams[$outerFilter->code]['aggs'] = [
                'aggs_text_facets' => [
                    'nested' => [
                        'path' => 'string_facets',
                    ],
                    'aggs' => [
                        'filtered_name' => [
                            'filter' => [
                                'term' => [
                                    'string_facets.name' => $outerFilter->code,
                                ]
                            ],
                            'aggs' => [
                                'name' => [
                                    'terms' => [
                                        'field' => 'string_facets.name',
                                        'size' => 1000
                                    ],
                                    'aggs' => [
                                        'value' => [
                                            'terms' => [
                                                'field' => 'string_facets.value',
                                                'size' => 1000
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ];
        }
        return $neighborParams;
    }

    public function processFacetsResult(array $facets, Collection $requestFilterAllValues): void
    {
        //founded_products_aggs
        $foundedProductsAggs = collect(Arr::get($facets, 'founded_products_aggs.aggs_text_facets.name.buckets'));
        $this->filters = Attribute::query()
            ->whereIn('code', $foundedProductsAggs->pluck('key')->toArray())
            ->with(['values' => function ($q) use ($foundedProductsAggs) {
                $q->whereIn('code', $foundedProductsAggs->pluck('value.buckets')->collapse()->pluck('key')->toArray())->orderBy('code');
            }])
            ->orderBy('code')
            ->get()
            ->map(function (Attribute $attribute) use ($foundedProductsAggs) {
                return [
                    'attribute' => $attribute,
                    'facet_count' => $foundedProductsAggs->where('key', $attribute->code)->first()['doc_count'],
                    'values' => $attribute->values->map(function (AttributeValue $value) use ($foundedProductsAggs, $attribute) {
                        return [
                            'value' => $value,
                            'facet_count' => collect($foundedProductsAggs->where('key', $attribute->code)->first()['value']['buckets'])
                                ->where('key', $value->code)->first()['doc_count'],
                        ];
                    }),
                ];
            });

        //price aggs
        $this->prices['max_price'] = str(Arr::get($facets, 'min_max_price.max_price.value'))->toInteger();
        $this->prices['min_price'] = str(Arr::get($facets, 'min_max_price.min_price.value'))->toInteger();

        //neighbor aggs
        Arr::forget($facets, ['meta', 'doc_count', 'founded_products_aggs', 'min_max_price']);
        foreach ($facets as $filerName => $res) {
            $resFacets = collect(Arr::get(collect(Arr::get($res, 'aggs_text_facets.filtered_name.name.buckets'))
                ->where('key', $filerName)
                ->first(), 'value.buckets'))
                ->map(function ($v) use ($requestFilterAllValues, $filerName) {
                    return [
                        'value' => $requestFilterAllValues
                            ->where('code', $filerName)
                            ->first()->values->where('code', $v['key'])->first(),
                        'facet_count' => $v['doc_count'],
                    ];
                })->keyBy('value.code');
            $curKeys = $this->filters->where('attribute.code', $filerName)->first()['values']->keys();
            $this->filters->where('attribute.code', $filerName)->first()['values']->forget($curKeys->toArray())->push(...$resFacets->values());
        }
    }

    public function getFilters(): Collection
    {
        return $this->filters;
    }

    public function getPrices(): array
    {
        return $this->prices;
    }
}
