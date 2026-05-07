<?php

namespace App\Repositories;

use App\Actions\Cart;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CartRepository
{
    private const COOKIE = 'cart';

    public function getItems(Request $request): array
    {
        return Cart::toList($this->read($request));
    }

    public function getCount(Request $request): int
    {
        return array_sum($this->read($request));
    }

    /** @return Collection<int, Product> */
    public function getProducts(Request $request): Collection
    {
        $items = $this->read($request);
        if (!$items) {
            return new Collection();
        }

        return Product::query()
            ->with(['media', 'brand'])
            ->whereIn('id', array_keys($items))
            ->get();
    }

    private function read(Request $request): array
    {
        $raw = $request->cookie(self::COOKIE);
        if (!$raw) {
            return [];
        }
        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }
}
