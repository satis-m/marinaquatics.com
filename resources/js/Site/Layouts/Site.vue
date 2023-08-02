<template>
    <Header/>
   <main>
          <slot />
   </main>

    <Footer/>
</template>
<script setup>
import Header from './Header.vue'
import Footer from './Footer.vue'

</script>
