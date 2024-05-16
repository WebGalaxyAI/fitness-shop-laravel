<script setup>
import {reactive, ref} from "vue";
const isProductInCart = ref(false);
const props = defineProps({
        product: Object,
    }
)

const form = reactive({
    slug: props.product.slug,
    quantity: 1,
})

const addToCart = async () => {
    if (isProductInCart.value) {
        return;
    }
    try {
        const response = await axios.post(route('cart.products.store'), form);
        console.log(response)
        // isProductInCart.value = true;
    } catch (error) {
        console.error('Add product to cart error: ', error);
    }
}
</script>

<template>
    <div class="flex items-center cursor-pointer">
        <button class="w-auto buy flex items-center gap-2 text-white rounded" @click="addToCart()">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="23" viewBox="0 0 20 23" fill="none">
                <path
                    d="M1.4 7.13816H18.4571V19.0001C18.4571 20.7121 17.0692 22.1001 15.3571 22.1001H4.5C2.78792 22.1001 1.4 20.7121 1.4 19.0001V7.13816Z"
                    stroke="white" stroke-width="1.8"/>
                <path
                    d="M5.73624 11.4761V4.99988C5.73624 2.79074 7.5271 0.999884 9.73624 0.999884H10.1172C12.3263 0.999884 14.1172 2.79074 14.1172 4.99988V11.4761"
                    stroke="white" stroke-width="1.8"/>
            </svg>
            {{ __('In basket') }}
        </button>
    </div>
</template>
