<template>
    <Header/>
   <main>
          <slot />
   </main>

    <Footer/>
</template>
<script setup>
import {ref,watch} from "@vue/runtime-core";
import Header from './Header.vue'
import Footer from './Footer.vue'
import {useInertiaPropsUtility} from "@admin/Composables/inertiaPropsUtility";
const {iPropsValue} = useInertiaPropsUtility();


</script>
