<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CategoryItem extends Component
{
    public Category $category;
    public bool $isOpen = false;
    public bool $isRoot = false;
    public array $foundedCatIds = [];
    public array $foundedCatParentIds = [];

    protected $listeners = ['openedSearchedCategories'];

    public function render()
    {
        return view('livewire.category-item');
    }

    #[Computed]
    public function isFounded(): bool
    {
        return in_array($this->category->id, $this->foundedCatIds);
    }

    #[Computed]
    public function isOpenedBySearch(): bool
    {
        return in_array($this->category->id, $this->foundedCatParentIds);
    }

    public function toggleCategory($categoryId)
    {
        if ($this->category->id !== $categoryId) {
            return;
        }

        if ($this->isOpen || in_array($this->category->id, $this->foundedCatParentIds)) {
            $this->foundedCatParentIds = [];
            $this->isOpen = false;
            return;
        }

        $this->isOpen = true;
    }

    public function openedSearchedCategories(array $foundedCatParentIds, array $foundedCatIds)
    {
        $this->foundedCatIds = $foundedCatIds;
        $this->foundedCatParentIds = $foundedCatParentIds;
    }
}

