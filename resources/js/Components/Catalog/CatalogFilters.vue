<script setup>
import CheckboxFilterItem from "@/Components/CheckboxFilterItem.vue";
import DefaultButton from "@/Components/DefaultButton.vue";
import RangeFilterItem from "@/Components/RangeFilterItem.vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
        filters: Array,
        prices: Object,
    }
)

const clearURLParams = () => {
    const currentURL = new URL(window.location.href);
    currentURL.search = '';

    router.visit(currentURL.href);
};
</script>

<template>
    <div>
        <RangeFilterItem :title="__('Price')" :min-value="prices.min_price" :max-value="prices.max_price" queryParam="price"/>
        <hr class="my-4"/>
        <template v-for="(filter, index) in filters">
            <CheckboxFilterItem v-if="filter.frontend_type === 'checkbox'" :filter="filter" :key="'attribute-'+index"/>
            <hr class="my-4"/>
        </template>
        <DefaultButton text="Очистить" :text-x-s="true" @click="clearURLParams"/>
    </div>
</template>

<style scoped lang="scss">
</style>
