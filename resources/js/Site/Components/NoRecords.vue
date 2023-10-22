<template>
    <div class="flex justify-center items-center flex-col">
        <img :src="siteUrl('/web-site/assets/img/icon/empty-list.svg')" class="w-[350px]" alt="">
      <span>Products list is empty.</span>
    </div>
</template>

<script setup>
import {useAppUtility} from "@admin/Composables/appUtility";
const {siteUrl} = useAppUtility();
</script>

<style lang="scss" scoped>

</style>
