<script setup>
import {onMounted} from "vue";
import DefaultButton from "@/Components/DefaultButton.vue";

let slides = null;
let btnRight = null;
let btnLeft = null;

const props = defineProps({
        sliders: Array,
    }
)

let currSlide = 0;
const maxSlides = props.sliders.length;

onMounted(() => {
    slides = document.querySelectorAll(".slide");
    btnRight = document.querySelector(".slider__btn--right");
    btnLeft = document.querySelector(".slider__btn--left");

    btnRight.addEventListener("click", nextSlide);
    btnLeft.addEventListener("click", prevSlide);

    document.addEventListener("keydown", function (e) {
        if (e.key === "ArrowLeft") {
            prevSlide();
        }
        if (e.key === "ArrowRight") {
            nextSlide();
        }
    });

    goToSlide(0);
    setInterval(() => {
        nextSlide();
    }, 5000);
})

function goToSlide(slide) {
    slides.forEach(function (s, i) {
        let adjustedIndex = i - slide;

        if (adjustedIndex < 0) {
            adjustedIndex += maxSlides;
        }

        s.style.transform = `translateX(${100 * adjustedIndex}%)`;
    });
}

function nextSlide() {
    currSlide = (currSlide + 1) % maxSlides;
    goToSlide(currSlide);
}

function prevSlide() {
    currSlide = (currSlide - 1 + maxSlides) % maxSlides;
    goToSlide(currSlide);
}

</script>

<template>
    <div v-if="sliders.length" ref="mainCarousel" class="slider relative w-full p-8">
        <!-- Carousel wrapper -->
        <div class="relative h-56 overflow-hidden rounded-lg md:h-72 xl:h-96">
            <!-- Item -->
            <div v-for="(slider, index) in sliders"
                 class="slide duration-700 ease-in-out"
            >
                <!-- Транспарентна заливка -->
                <div class="absolute w-full min-h-screen slider-bg"></div>
                <div class="relative max-w-7xl mx-auto">
                    <div class="slider-text-wrapper z-[10] absolute grid grid-cols-1 gap-2 top-4 left-4 xl:top-10 xl:left-10">
                        <div class="slider-title uppercase">
                            {{ slider.title }}
                        </div>
                        <div class="slider-text uppercase">
                            {{ slider.text }}
                        </div>
                        <div class="slider-button-wrapper">
                            <DefaultButton :text="slider.button"
                                           :href="slider.url"
                            />
                        </div>
                    </div>
                    <img :src="slider.image"
                         class="absolute right-0" :alt="slider.title + ' image'">
                </div>
            </div>
        </div>
        <!-- Slider controls -->
        <div class="absolute bottom-16 right-16 xl:right-32 flex">
            <button type="button"
                    class="slider__btn--left z-30 flex items-center justify-center px-4 cursor-pointer group focus:outline-none"
            >
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                    <svg class="w-4 h-4 text-red-500  rtl:rotate-180" aria-hidden="true"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 1 1 5l4 4"/>
                    </svg>
                </span>
            </button>
            <button type="button"
                    class="slider__btn--right z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            >
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white group-hover:bg-white/50  group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                    <svg class="w-4 h-4 text-red-500  rtl:rotate-180" aria-hidden="true"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="m1 9 4-4-4-4"/>
                    </svg>
                </span>
            </button>
        </div>

    </div>


</template>

<style scoped lang="scss">

.slider-bg {
    background-color: #E9EAEF;
}

.slider-title {
    color: #F53B49;
    font-size: 18px;
    font-style: normal;
    font-weight: 900;
    line-height: 110%; /* 26.4px */
    text-transform: uppercase;
}

.slider-text-wrapper {
    width: 250px;
}

.slider-text {
    color: #1A1A25;
    font-size: 24px;
    font-style: normal;
    font-weight: 900;
    line-height: 110%; /* 54.5px */
    text-transform: uppercase;
}

@media (min-width: 768px) {
    .slider-title {
        font-size: 22px;
    }

    .slider-text-wrapper {
        width: 400px;
    }

    .slider-text {
        font-size: 36px;
    }
}

@media (min-width: 1024px) {
    .slider-title {
        font-size: 24px;
    }

    .slider-text-wrapper {
        width: 450px;
    }

    .slider-text {
        font-size: 40px;
    }
}

@media (min-width: 1280px) {
    .slider-title {
        font-size: 24px;
    }

    .slider-text-wrapper {
        width: 512px;
    }

    .slider-text {
        font-size: 48px;
    }
}
</style>
