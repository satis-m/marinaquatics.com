<template>
<Head>
    <title>Homepage</title>
    <template :key="key"  v-for="(slider , key) in sliders" >
        <link rel="preload" v-if="key < 2" :href="slider.image" as="image" fetchpriority="high">
    </template>
</Head>
        <!-- slider-area-start -->
        <Slider v-once :parentSliders="sliders" />
        <!-- slider-area-end -->
        <!-- banner-area-start -->

    <template v-once v-for="(banner, key) in banners" :key="key">
        <Banner
            v-if="banner.type =='video'"
                :type="banner.type"
                :title="banner.title"
                :detail="banner.detail"
                :video="siteUrl(banner.file_path)"
                :image="siteUrl(banner.alt_image)"
                :linkText="banner.link_text"
                :link="banner.link" />
        <Banner
            v-else
            :type="banner.type"
            :title="banner.title"
            :detail="banner.detail"
            :image="siteUrl(banner.file_path)"
            :linkText="banner.link_text"
            :link="banner.link" />

    </template>
        <!-- banner-area-end -->
        <!-- product-area-start -->
        <section class="product-area bg-black p-10 ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="tpsection mb-35">
                            <h4 class="tpsection__sub-title">~ Special Products ~</h4>
                            <h4 class="tpsection__title">Weekly Offers</h4>
                            <p>The liber tempor cum soluta nobis eleifend option congue doming quod mazim.</p>
                        </div>
                    </div>
                </div>
                <div class="tpproduct__arrow p-relative">
                    <div class="swiper-container tpproduct-active tpslider-bottom p-relative">
                        <swiper-container id="product-swiper" init="false">
                            <swiper-slide v-memo="[product]" :key="key" v-for="(product, key) in productList ">
                                <ProductCard :product-info="product"/>
                            </swiper-slide>
                        </swiper-container>>
                    </div>
                    <div class="tpproduct-btn">
                        <div class="tpprduct-arrow tpproduct-btn__prv"><a href="#"><i class="icon-chevron-left"></i></a></div>
                        <div class="tpprduct-arrow tpproduct-btn__nxt"><a href="#"><i class="icon-chevron-right"></i></a></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- product-area-end -->
        <!-- feature-area-start -->
        <!-- feature-area-end -->

</template>
<script setup>
import Slider from "./Components/Slider.vue"
import {register} from 'swiper/element/bundle';
import {Head} from "@inertiajs/vue3";
import { Navigation, Pagination } from 'swiper/modules';

import 'swiper/css';
import Banner from "./Components/Banner.vue"
import ProductCard from "../../Components/ProductCard.vue"
import {useInertiaPropsUtility} from "@admin/Composables/inertiaPropsUtility";
import {ref, watch,onMounted} from "@vue/runtime-core";

import {useAppUtility} from "@admin/Composables/appUtility";
const {siteUrl} = useAppUtility();

const {iPropsValue} = useInertiaPropsUtility();
const productList = ref(iPropsValue("products"));
watch(
    () => iPropsValue("products"),
    () => {
        productList.value = iPropsValue("products");
    }
);
const sliders = ref(iPropsValue("sliders"));
watch(
    () => iPropsValue("sliders"),
    () => {
        sliders.value = iPropsValue("sliders");
    }
);
const banners = ref(iPropsValue("banners"));
watch(
    () => iPropsValue("banners"),
    () => {
        banners.value = iPropsValue("banners");
    }
);
onMounted(()=>{
    register();
    const swiperEl = document.querySelector('#product-swiper');
    const swiperParams = {
        // Optional parameters
        centerInsufficientSlides:true,
        effect:'slide',
        rewind:true,
        loop: true,
        observer: true,
        slidesPerView: 6,
        spaceBetween: 20,
        autoplay: {
            delay: 5000,
            disableOnInteraction: true,
        },
        breakpoints: {
            '1200': {
                slidesPerView: 6,
            },
            '992': {
                slidesPerView: 4,
            },
            '768': {
                slidesPerView: 3,
            },
            '576': {
                slidesPerView: 2,
            },
            '0': {
                slidesPerView: 1,
            },
        },
        // Navigation arrows
        navigation: {
            nextEl: '.tpproduct-btn__nxt',
            prevEl: '.tpproduct-btn__prv',
        },
    };

    Object.assign(swiperEl, swiperParams);

    // and now initialize it
    swiperEl.initialize();
})
</script>

