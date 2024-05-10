<?php

namespace App\Managers;

use App\Models\Category;
use App\Models\Product;

class ProductManager
{
    public function syncWithoutDetachingAttributeValues(array $ids, Product $product): void
    {
        $product->attributeValues()->syncWithoutDetaching($ids);
    }

    public function updateOrCreateProduct(Category $category, array $uniqArr, array $data): Product
    {
        return $category->products()->updateOrCreate($uniqArr, $data);
    }

    public function addProductMediaFromUrl(Product $product, string $url)
    {
        $product->addMediaFromUrl($url)
            ->setName($product->slug)
            ->toMediaCollection();
    }
}
