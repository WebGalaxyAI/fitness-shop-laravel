<script setup>
import Footer from "@/Layouts/Footer.vue";
import Header from "@/Layouts/Header.vue";
</script>

<template>
    <div class="main-wrapper min-h-screen bg-gray-100">
        <Header/>
        <!-- Page Content -->
        <main>
            <slot/>
        </main>
        <Footer/>
    </div>
</template>

<style scoped lang="scss">
@import "./resources/scss/_variables.scss";

.main-wrapper {
    display: grid;
    grid-template-rows: auto 1fr auto; /* автоматична висота хедера та футера, решта простір на контент */
    min-height: 100vh; /* забезпечення повноекранного розміщення */
}
</style>
