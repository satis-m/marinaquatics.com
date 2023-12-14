<script setup>
import {ref, watch, onMounted} from "@vue/runtime-core";
import {register} from 'swiper/element/bundle';
// register Swiper custom elements
import {useAppUtility} from "@admin/Composables/appUtility";

const {siteUrl} = useAppUtility();
import 'swiper/css';
import ProductCard from "@/Components/ProductCard.vue";

const props = defineProps({
  parentSliders: {type: Object, required: true},
  slidersId: {type: String, default: 'grid-slider'},
  delayTime: {type: Number, default: 0},
});

const swiperKey = ref(1);
onMounted(() => {
  register();
  const swiperEl = document.querySelector('#' + props.slidersId);
  const swiperParams = {
    // Optional parameters
    centerInsufficientSlides: true,
    effect: 'slide',
    rewind: true,
    loop: true,
    observer: true,
    slidesPerView: 6,
    spaceBetween: 20,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
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
      nextEl: '#' + props.slidersId + '-nxt',
      prevEl: '#' + props.slidersId + '-prv',
    },
  };

  Object.assign(swiperEl, swiperParams);
  // and now initialize it
  setTimeout(()=>{
    swiperEl.initialize();
  }, props.delayTime * 1000)
})

</script>

<template>
  <div class="swiper-container tpproduct-active tpslider-bottom p-relative">
    <swiper-container :id="slidersId" init="false">
      <swiper-slide v-memo="[product]" :key="key" v-for="(product, key) in parentSliders ">
        <ProductCard :product-info="product"/>
      </swiper-slide>
    </swiper-container>
    >
  </div>
  <div class="tpproduct-btn">
    <div class="tpprduct-arrow tpproduct-btn__prv" :id="slidersId+'-prv'">
      <button type="button"><i class="icon-chevron-left"></i></button>
    </div>
    <div class="tpprduct-arrow tpproduct-btn__nxt" :id="slidersId+'-nxt'">
      <button type="button"><i class="icon-chevron-right"></i></button>
    </div>
  </div>
</template>
