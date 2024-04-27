<script setup>
import {Head} from '@inertiajs/vue3'
import MainLayout from "@/Layouts/MainLayout.vue";
import MainTitle from "@/Components/MainTitle.vue";
import ContentWrapper from "@/Components/ContentWrapper.vue";

defineProps({
        title: String,
    }
)

</script>

<template>
    <Head :title="$page.props.title"/>
    <MainLayout>
        <ContentWrapper class="mt-6">
            <MainTitle :title="title"/>
           Тут буде каталог товарів
        </ContentWrapper>
    </MainLayout>
</template>


<style scoped>

</style>
