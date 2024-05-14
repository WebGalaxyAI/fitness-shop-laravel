<script setup>
import {onMounted, ref} from 'vue';
import {usePage, router} from "@inertiajs/vue3";

const page = usePage();

const selectedFilters = ref([]);

const handleCheckboxChange = (value) => {
    const queryParams = new URLSearchParams(window.location.search)

    if (queryParams.has(props.filter.code)) {
        const filterValues = queryParams.getAll(props.filter.code)[0].split(',');

        // Видалення значень, якщо вони вже присутні
        if (filterValues.includes(value)) {
            const updatedFilters = filterValues.filter((filter) => filter !== value);
            queryParams.delete(props.filter.code);
            if (updatedFilters.length) {
                queryParams.append(props.filter.code, updatedFilters.join(','));
            }

        } else {
            filterValues.push(value)
            queryParams.delete(props.filter.code);
            queryParams.append(props.filter.code, filterValues.join(','));
        }

    } else {
        queryParams.append(props.filter.code, value);
    }
    queryParams.set('page', '1');

    updateUrlWithFilters(queryParams);
};

const updateUrlWithFilters = (searchParams) => {
    const params = new URLSearchParams();
    searchParams.forEach((value, key) => {
        params.set(key, value);
    });

    const newParams = params.toString();
    const currentURL = new URL(window.location.href);

    currentURL.search = newParams;
    router.visit(currentURL.href);
};

const parseFiltersFromUrl = () => {
    const queryParams = new URLSearchParams(page.url.split('?')[1]); // Отримуємо параметри з URL

    if (queryParams.has(props.filter.code)) {
        const filterValues = queryParams.get(props.filter.code).split(',');
        selectedFilters.value.push(...filterValues);
    }
};

onMounted(() => {
    parseFiltersFromUrl(); // Викликаємо функцію для розбору параметрів з URL при завантаженні компонента
});

const props = defineProps({
        filter: Object,
    }
)
</script>

<template>
    <div class="filter-item text-sm">
        <div class="property-name mb-2">{{ filter.name }} <span class="text-sm  text-gray-400">{{ filter.facet_count }}</span></div>
        <ul>
            <li v-for="(value, index) in filter.values" class="mb-2" :key="'value-'+index">
                <label class="filter-label" for="gym80">
                    <input class="rounded border-gray-300"
                           type="checkbox"
                           :id="`checkbox-${index}`"
                           :value="value.code"
                           v-model="selectedFilters"
                           @change="handleCheckboxChange(value.code)"
                    >
                    {{ value.value }} <span class="text-gray-500 text-sm">({{ value.facet_count }})</span>
                </label>
            </li>
        </ul>
    </div>
</template>

<style scoped lang="scss">
input[type="checkbox"]:checked {
    background-color: #2FC509; /* Зелений колір заливки */
}

.property-name {
    color: #384255;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
}

.filter-label {
    color: #384255;
    font-style: normal;
    font-weight: 400;
    line-height: 140%; /* 19.6px */
}
</style>
