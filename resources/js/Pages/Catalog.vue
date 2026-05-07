<script setup>
import {Head} from '@inertiajs/vue3'
import MainLayout from "@/Layouts/MainLayout.vue";
import Breadcrumbs from "@/Components/Breadcrumbs.vue";
import MainTitle from "@/Components/MainTitle.vue";
import ContentWrapper from "@/Components/ContentWrapper.vue";
import SortingFields from "@/Components/SortingFields.vue";
import CategorySiblings from "@/Components/Catalog/CategorySiblings.vue";
import CatalogProducts from "@/Components/Catalog/CatalogProducts.vue";
import CatalogFilters from "@/Components/Catalog/CatalogFilters.vue";

defineProps({
        title: String,
        breadcrumbs: Array,
        category: Object,
        categorySiblings: Array,
        filters: Array,
        prices: Object,
        products: Array,
        total: Number,
        perPage: Number,
        currentPage: Number,
    }
)

</script>

<template>
    <Head :title="title"/>
    <MainLayout>
        <ContentWrapper class="mt-6">
            <Breadcrumbs :breadcrumbs="breadcrumbs" class="mb-6"/>
            <MainTitle :title="title"/>
            <div v-if="categorySiblings.length" class="grid grid-cols-1 sm:grid-cols-[2fr,1fr] gap-3 sm:gap-4 mb-6">
                <CategorySiblings :categorySiblings="categorySiblings"/>
                <SortingFields/>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-[6fr,1fr] gap-6 mb-6">
                <CatalogProducts :products="products" :per-page="perPage" :total="total" :current-page="currentPage"/>
                <aside class="hidden lg:block">
                    <CatalogFilters :filters="filters" :prices="prices"/>
                </aside>
            </div>
        </ContentWrapper>
    </MainLayout>
</template>


<style scoped>

</style>
