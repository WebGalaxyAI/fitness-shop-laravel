<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Repositories\ProductPageRepository;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function __invoke(string $slug, ProductPageRepository $productRepository)
    {
        $product = $productRepository->getProduct($slug);
        if (!$product) {
            abort(404);
        }
        return Inertia::render('Product', [
            'title' => $product->name,
            'product' => ProductResource::make($product),
            'breadcrumbs' => $productRepository->breadcrumbs($product)->crumbs()
        ]);
    }
}
