<script setup>
import BlockTitle from "@/Components/BlockTitle.vue";
import DefaultButton from "@/Components/DefaultButton.vue";
import ImageCard from "@/Components/ImageCard.vue";

defineProps({
        categories: Array,
    }
)
</script>

<template>
    <div v-if="categories.length" class="max-w-7xl mx-auto p-4 mb-6">
        <BlockTitle :title="__('For fitness clubs')"/>
        <div class="grid grid-rows-4 grid-cols-2 gap-4 lg:grid-rows-2 lg:grid-cols-4 lg:gap-8 mb-6">
            <ImageCard
                v-for="(category, index) in categories"
                :key="index + '-fitness-gym-item'"
                :item="category"
                :wrapper-class="{
                    'bg-dark-site': index === 0,
                    'col-span-2': index < 1,
                    'h-48': index >= 2 && index < 6,
                }"
                :title-class="{
                    'image-card__title_white': index === 0
                }"
            />
        </div>
        <DefaultButton :text="__('All categories')"/>
<!--        :href="route('catalog', 'dlia-fitnes-klubiv')"-->
    </div>
</template>


<style scoped lang="scss">
</style>
