<?php

namespace App\Http\Controllers;

use App\Actions\FavoriteProducts;
use App\Helpers\Breadcrumbs;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\FavoriteProductsRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FavoriteProductController extends Controller
{
    public function index(Request $request, Breadcrumbs $breadcrumbs, FavoriteProductsRepository $favoriteRepository)
    {
        $breadcrumbs->add(__('Favorite'));
        return Inertia::render('FavoriteProducts', [
            'title' => __('Favorite products'),
            'breadcrumbs' => $breadcrumbs->crumbs(),
            'favoriteProducts' => ProductResource::collection($favoriteRepository->getFavorite($request)),
        ]);
    }

    public function toggle(Product $product, Request $request, FavoriteProducts $favoriteProducts)
    {
        return $favoriteProducts->toggle($product, $request);
    }
}
