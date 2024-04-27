<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class CatalogController extends Controller
{
    public function index()
    {
        return Inertia::render('Catalog', [
            'title' => 'Catalog',
        ]);
    }
}
