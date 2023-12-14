<template>
  <Head>
    <title>Homepage</title>
    <template :key="key" v-for="(slider , key) in sliders">
      <link rel="preload" v-if="key < 2" :href="siteUrl(slider.image)" as="image" fetchpriority="high">
    </template>
    <link head-key="canonical" rel="canonical" :href="iPropsValue('ziggy','url')">
    <meta head-key='og:url' property="og:url" :content="iPropsValue('ziggy','url')">
    <meta head-key='og:title' property="og:title" content="">
    <meta head-key='og:description' property="og:description"
          content="We focus on Live Aquarium Plants, selling both in our retail store and online. Live Aquatic Plants are essential to a healthy aquarium.">
    <meta head-key='og:image' property="og:image" :content="iPropsValue('app_info','brandLogo')">
    <meta head-key="description" name="description"
          content="We focus on Live Aquarium Plants, selling both in our retail store and online. Live Aquatic Plants are essential to a healthy aquarium."/>
  </Head>
  <!-- slider-area-start -->
  <Slider v-once :parentSliders="sliders"/>
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
        :link="banner.link"/>
    <Banner
        v-else
        :type="banner.type"
        :title="banner.title"
        :detail="banner.detail"
        :image="siteUrl(banner.file_path)"
        :linkText="banner.link_text"
        :link="banner.link"/>

  </template>
  <!-- banner-area-end -->
  <section class="product-area bg-black p-10 pb-0">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 text-center">
          <div class="tpsection mb-35"><h4 class="tpsection__sub-title">~ Special Products ~</h4>
            <h4 class="tpsection__title">Product Of MAN</h4>
          </div>
        </div>
      </div>
      <div class="tpproduct__arrow p-relative">
        <GridSlider v-once :slidersId="'manProductSlider'" :parentSliders="manProductList"/>
      </div>
    </div>
  </section>
  <!-- product-area-start -->
  <section class="product-area bg-black p-10 ">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 text-center">
          <div class="tpsection mb-35" v-html="iPropsValue('app_info','end_banner')">
          </div>
        </div>
      </div>
      <div class="tpproduct__arrow p-relative">
        <GridSlider v-once :slidersId="'discountSlider'" :delayTime="1.5" :parentSliders="discountProductList"/>
      </div>
    </div>
  </section>

</template>
<script setup>
import Slider from "./Components/Slider.vue"
import GridSlider from "./Components/GridSlider.vue"
import {register} from 'swiper/element/bundle';
import {Head} from "@inertiajs/vue3";
import {Navigation, Pagination} from 'swiper/modules';

import 'swiper/css';
import Banner from "./Components/Banner.vue"
import ProductCard from "../../Components/ProductCard.vue"
import {useInertiaPropsUtility} from "@admin/Composables/inertiaPropsUtility";
import {ref, watch, onMounted} from "@vue/runtime-core";

import {useAppUtility} from "@admin/Composables/appUtility";

const {siteUrl} = useAppUtility();
const {iPropsValue} = useInertiaPropsUtility();

const discountProductList = ref(iPropsValue("discountProducts"));
watch(
    () => iPropsValue("discountProducts"),
    () => {
      discountProductList.value = iPropsValue("discountProducts");
    }
);
const manProductList = ref(iPropsValue("manProducts"));
watch(
    () => iPropsValue("manProducts"),
    () => {
      manProductList.value = iPropsValue("manProducts");
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

</script>

