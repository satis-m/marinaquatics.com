<script setup>
import {ref} from "@vue/runtime-core";

import {useInertiaPropsUtility} from "@admin/Composables/inertiaPropsUtility";
const {iPropsValue} = useInertiaPropsUtility();

const countBlog = ref(0);
const blogCategories = iPropsValue('blogCategories');
const getCategotyBlogCount = (key)=> {
    return iPropsValue('blogCountsByCategory',key) ?? 0;
}
</script>

<template>
    <div class="sidebar__widget mb-40">
        <h3 class="sidebar__widget-title mb-15">Blog Categories</h3>
        <div class="sidebar__widget-content">
            <ul>
                <li><NavLink :href="appRoute('blog.index','all')">All <span>({{iPropsValue('blogAllCount')}})</span></NavLink></li>
                <li v-for="(category,key) in blogCategories">
                    <NavLink :href="appRoute('blog.index', key)">{{category}} <span>({{ getCategotyBlogCount(key) }})</span></NavLink>
                </li>
            </ul>
        </div>
    </div>
</template>

<style scoped lang="scss">

</style>
