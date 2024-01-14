<script setup>
import {ref} from "@vue/runtime-core";
import {useForm} from "@inertiajs/vue3";

import {useInertiaPropsUtility} from "@admin/Composables/inertiaPropsUtility";
const {iPropsValue} = useInertiaPropsUtility();

const search = ref('');

const form = useForm({
    'search' : iPropsValue('filters','search') ?? null
})
</script>

<template>
    <div class="sidebar__widget mb-30">
        <div class="sidebar__widget-content">
            <div class="sidebar__search">
                <form :action="appRoute('blog.search')" @submit.prevent="form.get(appRoute('blog.search'))" method="get">
                    <div class="sidebar__search p-relative">
                        <input type="text" v-model="form.search" name="search" placeholder="Search">
                        <button type="submit"><i class="icon-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">

</style>
