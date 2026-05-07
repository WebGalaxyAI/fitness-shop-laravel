<script setup>
import {computed, ref} from "vue";
import {useStore} from "vuex";

const props = defineProps({
    product: Object,
});

const store = useStore();
const busy = ref(false);

const isInCart = computed(() => store.getters.cartProductIds.includes(props.product.id));

const toggle = async () => {
    if (busy.value) return;
    busy.value = true;
    try {
        if (isInCart.value) {
            const {data} = await axios.delete(route('cart.products.destroy', props.product.id));
            store.commit('setCartItems', data.cartItems);
        } else {
            const {data} = await axios.post(route('cart.products.store'), {
                slug: props.product.slug,
                quantity: 1,
            });
            store.commit('setCartItems', data.cartItems);
        }
    } catch (e) {
        console.error('Cart toggle failed:', e);
    } finally {
        busy.value = false;
    }
};
</script>

<template>
    <button class="cart-btn"
            :class="{ 'is-in-cart': isInCart }"
            :disabled="busy"
            @click="toggle">
        <svg v-if="!isInCart" xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 20 23" fill="none">
            <path d="M1.4 7.13816H18.4571V19.0001C18.4571 20.7121 17.0692 22.1001 15.3571 22.1001H4.5C2.78792 22.1001 1.4 20.7121 1.4 19.0001V7.13816Z"
                  stroke="currentColor" stroke-width="1.8"/>
            <path d="M5.73624 11.4761V4.99988C5.73624 2.79074 7.5271 0.999884 9.73624 0.999884H10.1172C12.3263 0.999884 14.1172 2.79074 14.1172 4.99988V11.4761"
                  stroke="currentColor" stroke-width="1.8"/>
        </svg>
        <svg v-else xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none">
            <path d="M5 12l5 5L20 7" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span class="hidden sm:inline">{{ isInCart ? __('In basket') : __('Buy') }}</span>
    </button>
</template>

<style scoped lang="scss">
.cart-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 12px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 14px;
    line-height: 1.2;
    background: #F53B49;
    color: #fff;
    border: 1px solid #F53B49;
    transition: background 0.15s ease, color 0.15s ease, border-color 0.15s ease;

    @media (min-width: 640px) {
        padding: 10px 16px;
    }

    &:hover:not(:disabled) {
        background: #DA2A38;
        border-color: #DA2A38;
    }

    &.is-in-cart {
        background: #fff;
        color: #F53B49;

        &:hover:not(:disabled) {
            background: #FFF5F6;
        }
    }

    &:disabled {
        opacity: 0.7;
        cursor: progress;
    }
}
</style>
