<script setup>

import {usePage} from "@inertiajs/vue3";
import {computed, ref} from "vue";
import {useStore} from 'vuex';
import Link from "@/Components/Link.vue";

const page = usePage()
const props = defineProps({
        product: Object,
        buyButton: {
            type: Boolean,
            default: true,
        }
    }
)
const store = useStore();

const favoriteIds = ref(page.props.favoriteIds);
const isFavorite = computed(() => {
    return Object.values(favoriteIds.value).some((favId) => favId === props.product.id);
});

const toggleFavorite = async () => {
    try {
        const response = await axios.post(`/favorites/${props.product.id}`);
        favoriteIds.value = response.data.favoriteIds;
        store.commit('setFavoriteIds', Object.values(response.data.favoriteIds));
    } catch (error) {
        console.error(error);
    }
};
</script>

<template>
    <div
        class="relative product-card flex flex-col bg-white rounded-md transition duration-300 ease-in-out hover:scale-105 p-4">
        <div class="product-image w-full min-h-[220px] mp-6">
            <div class="hurt absolute right-4 cursor-pointer" @click="toggleFavorite()">
                <svg v-if="isFavorite" xmlns="http://www.w3.org/2000/svg" width="24" height="20" viewBox="0 0 24 20"
                     fill="none">
                    <path
                        d="M22.0718 1.95979C19.4616 -0.652909 15.2154 -0.652909 12.6059 1.95979L11.9998 2.56628L11.394 1.95979C8.78455 -0.653262 4.53795 -0.653262 1.92847 1.95979C-0.628032 4.51944 -0.644633 8.57675 1.88997 11.3977C4.2017 13.9698 11.0196 19.5265 11.3089 19.7617C11.5053 19.9215 11.7416 19.9993 11.9765 19.9993C11.9842 19.9993 11.992 19.9993 11.9994 19.999C12.2424 20.0103 12.4872 19.9268 12.6899 19.7617C12.9792 19.5265 19.7979 13.9698 22.1103 11.3974C24.6445 8.57675 24.6279 4.51944 22.0718 1.95979Z"
                        fill="#F53B49"/>
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" width="24" height="20" viewBox="0 0 24 20" fill="none">
                    <path
                        d="M22.0718 1.95979C19.4616 -0.652909 15.2154 -0.652909 12.6059 1.95979L11.9998 2.56628L11.394 1.95979C8.78455 -0.653262 4.53795 -0.653262 1.92847 1.95979C-0.628032 4.51944 -0.644633 8.57675 1.88997 11.3977C4.2017 13.9698 11.0196 19.5265 11.3089 19.7617C11.5053 19.9215 11.7416 19.9993 11.9765 19.9993C11.9842 19.9993 11.992 19.9993 11.9994 19.999C12.2424 20.0103 12.4872 19.9268 12.6899 19.7617C12.9792 19.5265 19.7979 13.9698 22.1103 11.3974C24.6445 8.57675 24.6279 4.51944 22.0718 1.95979ZM20.535 9.97823C18.7326 11.983 13.7782 16.1178 11.9994 17.585C10.2207 16.1181 5.26732 11.9837 3.46527 9.97858C1.69712 8.01093 1.68052 5.20868 3.42677 3.46028C4.31861 2.56769 5.48984 2.12105 6.66107 2.12105C7.8323 2.12105 9.00354 2.56734 9.89538 3.46028L11.2277 4.79421C11.3863 4.953 11.5862 5.04777 11.796 5.08102C12.1365 5.15422 12.5059 5.05909 12.7708 4.79457L14.1038 3.46028C15.8879 1.67475 18.7898 1.67511 20.5728 3.46028C22.319 5.20868 22.3024 8.01093 20.535 9.97823Z"
                        fill="#858FA4"/>
                </svg>
            </div>
            <Link :href="route('product', product.slug)">
                <div class="flex items-center h-full">
                    <img :src="product.image" class="max-h-[200px]" alt="Зображення продукту">
                </div>
            </Link>
        </div>
        <div class="product-details flex flex-col h-full justify-between text-sm">
            <div v-if="product.quantity > 0" class="flex items-center gap-2 text-xs mb-2">
                <div class="flex items-center gap-1 color-green">
                    <span>{{ __('In stock') }}</span>
                    <div class="flex gap-1">
                        <div class="green-dot"></div>
                        <div class="green-dot"></div>
                        <div class="green-dot"></div>
                    </div>
                </div>
                <span class="color-blue">{{ __('In showroom') }}</span>
            </div>
            <div class="detail-wrapper">
                <h2 class="product-title text-md mb-2">{{ product.name }}</h2>
                <div class="main-properties mb-2">
                    <p v-for="(attribute_value, index) in product.attribute_values.slice(0, 3)"
                       :key="`index-${index}`"
                       class="property"
                    >
                        <span class="text-gray-500">{{ attribute_value.attribute.name }}:</span>
                        {{ attribute_value.value }}
                    </p>
                    <div class="property flex items-center"><span class="text-gray-500 mr-1">Рейтинг:</span>
                        <div class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                                 fill="none">
                                <path
                                    d="M6 0.5L7.91148 3.86908L11.7063 4.6459L9.09284 7.50492L9.52671 11.3541L6 9.752L2.47329 11.3541L2.90716 7.50492L0.293661 4.6459L4.08852 3.86908L6 0.5Z"
                                    fill="#F99808"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                                 fill="none">
                                <path
                                    d="M6 0.5L7.91148 3.86908L11.7063 4.6459L9.09284 7.50492L9.52671 11.3541L6 9.752L2.47329 11.3541L2.90716 7.50492L0.293661 4.6459L4.08852 3.86908L6 0.5Z"
                                    fill="#F99808"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                                 fill="none">
                                <path
                                    d="M6 0.5L7.91148 3.86908L11.7063 4.6459L9.09284 7.50492L9.52671 11.3541L6 9.752L2.47329 11.3541L2.90716 7.50492L0.293661 4.6459L4.08852 3.86908L6 0.5Z"
                                    fill="#F99808"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                                 fill="none">
                                <path
                                    d="M6 0.5L7.91148 3.86908L11.7063 4.6459L9.09284 7.50492L9.52671 11.3541L6 9.752L2.47329 11.3541L2.90716 7.50492L0.293661 4.6459L4.08852 3.86908L6 0.5Z"
                                    fill="#F99808"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                                 fill="none">
                                <path
                                    d="M6 0.5L7.91148 3.86908L11.7063 4.6459L9.09284 7.50492L9.52671 11.3541L6 9.752L2.47329 11.3541L2.90716 7.50492L0.293661 4.6459L4.08852 3.86908L6 0.5Z"
                                    fill="#F99808"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2">
                <div class="prices">
                    <div v-if="product.sale_price" class="sale-price text-base">{{ product.sale_price }} грн.</div>
                    <div v-if="product.price" class="price text-sm">{{ product.price }} грн.</div>
                </div>
                <div class="flex items-center cursor-pointer">
                    <Link :href="route('product', product.slug)">
                        <div class="buy flex items-center gap-2 text-white rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="23" viewBox="0 0 20 23"
                                 fill="none">
                                <path
                                    d="M1.4 7.13816H18.4571V19.0001C18.4571 20.7121 17.0692 22.1001 15.3571 22.1001H4.5C2.78792 22.1001 1.4 20.7121 1.4 19.0001V7.13816Z"
                                    stroke="white" stroke-width="1.8"/>
                                <path
                                    d="M5.73624 11.4761V4.99988C5.73624 2.79074 7.5271 0.999884 9.73624 0.999884H10.1172C12.3263 0.999884 14.1172 2.79074 14.1172 4.99988V11.4761"
                                    stroke="white" stroke-width="1.8"/>
                            </svg>
                            {{ buyButton ? __('Buy') : __('In basket') }}
                        </div>
                    </Link>
                </div>
            </div>

        </div>
    </div>
</template>

<style scoped lang="scss">
.product-title {
    color: #1A1A25;
    font-style: normal;
    font-weight: 700;
    line-height: 130%; /* 20.8px */
}

.color-green {
    color: #2FC509;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
}

.color-blue {
    color: #4B7EE8;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
}

.green-dot {
    width: 0.6em;
    height: 0.6em;
    border-radius: 1em;
    background: #2FC509;
}

.property {
    font-style: normal;
    font-weight: 400;
    line-height: 140%; /* 19.6px */
}

.buy {
    background: #F53B49;

    display: flex;
    padding: 1em 0.7em;
    justify-content: center;
    align-items: center;
    gap: 4px;
    flex: 1 0 0;
}

.sale-price {
    color: #1A1A25;
    font-style: normal;
    font-weight: 700;
    line-height: 135.938%; /* 23.109px */
}

.price {
    color: #858FA4;
    font-style: normal;
    font-weight: 400;
    line-height: 135.938%; /* 20.391px */
    text-decoration: line-through;
}
</style>
