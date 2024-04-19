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
    <div v-if="categories.length"
         class="max-w-7xl mx-auto p-4 mb-6">
        <BlockTitle :title="__('Trainers for home')"/>
        <div class="grid grid-rows-6 grid-cols-2 gap-4 lg:grid-rows-3 lg:grid-cols-4 lg:gap-8 mb-6">
            <ImageCard
                v-for="(category, index) in categories"
                :key="index + '-home-gym-item'"
                :item="category"
                :wrapper-class="{
                    'home-gym-cat relative overflow-hidden': true,
                    'bg-dark-site': index === 0,
                    'col-span-2 lg:col-span-1 lg:row-span-2': index < 2,
                    'h-48': index >= 2 && index < 6,
                    'lg:row-span-3': index >= 6,
                }"
                :title-class="{
                    'image-card__title_white': index === 0,
                }"
            />
        </div>
        <DefaultButton :text="__('All categories')"/>
<!--                       :href="route('catalog', 'trenazeri-dlia-domu')"-->

    </div>

</template>


<style scoped lang="scss">
@import "./resources/scss/_variables.scss";

.home-gym-cat {
    border-radius: 6px;
    background: #F0F1F7;

    &__title {
        color: #1A1A25;
        font-style: normal;
        font-weight: 800;
        line-height: 120%; /* 24px */
        &_white {
            color: white;
        }
    }
}

.bg-dark-site {
    background: $main-dark;
}
</style>
