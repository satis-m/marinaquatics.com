<script setup>
import {ref} from "@vue/runtime-core";
import moment from "moment";
import ImageWithFallback from "@/Components/ImageWithFallback.vue";

import {useInertiaPropsUtility} from "@admin/Composables/inertiaPropsUtility";
const {iPropsValue} = useInertiaPropsUtility();

import {useAppUtility} from "@admin/Composables/appUtility";
const {mediaCheck} = useAppUtility();

import {useStringUtility} from "@admin/Composables/stringUtility";
const {removeHTMLTags ,readableWord} = useStringUtility();

import SideCategoryNav from "../Components/SideCategoryNav.vue";
import Pagination from '@/Components/Pagination';

import {watch} from "vue";
import {useForm} from "@inertiajs/vue3";
import BlogSearch from "../Components/BlogSearch.vue";

const blogList = ref(iPropsValue("blogList"));
watch(
    () => iPropsValue('blogList'),
    () => {
        blogList.value = iPropsValue('blogList')
    }
)
const truncateDescription =(text)=> {
    if (text.length > 200) {
        return text.slice(0, 200) + "...";
    } else {
        return text;
    }
}


</script>

<template>
    <div class="breadcrumb__area grey-bg py-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-breadcrumb__content">
                        <div class="tp-breadcrumb__list">
                            <span class="tp-breadcrumb__active"><NavLink
                                :href="appRoute('homepage')">Home</NavLink></span>
                            <span class="dvdr"> / </span>
                            <span><NavLink
                                :href="appRoute('blog.index','all')">Blogs</NavLink></span>
                            <span class="dvdr"> / </span>
                            <span> Search </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <section class="blog-area pt-10">
        <div class="container">
            <div class="row">
                <div class="col-xl-9">
                    <div class="row">
                        <div v-if="blogList.data.length > 0" v-for="(blog, key) in blogList.data" class=" col-3xl-3 col-xl-4 col-md-6 ">
                            <div class="tpblog__item tpblog__item-2 mb-8">
                                <div class="tpblog__thumb fix">
                                    <NavLink :href="appRoute('blog.view',blog.slug)">
                                        <ImageWithFallback class="blog-thumb h-[200px] 2xl:h-[250]" v-if="mediaCheck('xl')" :source="blog.main_picture.thumbnail" :alt="blog.slug" />
                                        <ImageWithFallback  class="blog-thumb h-[200px] 2xl:h-[250]" v-else :source="blog.main_picture.preview" :alt="blog.slug" />
                                    </NavLink>
                                </div>
                                <div class="tpblog__wrapper">
                                    <div class="tpblog__entry-wap">
                                        <span class="cat-links"><NavLink :href="appRoute('blog.index',blog.category)">{{ readableWord(blog.category)}}</NavLink></span>
                                        <span class="author-by">Admin</span>
                                        <span class="post-data">{{ moment(blog.created_at).format("MMM D, YYYY") }}</span>
                                    </div>
                                    <h4 class="tpblog__title"><NavLink :href="appRoute('blog.view',blog.slug)">{{ blog.title }}</NavLink></h4>
                                    <p class=" text-justify">{{ truncateDescription(removeHTMLTags(blog.body)) }}</p>
                                    <div class="tpblog__details">
                                        <NavLink :href="appRoute('blog.view',blog.slug)">Continue reading <i class="icon-chevrons-right"></i> </NavLink>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-else class="text-xl flex flex-col text-center h-[350px] flex justify-center items-center italic">
                            <i class="icon-activity text-6xl text-gray-400"></i>
                            <p class="mt-2">No new blogs just yet, but plenty to discover in our other categories!</p>
                        </div>
                    </div>
                    <div class="tpbasic__pagination py-8">
                        <pagination :links="blogList.links"/>
                    </div>
                </div>
                <div class="col-xl-3 pb-50">
                    <BlogSearch/>
                    <SideCategoryNav/>
                </div>
            </div>
        </div>
    </section>

</template>

<style scoped lang="scss">

</style>
