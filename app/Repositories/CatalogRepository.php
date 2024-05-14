<?php

namespace App\Repositories;

use App\Helpers\Breadcrumbs;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CatalogRepository
{
    private ?Category $category;
    private ?LengthAwarePaginator $categoryProducts;
    private int $perPage = 20;

    public function __construct(
        private Request                    $request,
        private ProductRepository $productRepository,
        private CategoryRepository         $categoryRepository,
        private Breadcrumbs                $breadcrumbs)
    {
        $this->category = $categoryRepository->findBySlug($request->category);
        if (!$this->category) {
            abort(404);
        }
    }

    public function perPage(): int
    {
        return $this->perPage;
    }

    public function getChildrenOrSiblingsAndSelfCats(): Collection
    {
        return $this->categoryRepository->getChildrenOrSiblingsAndSelf($this->category);
    }


    public function categoryProducts(): LengthAwarePaginator
    {
        if (!isset($this->categoryProducts)) {
            $this->request->merge(['category' => $this->category->slug]);
            $this->categoryProducts = $this->productRepository->search($this->request->all(), $this->perPage());
        }

        return $this->categoryProducts;
    }

    public function filters(): Collection
    {
        return $this->productRepository->getFilters();
    }

    public function prices(): array
    {
        return $this->productRepository->getPrices();
    }

    public function breadcrumbs(): Breadcrumbs
    {
        if ($this->breadcrumbs->crumbs()->isEmpty()) {
            $this->category->parents(0)->map(function (Category $category) {
                $this->breadcrumbs->add($category->name, $category->getCatalogUrl());
            });
        }

        return $this->breadcrumbs;
    }

    public function category(): Category
    {
        return $this->category;
    }
}
