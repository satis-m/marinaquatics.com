<template>
    <!-- header-search -->
    <div class="tpsearchbar tp-sidebar-area">
        <button class="tpsearchbar__close"><i class="icon-x"></i></button>
        <div class="search-wrap text-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-6 pt-100 pb-100">
                        <h2 class="tpsearchbar__title">What Are You Looking For?</h2>
                        <div class="tpsearchbar__form">
                            <form method="get" :action="appRoute('product.search')">
                                <input type="text" :value="iPropsValue('filters','search')" name="search" placeholder="Search Product">
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
import { useInertiaPropsUtility } from "@admin/Composables/inertiaPropsUtility";
const { iPropsValue } = useInertiaPropsUtility();
</script>

<style lang="scss" scoped>

</style>
