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
                                <p class="tpshop__widget-title mb-2">{{ iPropsValue('auth','user.name') }}</p>
                               <ul class="user-menu">
                                   <li>Personal Detail</li>
                                   <li>Order History</li>
                                   <li>Shipping Address</li>
                                   <li>Change Password</li>
                               </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xg-9 col-md-9 d-flex flex-row flex-wrap ">
                        <div class="col-md-6 col-12 px-2">
                            <div class="tptrack__email white-bg mb-10">
                                <span><i class="icon-user"></i></span>
                                <input type="text" placeholder="Full Name">
                                <div class="error-msg"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 px-2">
                            <div class="tptrack__email white-bg mb-10">
                                <span><i class="icon-user"></i></span>
                                <input type="text" placeholder="Full Name">
                                <div class="error-msg"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 px-2">
                            <div class="tptrack__email white-bg mb-10">
                                <span><i class="icon-user"></i></span>
                                <input type="text" placeholder="Full Name">
                                <div class="error-msg"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 px-2">
                            <div class="tptrack__email white-bg mb-10">
                                <span><i class="icon-user"></i></span>
                                <input type="text" placeholder="Full Name">
                                <div class="error-msg"></div>
                            </div>
                        </div>
                        <div class="col-12 px-2">
                            <div class="d-flex justify-content-end gap-3">
                                <div class="tptrack__btn">
                                    <button class="action-btn btn-white " type="button" @click="loginUser" >Reset
                                    </button>
                                </div>
                                    <div class="tptrack__btn">
                                        <button class="action-btn btn-red" type="button" @click="loginUser" >Update
                                        </button>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { useInertiaPropsUtility } from "@admin/Composables/inertiaPropsUtility";
const { iPropsValue } = useInertiaPropsUtility();
</script>

<style lang="scss">
.profile-sidebar
{
    border-radius: 10px;
    background-color: var(--tp-common-white);
    padding: 20px;
    .tpshop__widget-title
    {
        font-size: 22px;
        text-transform: capitalize;
        color: var(--tp-theme-1);
        border-bottom: 1px solid lightgray;
        padding-bottom: 10px;
    }

    .user-menu{

    }
}
.action-btn
{
    background: var(--tp-heading-primary);
    border-radius: 6px;
    color: var(--tp-common-white);
    display: inline-block;
    font-size: 16px;
    font-weight: 600;
    line-height: 1;
    margin-bottom: 0;
    padding: 22px 50px;
    text-align: center;
    touch-action: manipulation;
    transition: all 0.3s ease 0s;
    vertical-align: middle;
    white-space: nowrap;
    width: 100%;
    &.btn-sm
    {
        padding: 12px 25px;
    }
    &.btn-grey
    {
        background-color: #e5e4e4;
        color: #0a0a0a;
        &:hover
        {
            background-color: #5a4f50;
            color: var(--tp-common-white);
        }
    }
    &.btn-red
    {
        background-color: var(--tp-heading-secondary);
        &:hover
        {
           background-color: #859A00;;
        }
    }
    &.btn-blue
    {
        background-color: var(--tp-theme-3);
        &:hover
        {
           background-color: #EE4C06;
        }
    }
    &.btn-gray
    {
        background-color: var(--tp-theme-3);
        &:hover
        {
            background-color: #EE4C06;
        }
    }
    &.btn-white
    {
        background-color: var(--tp-common-white);
        color: var(--tp-text-2);
        &:hover
        {
            background-color: #5a4f50;
            color: var(--tp-common-white);
        }
    }

}
</style>
