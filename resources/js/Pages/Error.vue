<script setup>
import { Head } from '@inertiajs/vue3'
import MainLayout from "@/Layouts/MainLayout.vue";
import RedButton from "@/Components/RedButton.vue";

const props = defineProps({
    title: String,
    text: String,
    error: Number,
    imagePath: String,
});
</script>

<template>
    <Head :title="title"/>
    <MainLayout>
        <div class="h-screen pt-32 relative">
            <img :src="imagePath" alt="Background" class="absolute inset-0 w-full h-full object-cover z-0"/>
            <div class="main-text relative z-10">
                <div>
                    {{ text }}
                </div>
                <div :class="error === 500 ? 'mt-12' : 'mt-1'">
                    <RedButton :text="__('Go back to the main page')" :href="route('home')"/>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<style scoped>
.main-text {
    display: flex;
    flex-direction: column;
    gap: 37px;
    color: #1A1A25;
    text-align: center;
    font-size: 38px;
    font-style: normal;
    font-weight: 800;
    line-height: 110%;
}
</style>
