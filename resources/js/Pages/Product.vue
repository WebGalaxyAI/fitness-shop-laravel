<script setup>
import {Head} from '@inertiajs/vue3'
import MainLayout from "@/Layouts/MainLayout.vue";
import MainTitle from "@/Components/MainTitle.vue";
import ContentWrapper from "@/Components/ContentWrapper.vue";

const props = defineProps({
        title: String,
    }
)
</script>

<template>
    <Head :title="title"/>
    <MainLayout>
        <ContentWrapper class="mt-6">
            <MainTitle :title="title"/>
            Тут буде інформація про товар
        </ContentWrapper>
    </MainLayout>
</template>

<style scoped>
</style>
