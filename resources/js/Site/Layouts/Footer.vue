<template>
    <footer>
        <section class="feature-area theme-bg-1 pt-50 pb-10 -mb-1 -mt-6" >
            <div class="container">
                <div class="mainfeature__border pb-15">
                    <div class="row row-cols-lg-5 row-cols-md-3 row-cols-2">
                        <div class="col">
                            <div class="mainfeature__item text-center mb-30">
                                <div class="mainfeature__icon">
                                    <img src="/web-site/assets/img/icon/feature-icon-1.svg" alt="">
                                </div>
                                <div class="mainfeature__content">
                                    <h4 class="mainfeature__title">Fast Delivery</h4>
                                    <p>Inside Ringroad</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mainfeature__item text-center mb-30">
                                <div class="mainfeature__icon">
                                    <img src="/web-site/assets/img/icon/feature-icon-2.svg" alt="">
                                </div>
                                <div class="mainfeature__content">
                                    <h4 class="mainfeature__title">Safe payment</h4>
                                    <p>100% Secure Payment</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mainfeature__item text-center mb-30">
                                <div class="mainfeature__icon">
                                    <img src="/web-site/assets/img/icon/feature-icon-3.svg" alt="">
                                </div>
                                <div class="mainfeature__content">
                                    <h4 class="mainfeature__title">Online Discount</h4>
                                    <p>Add Multi-buy Discount </p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mainfeature__item text-center mb-30">
                                <div class="mainfeature__icon">
                                    <img src="/web-site/assets/img/icon/feature-icon-4.svg" alt="">
                                </div>
                                <div class="mainfeature__content">
                                    <h4 class="mainfeature__title">Help Center</h4>
                                    <p>Dedicated 24/7 Support </p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mainfeature__item text-center mb-30">
                                <div class="mainfeature__icon">
                                    <img src="/web-site/assets/img/icon/feature-icon-5.svg" alt="">
                                </div>
                                <div class="mainfeature__content">
                                    <h4 class="mainfeature__title">Curated items</h4>
                                    <p>From Handpicked Sellers</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="tpfooter__area pt-5 theme-bg-1">
            <div class="tpfooter__top pb-15">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="tpfooter__widget mb-50 text-center text-md-start">
                                <h4 class="tpfooter__widget-title">Let Us Help You</h4>
                                <p >If you have any question, please <br> contact us at: <br/>
                                  <i class="icon-phone"></i> {{iPropsValue('app_info','contact')}}
                                  <br>
                                  <a :href="'mailto:'+iPropsValue('app_info','email')" class="text-white"> <i class="icon-mail"></i> {{ iPropsValue('app_info','email') }}</a>
                                </p>
                                <div class="tpfooter__widget-social mt-45">
                                    <span class="tpfooter__widget-social-title mb-1">Social Media:</span>
                                    <div class="d-flex social-icon justify-center justify-content-md-start">
                                    <a target="_blank" :href="iPropsValue('app_info','fb_link')"><i class="icon-facebook"></i></a>
                                    <a target="_blank" :href="iPropsValue('app_info','youtube_link')"><i class="icon-youtube"></i></a>
                                    <a target="_blank" :href="iPropsValue('app_info','insta_link')"><i class="icon-instagram"></i></a>
                                    <a target="_blank" :href="iPropsValue('app_info','whatsapp_link')"><i class="icon-whatsapp d-flex">
                                        <img class="icon" src="/web-site/assets/img/icon/whatsapp.svg" width="20px" height="20px"></i>
                                    </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="tpfooter__widget mb-50 text-center">
                                <h4 class="tpfooter__widget-title">Looking for Marine Aquatics Nepal?</h4>
                                <p v-html="formattedAddress"></p>
                                <div class="tpfooter__widget-time-info mt-35">
                                  <span v-html="iPropsValue('app_info','store_time')"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="tpfooter__widget mb-50 text-center text-md-end">
                                <h4 class="tpfooter__widget-title">
                                    Our Site
                                </h4>
                                <div class="tpfooter__widget-links">
                                    <ul>
<!--                                        <li><a href="#">About Us</a></li>-->
<!--                                        <li><a href="#">Blogs</a></li>-->
<!--                                        <li><a href="#">Gallery</a></li>-->
                                        <li><a href="#" @click.prevent="showModal=true">Visit Us</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tpfooter___bottom pt-25 pb-25">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tpfooter__copyright text-center">
                                <span class="tpfooter__copyright-text">Copyright © {{ iPropsValue('app_info','title') }} all rights reserved. Powered by IT Expert Group.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
  <Teleport to="body">
    <Modal @close-modal="showModal=false" v-show="showModal">
      <template v-slot:header>
       Google Map
      </template>
      <template v-slot:body>
        <div class="">
          <div v-html="iPropsValue('app_info','google_map')"></div>
        </div>
      </template>
      <template v-slot:footer>
        <div class="flex gap-2 mt-3">
          <button class="action-btn btn-sm btn-grey" @click="showModal=false">close</button>
        </div>
      </template>
    </Modal>
  </Teleport>
</template>
<script setup>
import Modal from "@/Components/Modal.vue"
import {useInertiaPropsUtility} from "@admin/Composables/inertiaPropsUtility";
import {ref,computed} from "@vue/runtime-core";
const {iPropsValue} = useInertiaPropsUtility();

const formattedAddress = computed(()=>{
  return iPropsValue('app_info','address').replace(", ", ",<br>");
})
const showModal = ref(false);
</script>
<style scoped>
.mainfeature__icon
{
    display: flex;
    justify-content: center;
}

</style>
<style lang="scss">
.social-icon
{
    a{
        display: flex;
        align-items: center;
        justify-content: center;
        height: 40px;
        width: 40px;
        &:hover{
            background-color: #f0f0f0;
            color: #0a0a0a;
            border-radius: 50%;
            img{
                -webkit-filter: invert(1);filter: invert(1);
            }
        }
    }
}
</style>
