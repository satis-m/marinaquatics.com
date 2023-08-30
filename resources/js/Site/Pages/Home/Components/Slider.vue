<template>
    <section class="slider-area tpslider-delay">
        <div class="swiper-container tp-slider6">

                <swiper-container
                    :key="swiperKey"
                    init="false"
                    style="height: 100%"
                    id="image-slider"
                >
                    <swiper-slide>
                        <div class="swiper-slide tpslider__bg6" data-background="/web-site/assets/img/slider/topbanner1.jpg">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="tpslider__five__wrapper pt-150 text-left">
                                            <!-- <div class="tpslider__five__brand mb-10">
                                               <img src="/web-site/assets/img/logo/MAN White.png" width="250px" alt="logo">
                                            </div> -->
                                            <div class="tpslider__five__contact">
                                                <h3 class="tpslider__five__title">Top Quality</h3>
                                                <p>Our fresh Vietnamese vegetable rolls look taste even better.</p>
                                                <div class="tpslider__five__btn">
                                                    <a class="tp-btn" href="shop-3.html">Shop Now <i class="icon-chevrons-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </swiper-slide>
                    <swiper-slide>
                        <div class="swiper-slide tpslider__bg6" data-background="/web-site/assets/img/slider/topbanner2.jpg">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="tpslider__five__wrapper pt-150 text-left">
                                            <!-- <div class="tpslider__five__brand mb-10">
                                               <img src="/web-site/assets/img/logo/MAN White.png" width="250px" alt="logo">
                                            </div> -->
                                            <div class="tpslider__five__contact">
                                                <h3 class="tpslider__five__title">High Quality</h3>
                                                <p>Our fresh Vietnamese vegetable rolls look taste even better.</p>
                                                <div class="tpslider__five__btn">
                                                    <a class="tp-btn" href="shop-3.html">Shop Now <i class="icon-chevrons-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </swiper-slide>
                    <swiper-slide>
                        <div class="swiper-slide tpslider__bg6" data-background="/web-site/assets/img/slider/topbanner3.jpg">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="tpslider__five__wrapper pt-150 text-left">
                                            <!-- <div class="tpslider__five__brand mb-10">
                                               <img src="/web-site/assets/img/logo/MAN White.png" width="250px" alt="logo">
                                            </div> -->
                                            <div class="tpslider__five__contact">
                                                <h3 class="tpslider__five__title">Fresh Fish</h3>
                                                <p>Our fresh Vietnamese vegetable rolls look taste even better.</p>
                                                <div class="tpslider__five__btn">
                                                    <a class="tp-btn" href="shop-3.html">Shop Now <i class="icon-chevrons-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </swiper-slide>
                    <swiper-slide>
                        <div class="swiper-slide tpslider__bg6" data-background="/web-site/assets/img/slider/topbanner4.jpg">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="tpslider__five__wrapper pt-150 text-left">
                                            <!-- <div class="tpslider__five__brand mb-10">
                                               <img src="/web-site/assets/img/logo/MAN White.png" width="250px" alt="logo">
                                            </div> -->
                                            <div class="tpslider__five__contact">
                                                <h3 class="tpslider__five__title">Top Quality</h3>
                                                <p>Our fresh Vietnamese vegetable rolls look taste even better.</p>
                                                <div class="tpslider__five__btn">
                                                    <a class="tp-btn" href="shop-3.html">Shop Now <i class="icon-chevrons-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </swiper-slide>
                    <swiper-slide>
                        <div class="swiper-slide tpslider__bg6" data-background="/web-site/assets/img/slider/topbanner5.jpg">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="tpslider__five__wrapper pt-150 text-left">
                                            <!-- <div class="tpslider__five__brand mb-10">
                                               <img src="/web-site/assets/img/logo/MAN White.png" width="250px" alt="logo">
                                            </div> -->
                                            <div class="tpslider__five__contact">
                                                <h3 class="tpslider__five__title">High Quality</h3>
                                                <p>Our fresh Vietnamese vegetable rolls look taste even better.</p>
                                                <div class="tpslider__five__btn">
                                                    <a class="tp-btn" href="shop-3.html">Shop Now <i class="icon-chevrons-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </swiper-slide>
                </swiper-container>
                    <div class="tpslider__arrow d-none  d-xxl-block">
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
import {register} from 'swiper/element/bundle';
// register Swiper custom elements

import 'swiper/css';
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
.swiper-container {
    height: 100vh;
}
</style>
