<script setup>
import ProductCard from "@/Components/ProductCard.vue";
import Pagination from "@/Components/Pagination.vue";
import {ref} from "vue";

const props = defineProps({
        products: Array,
        total: Number,
        perPage: Number,
        currentPage: Number,
    }
)

const products = ref(props.products);
const currentPage = ref(props.currentPage);

const loadProducts = async (url, totalPages) => {
    if (currentPage.value === totalPages) {
        return;
    }

    try {
        const response = await axios.get(url.replace('catalog', 'catalog-load-more'));
        history.replaceState({}, '', url);
        currentPage.value++;
        products.value = [...products.value, ...response.data];
    } catch (error) {
        console.error('Помилка при завантаженні продуктів:', error);
    }
}

</script>

<template>
    <div>
        <div class="product-cards grid grid-cols-4 gap-6 mr-4 mb-6">
            <ProductCard v-for="(product, index) in products"
                         :key="'catalog-product-' + index"
                         :product="product"
            />
        </div>
        <Pagination :per-page="perPage" :total="total" :current-page="currentPage" @show-more="loadProducts"/>
    </div>
</template>

<style scoped lang="scss">
.product-cards {
    align-self: start;
}
</style>
