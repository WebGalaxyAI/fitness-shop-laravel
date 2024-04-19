<script setup>
import BlockTitle from "@/Components/BlockTitle.vue";
import BrandItem from "@/Components/BrandItem.vue";

defineProps({
        brands: Array,
}
)
</script>

<template>
    <div class="max-w-7xl mx-auto p-4 mb-6">
        <BlockTitle :title="__('Popular brands')"/>
        <div class="grid grid-cols-3 grid-rows-3 lg:grid-cols-4 xl:grid-cols-5">
                <BrandItem v-for="(brand, index) in brands"
                           :key="index + '-brand-item'"
                           :wrapper-class="{
                            'hidden lg:block': index >= 9 && index < 12,
                            'hidden lg:hidden xl:block': index >= 12,
                            }"
                           :brand="brand"/>
        </div>
    </div>
</template>

<style scoped lang="scss">
</style>
