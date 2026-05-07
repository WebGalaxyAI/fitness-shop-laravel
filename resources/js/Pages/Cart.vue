<script setup>
import {Head} from '@inertiajs/vue3';
import {computed} from 'vue';
import {useStore} from 'vuex';
import MainLayout from '@/Layouts/MainLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import MainTitle from '@/Components/MainTitle.vue';
import ContentWrapper from '@/Components/ContentWrapper.vue';
import Link from '@/Components/Link.vue';

const props = defineProps({
    title: String,
    breadcrumbs: Array,
    cartProducts: Array,
});

const store = useStore();

const items = computed(() => {
    const qtyById = Object.fromEntries(store.state.cartItems.map(i => [i.id, i.quantity]));
    return props.cartProducts
        .filter(p => qtyById[p.id])
        .map(p => ({...p, quantity: qtyById[p.id]}));
});

const lineTotal = (p) => (p.sale_price ?? p.price ?? 0) * p.quantity;
const total = computed(() => items.value.reduce((sum, p) => sum + lineTotal(p), 0));

const setQuantity = async (product, quantity) => {
    try {
        const {data} = await axios.patch(route('cart.products.update', product.id), {quantity});
        store.commit('setCartItems', data.cartItems);
    } catch (e) {
        console.error('Cart update failed:', e);
    }
};

const inc = (p) => setQuantity(p, Math.min(99, p.quantity + 1));
const dec = (p) => setQuantity(p, p.quantity - 1);

const remove = async (product) => {
    try {
        const {data} = await axios.delete(route('cart.products.destroy', product.id));
        store.commit('setCartItems', data.cartItems);
    } catch (e) {
        console.error('Cart remove failed:', e);
    }
};

const fmt = (n) => Number(n).toLocaleString('uk-UA') + ' грн.';
</script>

<template>
    <Head :title="title"/>
    <MainLayout>
        <ContentWrapper class="mt-6">
            <Breadcrumbs :breadcrumbs="breadcrumbs" class="mb-6"/>
            <MainTitle :title="title"/>

            <div v-if="!items.length" class="empty mt-6 p-6 text-center bg-white rounded-md">
                {{ __('Cart is empty') }}
            </div>

            <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mt-6 mb-6">
                <ul class="lg:col-span-2 space-y-3">
                    <li v-for="p in items" :key="p.id"
                        class="cart-item bg-white rounded-md p-3 sm:p-4 md:flex md:items-center md:gap-4">
                        <div class="flex items-start gap-3 md:contents">
                            <Link :href="route('product', p.slug)" class="shrink-0">
                                <img :src="p.image" :alt="p.name" class="w-20 h-20 md:w-24 md:h-24 object-contain"/>
                            </Link>
                            <div class="flex-1 min-w-0">
                                <Link :href="route('product', p.slug)"
                                      class="title block font-semibold line-clamp-2 md:truncate">
                                    {{ p.name }}
                                </Link>
                                <div v-if="p.brand?.name" class="text-sm text-gray-500">{{ p.brand.name }}</div>
                            </div>
                            <button class="remove text-gray-400 hover:text-red-500 shrink-0 md:hidden"
                                    @click="remove(p)" :aria-label="__('Delete')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M6 2a1 1 0 0 0-1 1v1H3a1 1 0 1 0 0 2h1v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2h-2V3a1 1 0 0 0-1-1H6zm1 4h6v10H7V6z"/>
                                </svg>
                            </button>
                        </div>

                        <div class="mt-3 pt-3 border-t flex items-center justify-between gap-3 md:mt-0 md:pt-0 md:border-0 md:contents">
                            <div class="qty flex items-center gap-2 shrink-0">
                                <button class="qty-btn" :disabled="p.quantity <= 1" @click="dec(p)" :aria-label="__('Decrease')">−</button>
                                <span class="qty-value w-6 text-center">{{ p.quantity }}</span>
                                <button class="qty-btn" :disabled="p.quantity >= 99" @click="inc(p)" :aria-label="__('Increase')">+</button>
                            </div>
                            <div class="price text-right shrink-0">
                                <div v-if="p.sale_price" class="font-bold">{{ fmt(p.sale_price) }}</div>
                                <div v-if="p.price" class="text-sm text-gray-500" :class="{ 'line-through': p.sale_price }">
                                    {{ fmt(p.price) }}
                                </div>
                            </div>
                            <button class="remove text-gray-400 hover:text-red-500 hidden md:block ml-2"
                                    @click="remove(p)" :title="__('Delete')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M6 2a1 1 0 0 0-1 1v1H3a1 1 0 1 0 0 2h1v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2h-2V3a1 1 0 0 0-1-1H6zm1 4h6v10H7V6z"/>
                                </svg>
                            </button>
                        </div>
                    </li>
                </ul>

                <aside class="summary bg-white rounded-md p-4 sm:p-5 h-fit lg:sticky lg:top-4">
                    <div class="flex items-center justify-between text-lg font-semibold mb-3">
                        <span class="text-red-500">{{ __('Total') }}</span>
                        <span>{{ fmt(total) }}</span>
                    </div>
                    <div class="text-sm text-gray-500 border-t pt-3">
                        {{ __('Items') }}: {{ items.length }}
                    </div>
                </aside>
            </div>
        </ContentWrapper>
    </MainLayout>
</template>

<style scoped lang="scss">
.cart-item .title {
    color: #1A1A25;
}

.qty-btn {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    border: 1px solid #E5E7EB;
    color: #1A1A25;
    background: #fff;
    font-size: 18px;
    line-height: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s ease;

    &:hover:not(:disabled) {
        border-color: #F53B49;
        color: #F53B49;
    }

    &:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }
}

.qty-value {
    font-weight: 600;
}
</style>
