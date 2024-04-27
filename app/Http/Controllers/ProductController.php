<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class ProductController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Product', [
            'title' => 'Product',
        ]);
    }
}
