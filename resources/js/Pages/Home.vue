<script setup>
import {Head} from '@inertiajs/vue3'
import MainLayout from "@/Layouts/MainLayout.vue";
import MainSlider from "@/Components/MainSlider.vue";
import HomeGym from "@/Components/HomeGym.vue";
import FitnessClubGym from "@/Components/FitnessClubGym.vue";
import PopularBrands from "@/Components/PopularBrands.vue";

const props = defineProps({
        title: String,
        sliders: Array,
        brands: Array,
        homeGymCats: Array,
        fitnessClubGymCats: Array,
    }
)

</script>

<template>
    <Head :title="$page.props.title"/>
    <MainLayout>
        <MainSlider :sliders="sliders"
                    style="transition: 0.25s ease-out"
                    v-motion-slide-bottom/>
        <HomeGym :categories="homeGymCats"
                 style="transition: 0.25s ease-out"
                 v-motion-slide-bottom/>
        <FitnessClubGym :categories="fitnessClubGymCats"
                        style="transition: 0.25s ease-out"
                        v-motion-slide-visible-once-bottom/>
        <PopularBrands :brands="brands"
                       style="transition: 0.25s ease-out"
                       v-motion-slide-visible-once-bottom/>
    </MainLayout>
</template>


<style scoped>

</style>
