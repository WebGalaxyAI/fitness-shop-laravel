<script setup>

import {Head} from '@inertiajs/vue3';
import MainLayout from "@/Layouts/MainLayout.vue";

</script>

<template>
    <Head title="Dashboard"/>

    <MainLayout>
        <template #header>

        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
<style scoped lang="less">
</style>
