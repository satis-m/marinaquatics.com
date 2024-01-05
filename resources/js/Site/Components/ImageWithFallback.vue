<template>
    <img
        v-show="imageLoaded"
        :src="fullImageUrl"
        @load="onImageLoad"
        @error="displayFallbackImage"
        :class="class"
    />
    <img :src="blurredImageUrl" v-if="!imageLoaded" class="blurred-image"  :class="class" @error="displayFallbackImage" />
</template>

<script setup>
import {ref, computed, onMounted, onRenderTracked} from "@vue/runtime-core";
const fullImageUrl = ref('');
const imageLoaded = ref(false);
const blurredImageUrl = ref('');
const props = defineProps({
  source: {
    type: String,
    required: true,
  },
  fallback: {
    type: String,
  },
    class: {
        type: String,
    },
})
fullImageUrl.value = props.source;
blurredImageUrl.value = fullImageUrl.value.replace(/-thumb.webp|-medium.webp|-original.webp/g,'-blur.webp') ;
const displayFallbackImage = ()=>{
  if(props.fallback == '' || props.fallback == null)
  {
    fullImageUrl.value = '/admin-site/blank_image_2.svg'
  }
  else {
    fullImageUrl.value = props.fallback;
  }
}

const onImageLoad = ()=>{
    imageLoaded.value = true;
}
</script>

<style scoped>
.blurred-image {
    filter: blur(6px); /* Adjust the blur level as needed */
}
</style>

