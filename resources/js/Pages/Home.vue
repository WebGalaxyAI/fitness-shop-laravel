<script setup>
import {Head} from '@inertiajs/vue3'
import MainLayout from "@/Layouts/MainLayout.vue";

const props = defineProps({
        title: String,
    }
)

</script>

<template>
    <Head :title="$page.props.title"/>
    <MainLayout>
        Тут буде контент головної сторінки
    </MainLayout>
</template>


<style scoped>

</style>
