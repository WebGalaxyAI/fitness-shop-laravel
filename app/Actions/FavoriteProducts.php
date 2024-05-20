<?php

namespace App\Actions;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class FavoriteProducts
{
    public function toggle(Product $product, Request $request)
    {
        $favoriteProducts = [];
        if ($request->hasCookie('favoriteProducts')) {
            $favoriteProducts = json_decode($request->cookie('favoriteProducts'), true);
        }
        if (in_array($product->id, $favoriteProducts)) {
            return $this->remove($product, $request);
        }
        return $this->add($product, $request);
    }

    public function add(Product $product, Request $request)
    {
        $favoriteProducts = [];
        if ($request->hasCookie('favoriteProducts')) {
            $favoriteProducts = json_decode($request->cookie('favoriteProducts'), true);
        }
        if (in_array($product->id, $favoriteProducts)) {
            return response()->json([
                'success' => false,
                'message' => 'Товар вже в улюблених'
            ]);
        }
        $favoriteProducts[] = $product->id;
        Cookie::queue('favoriteProducts', json_encode($favoriteProducts), 99999);
        return response()->json([
            'success' => true,
            'favoriteIds' => $favoriteProducts,
        ]);
    }

    public function remove(Product $product, Request $request)
    {
        $favoriteProducts = [];
        if ($request->hasCookie('favoriteProducts')) {
            $favoriteProducts = json_decode($request->cookie('favoriteProducts'), true);
        }
        if (!in_array($product->id, $favoriteProducts)) {
            return response()->json([
                'success' => false,
                'message' => 'Товару немає в улюблених'
            ]);
        }
        $favoriteProducts = array_filter($favoriteProducts, function ($v) use ($product) {
            return $v != $product->id;
        });
        Cookie::queue('favoriteProducts', json_encode($favoriteProducts), 99999);
        return response()->json([
            'success' => true,
            'favoriteIds' => $favoriteProducts,
        ]);
    }
}
