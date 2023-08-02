<template>

        <!-- slider-area-start -->
        <Slider/>
        <!-- slider-area-end -->
        <!-- banner-area-start -->
        <section class="banner-area">
            <Banner type="video" title="banner 1" detail="Our fresh Vietnamese vegetable rolls look taste even better." video="/web-site/assets/2banner.webm" image="/web-site/assets/img/banner/banner-2-poster.webp" link="#" />
            <Banner type="video" title="banner 2" detail="Our fresh Vietnamese vegetable rolls look taste even better." video="/web-site/assets/3banner.webm" image="/web-site/assets/img/banner/banner-3-poster.webp" link="#" />
            <Banner type="gif" title="gif" detail="Our fresh Vietnamese vegetable rolls look taste even better." image="/web-site/assets/img/banner/4banner.gif" link="#" />
            <Banner type="image" title="image" detail="Our fresh Vietnamese vegetable rolls look taste even better." image="/web-site/assets/img/banner/5banner.jpg" link="#" />
        </section>
        <!-- banner-area-end -->
        <!-- product-area-start -->
        <section class="product-area bg-black lg:p-40 p-10 ">
            <div class="container">
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
                        <div class="swiper-wrapper">
                            <div class="swiper-slide" :key="key" v-for="(product, key) in productList ">
                                <ProductCard :product-info="product"/>
                            </div>
                        </div>
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
import Banner from "./Components/Banner.vue"
import ProductCard from "../../Components/ProductCard.vue"
import {useInertiaPropsUtility} from "@admin/Composables/inertiaPropsUtility";
import {ref, watch} from "@vue/runtime-core";
const {iPropsValue} = useInertiaPropsUtility();
const productList = ref(iPropsValue("products"));
watch(
    () => iPropsValue("products"),
    () => {
        productList.value = iPropsValue("products");
    }
);
</script>
