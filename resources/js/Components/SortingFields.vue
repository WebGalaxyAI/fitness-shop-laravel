<script setup>
import {usePage, router} from "@inertiajs/vue3";
import myMixin from "../mixin"

const page = usePage();
const __ = key => myMixin.methods.__(key, {}, page);

const sortFields = [
    {
        label: __('For popularity'),
        isActive: true,
        key: 'popularity',
        direction: 'asc',
    },
    {
        label: __('For novelty'),
        isActive: false,
        key: 'novelty',
        direction: 'asc',
    },
    {
        label: __('For price'),
        isActive: false,
        key: 'price',
        direction: 'asc',
    },
    {
        label: __('For rating'),
        isActive: false,
        key: 'rating',
        direction: 'asc',
    }
];

const goSortUrl = (key) => {
    const params = new URLSearchParams(window.location.search);
    const field = sortFields.find(item => item.key === key);
    if (!field) {
        return;
    }
    if (field.direction === 'asc') {
        field.direction = 'desc';
    } else {
        field.direction = 'asc';
    }

    field.isActive = true;
    sortFields.forEach(item => {
        if (item.key !== key) {
            item.isActive = false; // Знімаємо позначку активності з інших полів
        }
    });
    params.set('sort', `${key}_${field.direction}`);
    params.delete('page');
    const newParams = params.toString();
    const currentURL = new URL(window.location.href);
    currentURL.search = newParams;
    router.visit(currentURL.href);
};

const setSortDirectionFromURL = () => {
    const params = new URLSearchParams(window.location.search);
    const sortParam = params.get('sort');

    if (sortParam) {
        const [key, direction] = sortParam.split('_');
        const field = sortFields.find(item => item.key === key);

        if (field && (direction === 'asc' || direction === 'desc')) {
            field.direction = direction;
            field.isActive = true;
            sortFields.forEach(item => {
                if (item.key !== key) {
                    item.isActive = false;
                }
            });
        }
    }
};

setSortDirectionFromURL();

</script>

<template>
    <div class="sort-fields flex flex-wrap gap-2">
        <div v-for="(field, index) in sortFields"
             @click="goSortUrl(field.key)"
             :key="index"
             class="cursor-pointer flex flex-wrap items-end gap-1"
             :class="['sort-field', field.isActive ? 'sort-field_active' : '']">
            <div class="arrow-icon-wrapper" v-if="field.isActive">
                <svg v-if="field.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <line x1="5" y1="8" x2="19" y2="8" stroke="#384255" stroke-width="2"/>
                    <line x1="5" y1="12" x2="14" y2="12" stroke="#384255" stroke-width="2"/>
                    <line x1="5" y1="16" x2="9" y2="16" stroke="#384255" stroke-width="2"/>
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <line y1="-1" x2="14" y2="-1" transform="matrix(1 0 0 -1 5 15)" stroke="#384255" stroke-width="2"/>
                    <line y1="-1" x2="9" y2="-1" transform="matrix(1 0 0 -1 5 11)" stroke="#384255" stroke-width="2"/>
                    <line y1="-1" x2="4" y2="-1" transform="matrix(1 0 0 -1 5 7)" stroke="#384255" stroke-width="2"/>
                </svg>
            </div>
            <div class="pb-[0.05em]">
                {{ field.label }}
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
.sort-field {
    color: #384255;
    font-style: normal;
    font-weight: 400;
    line-height: 140%; /* 19.6px */

    &_active {
        font-weight: 700;
    }
}

.arrow-icon-wrapper {
}
</style>
