<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CategoryTree extends Component
{
    public Collection $categories;
    public string $search = '';
    public array $foundedCatParentIds = [];
    public array $foundedCatIds = [];

    public function render()
    {
        $this->categories = Category::with('children')->root()->get();
        return view('livewire.category-tree');
    }

    public function searchCategory()
    {
        $this->foundedCatParentIds = [];
        $this->foundedCatIds = [];

        if ($this->search) {
            $foundedCategories = Category::query()
                ->where(DB::raw('lower(name)'), 'like', '%' . str($this->search)->lower()->toString() . '%')
                ->get();
            foreach ($foundedCategories as $cat) {
                $parentIds = $cat->parents(0)->pluck('id')->toArray();
                $this->foundedCatParentIds = array_values(array_unique(array_merge($this->foundedCatParentIds, $parentIds)));
                $this->foundedCatIds[] = $cat->id;
            }
        }

        $this->dispatch('openedSearchedCategories', $this->foundedCatParentIds, $this->foundedCatIds);
    }
}
