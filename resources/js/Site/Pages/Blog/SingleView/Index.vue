<template>
    <Head>
        <title>{{blogInfo.title}}</title>
        <meta head-key="description" name="description"
              :content="cutString(removeHTMLTags(blogInfo.body),200)">

        <meta head-key="og:description" property="og:description"
              :content="cutString(removeHTMLTags(blogInfo.body),200)">

        <link head-key="canonical" rel="canonical" :href="iPropsValue('ziggy','url')">
        <meta head-key='og:url' property="og:url" :content="iPropsValue('ziggy','url')">
        <meta inertia='og:title' property="og:title" :content="blogInfo.title">
        <meta head-key='og:image' property="og:image" :content="blogInfo.main_picture.thumbnail">

    </Head>
    <div class="breadcrumb__area grey-bg py-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-breadcrumb__content">
                        <div class="tp-breadcrumb__list">
                            <span class="tp-breadcrumb__active"><NavLink
                                :href="appRoute('homepage')">Home</NavLink></span>
                            <span class="dvdr">/</span>
                            <span><NavLink
                                :href="appRoute('blog.index','all')">Blogs</NavLink></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="blog-details-area pb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-blog-details__thumb">
                        <ImageWithFallback :source="blogInfo.main_picture.original" :alt="blogInfo.slug"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-blog-details__wrapper">
                        <div class="tp-blog-details__content">
                            <div class="tpblog__entry-wap mb-2">
                                <span class="cat-links"><NavLink :href="appRoute('blog.index',blogInfo.category)">{{ readableWord(blogInfo.category)}}</NavLink></span>
                                <span class="author-by">Admin</span>
                                <span class="post-data">{{ moment(blogInfo.created_at).format("MMM D, YYYY") }}</span>
                            </div>
                            <h2 class="tp-blog-details__title mb-25 text-capitalize">{{blogInfo.title}}</h2>

                        </div>
                        <div class="tp-blog-details__content" v-html="blogInfo.body">
                        </div>
                        <div class="postbox__tag-border mb-8">
                            <div class="row align-items-center">
                                <div class="col-xl-7 col-lg-6 col-md-12">
                                    <div class="postbox__tag">
                                        <div class="postbox__tag-list tagcloud">
                                            <span class="tag-title">Tagged: </span>
                                            <span v-for="tag in blogInfo.tag" class="badge bg-[#12b3ca] ml-2 capitalize">{{tag}}</span>
                                        </div>
                                    </div>
                                </div>
<!--                                <div class="col-xl-5 col-lg-6 col-md-12">-->
<!--                                    <div class="postbox__social-tag">-->
<!--                                        <span>share:</span>-->
<!--                                        <a class="blog-d-lnkd" href="#"><i class="fab fa-linkedin-in"></i></a>-->
<!--                                        <a class="blog-d-pin" href="#"><i class="fab fa-pinterest-p"></i></a>-->
<!--                                        <a class="blog-d-fb" href="#"><i class="fab fa-facebook-f"></i></a>-->
<!--                                        <a class="blog-d-tweet" href="#"><i class="fab fa-twitter"></i></a>-->
<!--                                    </div>-->
<!--                                </div>-->
                            </div>
                        </div>
                        <div class="tp-blog-details__post-link mb-15">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="tp-blog-details__post-item paginate-blog mb-30" v-if="previousBlog">
                                        <NavLink :href="appRoute('blog.view',previousBlog.slug)">
                                            <span><i class="far fa-chevron-left"></i> Previous Post</span>
                                            {{ previousBlog.title}}
                                        </NavLink>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="tp-blog-details__post-item paginate-blog flex flex-col items-end text-right mb-30" v-if="nextBlog">
                                        <NavLink class="" :href="appRoute('blog.view',nextBlog.slug)">
                                            <span>Next Post <i class="far fa-chevron-right"></i></span>
                                            {{ nextBlog.title}}
                                        </NavLink>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script setup>
import {ref} from "@vue/runtime-core";
import moment from "moment";
import ImageWithFallback from "@/Components/ImageWithFallback.vue";


import {useInertiaPropsUtility} from "@admin/Composables/inertiaPropsUtility";
const {iPropsValue} = useInertiaPropsUtility();

import {useStringUtility} from "@admin/Composables/stringUtility";
const {removeHTMLTags,readableWord,cutString} = useStringUtility();

const blogInfo = ref(iPropsValue("blogInfo"));
const previousBlog = ref(iPropsValue('previousBlog'));
const nextBlog = ref(iPropsValue('nextBlog'));
</script>
<style lang="scss">
.tp-blog-details__thumb
{
    img{
        width: 100%;
        max-height: 550px;
        object-fit: cover;
    }
}
.tag-title
{
    color: var(--tp-heading-primary);
}
.paginate-blog
{
    a{
        max-width: 300px;
    }
}
</style>
