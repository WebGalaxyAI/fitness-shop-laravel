<?php

namespace App\Actions;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class Cart
{
    private const COOKIE = 'cart';
    private const TTL = 60 * 24 * 30;

    public function add(Product $product, Request $request, int $quantity = 1)
    {
        $items = $this->read($request);
        $items[$product->id] = max(1, ($items[$product->id] ?? 0) + $quantity);

        return $this->write($items);
    }

    public function remove(Product $product, Request $request)
    {
        $items = $this->read($request);
        unset($items[$product->id]);

        return $this->write($items);
    }

    public function setQuantity(Product $product, Request $request, int $quantity)
    {
        $items = $this->read($request);
        if ($quantity <= 0) {
            unset($items[$product->id]);
        } else {
            $items[$product->id] = min(99, $quantity);
        }

        return $this->write($items);
    }

    public function clear()
    {
        return $this->write([]);
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

    private function write(array $items): array
    {
        Cookie::queue(self::COOKIE, json_encode($items), self::TTL);

        return [
            'cartItems' => $this->toList($items),
            'cartCount' => array_sum($items),
        ];
    }

    /** @return list<array{id:int, quantity:int}> */
    public static function toList(array $items): array
    {
        $out = [];
        foreach ($items as $id => $qty) {
            $out[] = ['id' => (int) $id, 'quantity' => (int) $qty];
        }
        return $out;
    }
}
