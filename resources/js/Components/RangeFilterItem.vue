<script setup>
import {onMounted, ref} from "vue";
import Slider from '@vueform/slider';
import DefaultButton from "@/Components/DefaultButton.vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
        title: String,
        queryParam: String,
        minValue: Number,
        maxValue: Number,
    }
)

const value = ref([props.minValue, props.maxValue]);
const updateValue = (value, index) => {
    value.value[index] = parseFloat(value);
};

onMounted(() => {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has(props.queryParam)) {
        const paramValue = urlParams.get(props.queryParam);
        const [minVal, maxVal] = paramValue.split('_').map(parseFloat);
        value.value = [minVal, maxVal];
    }
});

const goToUrl = () => {
    const params = new URLSearchParams(window.location.search);
    params.set(props.queryParam, `${value.value[0]}_${value.value[1]}`);
    const newParams = params.toString();
    const currentURL = new URL(window.location.href);
    currentURL.search = newParams;
    router.visit(currentURL.href);
};
</script>

<template>
    <div class="filter-item text-sm">
        <div class="property-name mb-2">{{ title }}</div>
        <div>
            <div class="flex items-center mb-6 gap-2">
                <template v-for="(val, index) in value" :key="'filter'+index">
                    <input
                        class="range-input text-sm w-20 p-1 rounded border-gray-300"
                        type="number"
                        :value="val"
                        :min="minValue"
                        :max="maxValue"
                        @input="updateValue($event.target.value, index)"
                    />
                    <template v-if="index === 0 && value.length > 1">
                        <div class="w-4 h-[0.1em] bg-gray-500"></div>
                    </template>
                </template>
                <DefaultButton class="h-[29px]" text="ОК" :text-x-s="true" @click="goToUrl"/>
            </div>
            <Slider v-model="value"
                    tooltipPosition="bottom"
                    showTooltip="drag"
                    class="slider-red mx-2"
                    :min="minValue"
                    :max="maxValue"
            />
        </div>
    </div>
</template>

<style src="@vueform/slider/themes/default.css"></style>

<style scoped lang="scss">

.slider-red {
    --slider-connect-bg: #EF4444;
    --slider-tooltip-bg: #EF4444;
    --slider-handle-ring-color: #EF444430;
    --slider-height: 2px;
}

.range-input {
    color: #384255;
    font-style: normal;
    font-weight: 500;
    line-height: 140%; /* 16.8px */
}

.property-name {
    color: #384255;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
}

</style>
