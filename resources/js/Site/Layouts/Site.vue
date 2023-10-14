<template>
    <Header/>
   <main>
          <slot />
   </main>

    <Footer/>
    <FlashMessage/>
</template>
<script setup>
import {ref,watch} from "@vue/runtime-core";
import Header from './Header.vue'
import Footer from './Footer.vue'
import {useInertiaPropsUtility} from "@admin/Composables/inertiaPropsUtility";
import FlashMessage from "./FlashMessage.vue";
const {iPropsValue} = useInertiaPropsUtility();


</script>
