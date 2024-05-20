<script setup>
import {Head} from '@inertiajs/vue3'
import MainLayout from "@/Layouts/MainLayout.vue";
import Breadcrumbs from "@/Components/Breadcrumbs.vue";
import MainTitle from "@/Components/MainTitle.vue";
import ContentWrapper from "@/Components/ContentWrapper.vue";
import ProductCard from "@/Components/Catalog/ProductCard.vue";
import {computed} from "vue";
import {useStore} from "vuex";

const store = useStore();

const props = defineProps({
        title: String,
        breadcrumbs: Array,
        favoriteProducts: Array,
    }
)

const filteredFavoriteProducts = computed(() => {
    const favoriteIds = store.state.favoriteIds;
    return props.favoriteProducts.filter(product => favoriteIds.includes(product.id));
});

</script>

<template>
    <Head :title="title"/>
    <MainLayout>
        <ContentWrapper class="mt-6">
            <Breadcrumbs :breadcrumbs="breadcrumbs" class="mb-6"/>
            <MainTitle :title="title"/>
            <div class="product-cards grid grid-cols-4 gap-6 mr-4 mb-6">
                <ProductCard v-for="(product, index) in filteredFavoriteProducts"
                             :key="'favorite-product-' + index"
                             :product="product"
                             :buy-button="false"
                />
            </div>
        </ContentWrapper>
    </MainLayout>
</template>


<style scoped>

</style>
