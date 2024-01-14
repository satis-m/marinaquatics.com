<template>
    <!-- header-search -->
    <div class="tpsearchbar tp-sidebar-area">
        <button class="tpsearchbar__close" id="tpsearchbar__close-pop"><i class="icon-x"></i></button>
        <div class="search-wrap text-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-6 pt-100 pb-100">
                        <h2 class="tpsearchbar__title">What Are You Looking For?</h2>
                        <div class="tpsearchbar__form">
                            <form method="get"  @submit.prevent="submitSearch" :action="appRoute('product.search')">
                                <input type="text" v-model="form.search" name="search" placeholder="Search Product">
                                <button class="tpsearchbar__search-btn"><i class="icon-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="search-body-overlay"></div>
    <!-- header-search-end -->
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

import { useInertiaPropsUtility } from "@admin/Composables/inertiaPropsUtility";
const { iPropsValue } = useInertiaPropsUtility();

const form = useForm({
    search: iPropsValue('filters','search') ?? null,
})
const submitSearch = ()=>{
    form.get(route('product.search'),{
        preserveScroll: true,
            onSuccess: () => {
            document.getElementById('tpsearchbar__close-pop').click();
        },
    });
}
</script>

<style lang="scss" scoped>

</style>
