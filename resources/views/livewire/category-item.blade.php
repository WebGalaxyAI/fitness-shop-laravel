<li @style([
    'margin-left: 2em' => !$isRoot,
]) x-data="{ isHovered: false }">
    <div class="flex flex-row items-center text-sm" @mouseover="isHovered = true" @mouseout="isHovered = false">
        <div class="icon-wrapper">
            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                 aria-hidden="true">
                <path
                    d="M19.5 21a3 3 0 003-3v-4.5a3 3 0 00-3-3h-15a3 3 0 00-3 3V18a3 3 0 003 3h15zM1.5 10.146V6a3 3 0 013-3h5.379a2.25 2.25 0 011.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 013 3v1.146A4.483 4.483 0 0019.5 9h-15a4.483 4.483 0 00-3 1.146z"></path>
            </svg>
        </div>
        <div @class([
                'item px-2' => true,
                'bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-white rounded border-blue-500 transition duration-300' => $this->isFounded,
            ])>
            {{ $category->name }}
        </div>
        @if($category->children->count())
            <button wire:click="toggleCategory({{ $category->id }})" class="btn btn-xs btn-secondary">
                @if($isOpen || $this->isOpenedBySearch)
                    -
                @else
                    +
                @endif
            </button>
        @endif
        <div style="margin-left: 1rem" class="flex gap-1" x-show="isHovered" x-transition:enter="transition-opacity ease-out duration-100" x-transition:leave="transition-opacity ease-in" x-cloak>
            <a href="{{ url("/admin/categories/{$category->id}/edit") }}" style="color: mediumseagreen">
                <x-heroicon-o-pencil-square class="h-5 text-green-500 cursor-pointer"/>
            </a>
        </div>
    </div>
    @if($category->children->count() && ($isOpen || $this->isOpenedBySearch))
        <ul>
            @foreach($category->children as $child)
                <livewire:category-item
                    :key="$child->id"
                    :category="$child"
                    :founded-cat-parent-ids="$foundedCatParentIds"
                    :founded-cat-ids="$foundedCatIds"
                />
            @endforeach
        </ul>
    @endif
</li>
