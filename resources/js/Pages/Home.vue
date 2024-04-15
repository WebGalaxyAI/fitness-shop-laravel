<script setup>
import {Head} from '@inertiajs/vue3'
import MainLayout from "@/Layouts/MainLayout.vue";
import MainSlider from "@/Components/MainSlider.vue";

const props = defineProps({
        title: String,
        sliders: Array,
    }
)

</script>

<template>
    <Head :title="$page.props.title"/>
    <MainLayout>
        <MainSlider :sliders="sliders"/>
    </MainLayout>
</template>


<style scoped>

</style>
