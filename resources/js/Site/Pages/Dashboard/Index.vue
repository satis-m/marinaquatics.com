<template>
    <div class="grey-bg">
        <div class="breadcrumb__area pt-5 pb-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tp-breadcrumb__content">
                            <div class="tp-breadcrumb__list">
                                <span class="tp-breadcrumb__active"><a href="index.html">Home</a></span>
                                <span class="dvdr">/</span>
                                <span> My Profile</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- contact-area-start -->
        <section class="contact-area pb-45">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xg-3 col-md-3 mb-4 mb-md-0">
                        <div class="profile-sidebar h-100">
                            <div class="tpshop__widget ">
                                <p class="tpshop__widget-title px-3 ">{{ iPropsValue('auth','user.name') }}</p>
                               <ul class="user-menu">
                                   <li @click="viewContent = 'personal-detail'" :class="viewContent == 'personal-detail' ? 'active':''"> <i class="icon-user"></i> Personal Detail</li>
                                   <li @click="viewContent = 'order-history'" :class="viewContent == 'order-history' ? 'active':''"> <i class="icon-list"></i> Order History</li>
                                   <li @click="viewContent = 'shipping-address'" :class="viewContent == 'shipping-address' ? 'active':''"> <i class="icon-shipping"></i> Shipping Address</li>
                                   <li @click="viewContent = 'change-password'" :class="viewContent == 'change-password' ? 'active':''"> <i class="icon-shield"></i> Change Password</li>
                               </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xg-9 col-md-9 d-flex flex-row flex-wrap ">
                        <PersonalDetail v-if="viewContent == 'personal-detail'"/>
                        <OrderHistory v-if="viewContent == 'order-history'"/>
                        <ShippingAddress v-if="viewContent == 'shipping-address'"/>
                        <ChangePassword v-if="viewContent == 'change-password'"/>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import PersonalDetail from "./Components/PersonalDetail.vue";
import OrderHistory from "./Components/OrderHistory.vue";
import ShippingAddress from "./Components/ShippingAddress.vue";
import ChangePassword from "./Components/ChangePassword.vue";
import {ref} from "vue"

import { useInertiaPropsUtility } from "@admin/Composables/inertiaPropsUtility";
const { iPropsValue } = useInertiaPropsUtility();
import { useStringUtility } from "@admin/Composables/StringUtility";
const { wordInitials } = useStringUtility();

const viewContent = ref("personal-detail");
</script>

<style lang="scss">
.profile-sidebar
{
    border-radius: 10px;
    background-color: var(--tp-common-white);
    padding: 20px 0;
    .tpshop__widget-title
    {
        font-size: 22px;
        text-transform: capitalize;
        color: var(--tp-theme-1);
        border-bottom: 1px solid lightgray;
        padding-bottom: 10px;
    }

    .user-menu{
        li
        {
            padding:10px 10px;

            &:hover,&.active
            {
                background-color: var(--tp-theme-1);
                cursor:pointer;
                color: var(--tp-common-white);
            }
        }

    }
}

</style>
