<template>
    <Header/>
    <div class="common-layout">
          <slot />
    </div>
    <Footer/>
</template>
<script setup>
import Header from './Header.vue'
import Footer from './Footer.vue'

</script>
