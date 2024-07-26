<script setup>
import {usePage} from '@inertiajs/vue3'
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";

const page = usePage()

</script>

<template>
    <Dropdown align="right" width="20">
        <template #trigger>
            <span class="inline-flex rounded-md">
                <button
                    type="button"
                    class="inline-flex items-center border border-transparent text-sm leading-4 font-medium rounded-md text-white hover:text-gray focus:outline-none transition ease-in-out duration-150"
                >
                    <div class="flex items-center gap-1">
                        <img class="h-4" :src="'/img/front/' + $page.props.locale + '-flag-icon.svg'"
                             alt="ukraine-flag-icon">
                        <span>{{ $page.props.locale.toUpperCase() }}</span>
                    </div>

                    <svg
                        class="ml-2 -mr-0.5 h-4 w-4"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </button>
            </span>
        </template>
        <template #content>
            <template v-for="(langLink, index) in $page.props.languageSelector">
                <DropdownLink v-if="langLink.hreflang !== $page.props.locale"
                              rel="alternate"
                              :key="`lang${index}`"
                              :inertia="false"
                              :hreflang="langLink.hreflang"
                              :href="langLink.href">
                    <div class="flex items-center gap-1">
                        <img class="h-4" :src="'/img/front/' + langLink.hreflang + '-flag-icon.svg'"
                             :alt="langLink.title">
                        <span>{{ langLink.title }}</span>
                    </div>
                </DropdownLink>
            </template>
        </template>
    </Dropdown>
</template>

<style scoped>
</style>
