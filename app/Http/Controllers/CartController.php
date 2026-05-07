<?php

namespace App\Http\Controllers;

use App\Actions\Cart;
use App\Helpers\Breadcrumbs;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index(Request $request, Breadcrumbs $breadcrumbs, CartRepository $cartRepository)
    {
        $breadcrumbs->add(__('Cart'));

        return Inertia::render('Cart', [
            'title'       => __('My cart'),
            'breadcrumbs' => $breadcrumbs->crumbs(),
            'cartProducts'=> ProductResource::collection($cartRepository->getProducts($request)),
        ]);
    }

    public function store(Request $request, Cart $cart)
    {
        $data = $request->validate([
            'slug'     => 'required|string',
            'quantity' => 'sometimes|integer|min:1|max:99',
        ]);

        $product = Product::where('slug', $data['slug'])->firstOrFail();
        $payload = $cart->add($product, $request, (int) ($data['quantity'] ?? 1));

        return response()->json(['success' => true, ...$payload]);
    }

    public function update(Product $product, Request $request, Cart $cart)
    {
        $data = $request->validate([
            'quantity' => 'required|integer|min:0|max:99',
        ]);

        $payload = $cart->setQuantity($product, $request, (int) $data['quantity']);

        return response()->json(['success' => true, ...$payload]);
    }

    public function destroy(Product $product, Request $request, Cart $cart)
    {
        $payload = $cart->remove($product, $request);

        return response()->json(['success' => true, ...$payload]);
    }
}
