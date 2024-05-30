<div>
    <h2 class="text-2xl font-semibold mb-4">Tree</h2>
    <form wire:submit.prevent="searchCategory" class="mb-4 flex align-center gap-2">
        <input type="text" wire:model.defer="search"
               placeholder="Search categories"
               class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-sm text-gray-800 dark:text-white rounded-lg px-4 py-1 focus:outline-none focus:border-blue-500 transition duration-300"
        />
        <button class="dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white px-2 py-1 rounded-lg">
            <x-heroicon-o-magnifying-glass class="h-5" />
        </button>
    </form>
    <ul>
        @foreach($categories as $category)
            <livewire:category-item
                :key="$category->id"
                :is-root="true"
                :category="$category"
                :founded-cat-parent-ids="$foundedCatParentIds"
                :founded-cat-ids="$foundedCatIds"
            />
        @endforeach
    </ul>
</div>
