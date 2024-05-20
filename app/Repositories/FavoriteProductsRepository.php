<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class FavoriteProductsRepository
{
    public function getFavorite(Request $request): Collection
    {
        if (!$request->hasCookie('favoriteProducts')) {
            return collect();
        }
        $favoriteProductIds = json_decode($request->cookie('favoriteProducts'), true);
        return Product::query()
            ->with(['media', 'attributeValues', 'attributeValues.attribute'])
            ->whereIn('id', $favoriteProductIds)
            ->get();
    }

    public function getCount(Request $request): int
    {
        if (!$request->hasCookie('favoriteProducts')) {
            return 0;
        }
        $favoriteProducts = json_decode($request->cookie('favoriteProducts'), true);
        return count($favoriteProducts);
    }

    public function getIds(Request $request): array
    {
        if (!$request->hasCookie('favoriteProducts')) {
            return [];
        }
        return json_decode($request->cookie('favoriteProducts'), true);
    }
}
