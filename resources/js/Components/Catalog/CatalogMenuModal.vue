<script setup lang="ts">
import {onMounted, ref} from 'vue';
import {Link, usePage} from '@inertiajs/vue3'


const page = usePage();

const selectedCategory = ref(null);
const isMobileOpenCat = ref(true);
const isShowModal = ref(false)

function closeModal() {
    isShowModal.value = false
    document.body.classList.remove('overflow-hidden');
}

function showModal() {
    isShowModal.value = true
    document.body.classList.add('overflow-hidden');
}

function showChildrenOnHover(category) {
    if (screen.width > 1024) {
        showChildren(category)
    }
}

function showChildrenOnClick(category) {
    if (screen.width < 1024) {
        showChildren(category)
    }
}

function showChildren(category) {
    if (screen.width > 1024 || selectedCategory.value !== category) {
        isMobileOpenCat.value = true;
    } else {
        isMobileOpenCat.value = !isMobileOpenCat.value;
    }
    selectedCategory.value = category;
}

onMounted(() => {
    // Вибір першої категорії при завантаженні компонента
    if (page.props.catalogRootCats.length > 0) {
        selectedCategory.value = page.props.catalogRootCats[0];
    }
});
</script>

<template>
    <div class="catalog-button" @click="showModal">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <g clip-path="url(#clip0_776_27)">
                <path
                    d="M3.33333 0H0.666667C0.298667 0 0 0.298667 0 0.666667V3.33333C0 3.70133 0.298667 4 0.666667 4H3.33333C3.70133 4 4 3.70133 4 3.33333V0.666667C4 0.298667 3.70133 0 3.33333 0Z"
                    fill="white"/>
                <path
                    d="M3.33333 6H0.666667C0.298667 6 0 6.29867 0 6.66667V9.33333C0 9.70133 0.298667 10 0.666667 10H3.33333C3.70133 10 4 9.70133 4 9.33333V6.66667C4 6.29867 3.70133 6 3.33333 6Z"
                    fill="white"/>
                <path
                    d="M3.33333 12H0.666667C0.298667 12 0 12.2987 0 12.6667V15.3333C0 15.7013 0.298667 16 0.666667 16H3.33333C3.70133 16 4 15.7013 4 15.3333V12.6667C4 12.2987 3.70133 12 3.33333 12Z"
                    fill="white"/>
                <path
                    d="M9.33333 0H6.66667C6.29867 0 6 0.298667 6 0.666667V3.33333C6 3.70133 6.29867 4 6.66667 4H9.33333C9.70133 4 10 3.70133 10 3.33333V0.666667C10 0.298667 9.70133 0 9.33333 0Z"
                    fill="white"/>
                <path
                    d="M9.33333 6H6.66667C6.29867 6 6 6.29867 6 6.66667V9.33333C6 9.70133 6.29867 10 6.66667 10H9.33333C9.70133 10 10 9.70133 10 9.33333V6.66667C10 6.29867 9.70133 6 9.33333 6Z"
                    fill="white"/>
                <path
                    d="M9.33333 12H6.66667C6.29867 12 6 12.2987 6 12.6667V15.3333C6 15.7013 6.29867 16 6.66667 16H9.33333C9.70133 16 10 15.7013 10 15.3333V12.6667C10 12.2987 9.70133 12 9.33333 12Z"
                    fill="white"/>
                <path
                    d="M15.3333 0H12.6667C12.2987 0 12 0.298667 12 0.666667V3.33333C12 3.70133 12.2987 4 12.6667 4H15.3333C15.7013 4 16 3.70133 16 3.33333V0.666667C16 0.298667 15.7013 0 15.3333 0Z"
                    fill="white"/>
                <path
                    d="M15.3333 6H12.6667C12.2987 6 12 6.29867 12 6.66667V9.33333C12 9.70133 12.2987 10 12.6667 10H15.3333C15.7013 10 16 9.70133 16 9.33333V6.66667C16 6.29867 15.7013 6 15.3333 6Z"
                    fill="white"/>
                <path
                    d="M15.3333 12H12.6667C12.2987 12 12 12.2987 12 12.6667V15.3333C12 15.7013 12.2987 16 12.6667 16H15.3333C15.7013 16 16 15.7013 16 15.3333V12.6667C16 12.2987 15.7013 12 15.3333 12Z"
                    fill="white"/>
            </g>
            <defs>
                <clipPath id="clip0_776_27">
                    <rect width="16" height="16" fill="white"/>
                </clipPath>
            </defs>
        </svg>
        <button class="font-semibold text-xl text-white leading-tight">{{ __('Catalogue') }}</button>
    </div>
    <div @click.self="closeModal"
         :class="{
        'fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full': true,
        'hidden': !isShowModal,
         }">
        <div>
            <!-- Modal content -->
            <div class="mt-40 relative w-full max-w-7xl max-h-full mx-auto bg-white rounded-lg flex">
                <button type="button"
                        @click="closeModal"
                        class="absolute text-xl top-0 right-0 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                >
                    x
                </button>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <div v-for="category in $page.props.catalogRootCats"

                    >
                        <div :class="{
                            'text-lg  p-1 pl-2 cursor-pointer': true,
                            'bg-gray-100': selectedCategory == category && isMobileOpenCat,
                            }"
                             @mouseover="showChildrenOnHover(category)"
                        >
                            <Link :href="route('catalog', category.slug)"
                                  class="root-cat mr-2">{{ category.name }}</Link>
                            <span v-if="category.children.length"
                                  @click="showChildrenOnClick(category)"
                                  class="text-xs text-gray-500">
                                <i class="fa-solid fa-arrow-right"></i>
                            </span>
                        </div>
                        <div
                            class="grid lg:hidden children-cats lg:w-full lg:m-6 lg:grid lg:grid-cols-3 lg:grid-rows-4 lg:gap-4"
                            v-if="selectedCategory == category && isMobileOpenCat">
                            <div v-for="child in selectedCategory.children" :key="'mob' + child.id"
                                 class="child-cat flex items-center gap-2">
                                <div class="w-20 h-20 flex items-center">
                                    <img :src="child.image" :alt="child.name + ' image'">
                                </div>
                                <Link :href="route('catalog', child.slug)" class="child-title">{{ child.name }}</Link>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="hidden lg:grid children-cats lg:w-full lg:m-6 lg:grid lg:grid-cols-3 lg:grid-rows-4 lg:gap-4"
                    v-if="selectedCategory">
                    <div v-for="child in selectedCategory.children" :key="child.id"
                         class="child-cat flex items-center gap-2">
                        <div class="w-20 h-20 flex items-center">
                            <img :src="child.image" :alt="child.name + ' image'">
                        </div>
                        <Link :href="route('catalog', child.slug)"
                              class="child-title">{{ child.name }}
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">

.catalog-button {
    display: inline-flex;
    padding: 1em 1em;
    justify-content: center;
    align-items: center;
    gap: 6px;
    border-radius: 4px;
    background: #F53B49;

    &:hover {
        background: #E32A38;
        cursor: pointer;
    }
}

.root-cat {
    color: #1A1A25;
    font-style: normal;
    font-weight: 600;
    line-height: normal;
}

.child-title {
    font-style: normal;
    font-weight: 400;
    line-height: 150%;
}
</style>
