<template>
    <section v-if="type==='video'" class="banner-video">
        <div class="col-md-12 col-xs-12 col-lg-12 col-xl-12">
            <div class="relative">
                <div class="video_overlays"></div>
                <video class="lazy" preload="none" autoplay muted playsinline  loop :poster="image">
                    <source :data-src="video" type="video/webm"/>
                </video>
            </div>
            <div class="heroContent">
                <div class="tpslider__five__contact">
                    <h3 class="tpslider__five__title">{{ title }}</h3>
                    <p>{{ detail }}</p>
                    <div class="tpslider__five__btn">
                        <a class="tp-btn" :href="link">Shop Now <i class="icon-chevrons-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section v-else-if="type==='gif'" class="banner-gif">
        <div class="col-md-12 col-xs-12 col-lg-12 col-xl-12">
            <img :src="image" alt="test" class="img-fluid" >
            <div class="heroContentRight">
                <div class="tpslider__five__contact">
                    <div class="tpslider__five__btn">
                        <a class="tp-btn" :href="link">{{ title }} <i class="icon-chevrons-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section v-else-if="type==='image'" class="banner-image">
        <div class="col-md-12 col-xs-12 col-lg-12 col-xl-12">
            <img :src="image" alt="test" class="img-fluid" >
            <div class="heroContentRight">
                <div class="tpslider__five__contact">
                    <div class="tpslider__five__btn">
                        <a class="tp-btn" :href="link">{{ title }} <i class="icon-chevrons-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
const props = defineProps({
    type: {
        type: String,
        required: true,
    },
    link: {
        type: String,
        required: true,
    },
    video: {
        type: String,
        required: false,
    },
    title: {
        type: String,
        required: true,
    },
    detail: {
        type: String,
        required: true,
    },
    image: {
        type: String,
        required: true,
    },
});
</script>

<style lang="scss" scoped>

</style>
