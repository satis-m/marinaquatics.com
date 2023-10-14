<template>
    <section v-if="type==='video'" class="banner-video">
        <div class="col-md-12 col-xs-12 col-lg-12 col-xl-12">
            <div class="relative">
                <div class="video_overlays"></div>
                <video class="lazy" preload="none" autoplay muted playsinline loop :poster="image">
                    <source :data-src="video" type="video/webm"/>
                </video>

                <div class="heroContent md:justify-start justify-center items-end md:p-10 pb-6 md:items-center">
                    <div class="tpslider__five__contact">
                        <h3 class="tpslider__five__title">{{ title }}</h3>
                        {{ detail }}
                        <div class="tpslider__five__btn flex justify-center items-center">
                            <NavLink class="tp-btn" v-if="link!='#' && link!=''" :href="link">{{ linkText }} <i class="icon-chevrons-right"></i></NavLink>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section v-else class="banner-image">
        <div class="col-md-12 col-xs-12 col-lg-12 col-xl-12">
            <div class="relative">
                <div class="image_overlays"></div>
                <img :src="image" alt="test" class="img-fluid">

                <div class="heroContent md:justify-end justify-center items-end md:items-start pb-6 md:p-10">
                    <div class="tpslider__five__contact">
                        <h3 class="tpslider__five__title">{{ title }}</h3>
                        {{ detail }}
                        <div class="tpslider__five__btn flex justify-center items-center">
                            <NavLink class="tp-btn" v-if="link!='#' && link!=''" :href="link">{{ linkText }} <i class="icon-chevrons-right"></i></NavLink>
                        </div>
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
    linkText: {
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
.tp-btn {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 4px;
    width: 150px;
}

.tpslider__five__contact {
    color: var(--tp-common-white);
}

//.banner-video,
//video,
//.video_overlays,
//{
//    object-fit: cover;
//    height:calc(100vh - 75px)
//}
</style>
