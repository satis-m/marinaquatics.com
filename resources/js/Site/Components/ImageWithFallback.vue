<template>
  <img :src="imageSource" @error="displayFallbackImage" />
</template>

<script setup>
import {ref, computed, onMounted, onRenderTracked} from "@vue/runtime-core";
const imageSource = ref('');
const props = defineProps({
  source: {
    type: String,
    required: true,
  },
  fallback: {
    type: String,
  },
})
imageSource.value = props.source;

const displayFallbackImage = ()=>{
  if(props.fallback == '' || props.fallback == null)
  {
    imageSource.value = '/admin-site/blank_image_2.svg'
  }
  else {
  imageSource.value = props.fallback;
  }
}
</script>

<style lang="scss" scoped>

</style>