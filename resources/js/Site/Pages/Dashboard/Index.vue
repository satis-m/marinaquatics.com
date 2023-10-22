<template>

    <div class="grey-bg">
        <div class="breadcrumb__area p-3">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tp-breadcrumb__content">
                            <div class="tp-breadcrumb__list">
                                <span class="tp-breadcrumb__active"><NavLink :href="appRoute('homepage')">Home</NavLink></span>
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
                        <div class="profile-sidebar h-[350px]">
                            <div class="tpshop__widget ">
                                <p class="tpshop__widget-title px-3 ">{{ iPropsValue('auth','user.name') }}</p>
                               <ul class="user-menu">
                                   <li  :class="viewContent == 'client.dashboard.personal-detail' ? 'active':''">
                                      <NavLink :href="appRoute('client.dashboard')"> <i class="icon-user"></i> Personal Detail</NavLink>
                                   </li>
                                   <li  :class="viewContent == 'client.dashboard.order-history' ? 'active':''">
                                     <NavLink :href="appRoute('client.dashboard.order-history')"> <i class="icon-list"></i> Order History</NavLink>
                                   </li>
                                   <li  :class="viewContent == 'client.dashboard.shipping-address' ? 'active':''">
                                     <NavLink :href="appRoute('client.dashboard.shipping-address')" ><i class="icon-shipping"></i> Shipping Address</NavLink>
                                   </li>
                                   <li  :class="viewContent == 'client.dashboard.change-password' ? 'active':''">
                                     <NavLink :href="appRoute('client.dashboard.change-password')" ><i class="icon-shield"></i> Change Password</NavLink>
                                   </li>
                               </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xg-9 col-md-9 ">
                        <PersonalDetail v-if="viewContent == 'client.dashboard.personal-detail'"/>
                        <OrderHistory v-if="viewContent == 'client.dashboard.order-history'"/>
                        <ShippingAddress v-if="viewContent == 'client.dashboard.shipping-address'"/>
                        <ChangePassword v-if="viewContent == 'client.dashboard.change-password'"/>
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
import { useStringUtility } from "@admin/Composables/stringUtility";
const { wordInitials } = useStringUtility();

const viewContent = route().current() == 'client.dashboard' ? 'client.dashboard.personal-detail' : route().current();
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
          a{
            padding:10px 10px;
            display: block;
          }

            &:hover,&.active
            {
                background-color: var(--tp-theme-1);
                cursor:pointer;
                color: var(--tp-common-white);
            }
        }

    }
}

 .lds-ring {
   display: inline-block;
   position: absolute;
   width: 24px;
   height: 24px;
   top: 50%;
   right: 18px;
   transform: translate(0%, -60%);
 }

.lds-ring div {
  box-sizing: border-box;
  display: block;
  position: absolute;
  width: 24px;
  height: 24px;
  margin: 3px;
  border: 3px solid #fff;
  border-radius: 50%;
  animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
  border-color: #fff transparent transparent transparent;
}

.lds-ring div:nth-child(1) {
  animation-delay: -0.45s;
}

.lds-ring div:nth-child(2) {
  animation-delay: -0.3s;
}

.lds-ring div:nth-child(3) {
  animation-delay: -0.15s;
}

@keyframes lds-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>