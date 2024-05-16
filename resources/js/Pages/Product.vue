<script setup>
import {Head} from '@inertiajs/vue3'
import MainLayout from "@/Layouts/MainLayout.vue";
import Breadcrumbs from "@/Components/Breadcrumbs.vue";
import MainTitle from "@/Components/MainTitle.vue";
import ContentWrapper from "@/Components/ContentWrapper.vue";
import {useStore} from "vuex";

import {ref} from 'vue';
import ProductSlider from "@/Components/Product/ProductSlider.vue";
import ProductDetail from "@/Components/Product/ProductDetail.vue";

const store = useStore();

const props = defineProps({
        title: String,
        product: Object,
        breadcrumbs: Array,
    }
)
const slides = ref([...props.product.media].map(item => {
    return {
        src: item.original_url,
        alt: 'Product img',
    };
}))

</script>

<template>
    <Head :title="title"/>
    <MainLayout>
        <ContentWrapper class="mt-6">
            <Breadcrumbs :breadcrumbs="breadcrumbs" class="mb-6"/>
            <MainTitle :title="product.name"/>
            <div class="grid grid-cols-2">
                <ProductSlider :slides="slides"/>
                <ProductDetail :product="product"/>
            </div>
        </ContentWrapper>
    </MainLayout>
</template>

<style scoped>
</style>
