<script setup>
import {Head} from '@inertiajs/vue3'
import MainLayout from "@/Layouts/MainLayout.vue";
import RedButton from "@/Components/RedButton.vue";

const props = defineProps({
        title: String,
        text: String,
        error: Number,
    }
)

</script>

<template>
    <Head :title="title"/>
    <MainLayout>
        <div class="bg-404 h-screen pt-32">
            <h1 class="main-text">
                <div>
                    {{ text }}
                </div>
                <div>
                    <RedButton :text="__('Go back to the main page')" :href="route('home')"/>
                </div>
            </h1>
        </div>
    </MainLayout>
</template>


<style scoped>
.bg-404 {
    background-image: url('/img/errors/bg-404.png');
    background-size: cover;
    background-position: center;

}

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
