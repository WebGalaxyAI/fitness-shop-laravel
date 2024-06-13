<?php

namespace App\Repositories;

use App\Helpers\Breadcrumbs;
use App\Models\Category;
use App\Models\Product;

class ProductPageRepository
{
    public function getProduct(string $slug): ?Product
    {
        $product = Product::findBySlug($slug);

        if (!$product) {
            return null;
        }

        $product->load(['media', 'categories', 'attributeValues', 'attributeValues.attribute']);
        return $product;
    }

    public function breadcrumbs(Product $product): Breadcrumbs
    {
        $breadcrumbs = app(Breadcrumbs::class);

        $category = $product->categories->first();
        if ($category) {
            $category->parents(0)->map(function (Category $category) use ($breadcrumbs) {
                $breadcrumbs->add($category->name, $category->getCatalogUrl());
            });
            $breadcrumbs->add($category->name, $category->getCatalogUrl());
        }

        $breadcrumbs->add($product->name);
        return $breadcrumbs;
    }
}
