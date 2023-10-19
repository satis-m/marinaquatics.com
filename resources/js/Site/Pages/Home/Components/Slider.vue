<template>
    <section class="slider-area tpslider-delay">
        <div class="swiper-container tp-slider6">
                <swiper-container
                    :key="swiperKey"
                    init="false"
                    id="image-slider"
                >
                    <swiper-slide :key="key" v-for="(slider , key) in parentSliders">
                        <div class="swiper-slide tpslider__bg6" :data-background="slider.image">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="tpslider__five__wrapper pt-50 d-flex text-left">
                                            <!-- <div class="tpslider__five__brand mb-10">
                                               <img src="/web-site/assets/img/logo/MAN White.png" width="250px" alt="logo">
                                            </div> -->
                                            <div class="tpslider__five__contact text-center">
                                                <h3 class="tpslider__five__title">{{ slider.title }}</h3>
                                                <p>{{ slider.detail }}.</p>
                                                <div class="tpslider__five__btn">
                                                    <NavLink class="tp-btn" v-if="slider.link!='#' && slider.link!=''" :href="slider.link">{{ slider.link_text }} <i class="icon-chevrons-right"></i></NavLink>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </swiper-slide>
                </swiper-container>
                    <div class="tpslider__arrow d-none  d-xl-block">
                        <button class="tpsliderarrow tpslider__arrow-prv tpslider__prv6">
                            <i class="icon-chevron-left"></i>
                        </button>
                        <button class="tpsliderarrow tpslider__arrow-nxt tpslider__nxt6">
                            <i class="icon-chevron-right"></i>
                        </button>
                    </div>
                    <div class="slider-pagination-6"></div>
            </div>
    </section>
</template>
<script setup>
import {ref, watch, onMounted} from "@vue/runtime-core";
// import function to register Swiper custom elements
import Swiper from 'swiper';
import {register} from 'swiper/element/bundle';
// register Swiper custom elements

import 'swiper/css';

const props = defineProps({
    parentSliders: { type: Object, required: true },
});

const swiperKey = ref(1);
onMounted(() => {
    register();
    $("[data-background]").each(function () {
        $(this).css("background-image", "url( " + $(this).attr("data-background") + "  )");
    });
    const swiperEl = document.querySelector('#image-slider');
    const swiperParams = {
        // Optional parameters
        loop: true,
        slidesPerView: 1,
        observer: true,
        fade: true,
        effect: "fade",
        autoplay: {
            delay: 3500,
            disableOnInteraction: true,
        },
        // Navigation arrows
        navigation: {
            nextEl: '.tpslider__nxt6',
            prevEl: '.tpslider__prv6',
        },
        pagination: {
            el: ".slider-pagination-6",
            clickable: true,
        },
    };
    Object.assign(swiperEl, swiperParams);

    // and now initialize it
    swiperEl.initialize();
})
const onProgress = () => {
    console.log('progress')
}
const onSlideChange = () => {
    console.log('change slide')
}
</script>
<style scoped>
.swiper-container,#image-slider {
    height: calc(100vh - 75px);
}
@media (width <= 640px) {
    .swiper-container,#image-slider {
        height: 100%;
    }
}
.tp-btn
{
    display:flex;
    justify-content: center;
    align-items: center;
    gap:4px;
}
</style>
