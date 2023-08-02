<template>
    <!-- Scroll-top -->
    <button class="scroll-top scroll-to-target" data-target="html">
        <i class="icon-chevrons-up"></i>
    </button>
    <!-- Scroll-top-end-->
    <!-- header-area-start -->
    <header>
        <div id="header-sticky" class="header__main-area d-none d-lg-block">
            <div class="container-fluid">
                <div class="p-relative">
                    <div class="row align-items-center">
                        <div class="col-xl-12">
                            <div class="header__menu main-menu text-center">
                                <nav id="mobile-menu">
                                    <ul style="height: 50px; display: inline-flex;">
                                        <li>
                                            <div class="header__top-left social d-flex header__info">
                                                <a href="#" class="mr-2"><i class="fab fa-facebook"></i></a>
                                                <a href="#" class="mr-2"><i class="fab fa-youtube"></i></a>
                                                <a href="#" class="mr-2"><i class="fab fa-instagram"></i></a>
                                                <a href="#" class=""><i class="fab fa-whatsapp"></i></a>
                                            </div>
                                        </li>
                                        <li class="has-dropdown" >
                                            <a href="javascript:void(0)" class="mobile-expand">Japanese Koi</a>
                                            <ul class="sub-menu">
                                                <li :key="key" v-for="(category ,key) in categories['Japanese Koi']">
                                                    <NavLink :class="isActiveLink(category.slug) ? 'active' : '' " :href="appRoute('product.category.view',category.slug)">{{ category.sub_category}}</NavLink>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="has-dropdown">
                                            <a href="javascript:void(0)" class="mobile-expand">Exotic Livestock</a>
                                            <ul class="sub-menu">
                                                <li :key="key" v-for="(category ,key) in categories['Exotic Livestock']">
                                                    <NavLink :class="isActiveLink(category.slug) ? 'active' : '' " :href="appRoute('product.category.view',category.slug)">{{ category.sub_category}}</NavLink>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="has-logo hidden xl:block">
                                            <div class="logo">
                                                <a href="index.html"><img src="/web-site/assets/img/logo/logo.svg" alt="logo" >
                                                </a>
                                            </div>
                                        </li>
                                        <li class="has-dropdown">
                                            <a href="javascript:void(0)" class="mobile-expand">Aquariums</a>
                                            <ul class="sub-menu">
                                                <li :key="key" v-for="(category ,key) in categories['Aquariums']">
                                                    <NavLink :class="isActiveLink(category.slug) ? 'active' : '' " :href="appRoute('product.category.view',category.slug)">{{ category.sub_category}}</NavLink>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="has-dropdown">
                                            <a href="javascript:void(0)" class="mobile-expand">Aquarium Supplies</a>
                                            <ul class="sub-menu">
                                                <li :key="key" v-for="(category ,key) in categories['Aquarium Supplies']">
                                                    <NavLink :class="isActiveLink(category.slug) ? 'active' : '' " :href="appRoute('product.category.view',category.slug)">{{ category.sub_category}}</NavLink>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <div class="header__top d-none d-xl-block">
                                                <div class="container">
                                                    <div class="row align-items-center">
                                                        <div class="col-lg-6 col-md-12">
                                                            <div class="header__top-right d-flex align-items-center">
                                                                <div class="header__info d-flex align-items-center">
                                                                    <div class="header__info-search ml-5">
                                                                        <button class="tp-search-toggle"><i class="icon-search"></i></button>
                                                                    </div>
                                                                    <div class="header__info-user ml-5">
                                                                        <a href="log-in.html"><i class="icon-user"></i></a>
                                                                    </div>
                                                                    <div class="header__info-wishlist ml-5">
                                                                        <a href="wishlist.html"><i class="icon-heart icons"></i></a>
                                                                    </div>
                                                                    <div class="header__info-cart ml-5 tp-cart-toggle">
                                                                        <button><i class="icon-cart icons"></i>
                                                                            <span>5</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- header-search -->
        <div class="tpsearchbar tp-sidebar-area">
            <button class="tpsearchbar__close"><i class="icon-x"></i></button>
            <div class="search-wrap text-center">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-6 pt-100 pb-100">
                            <h2 class="tpsearchbar__title">What Are You Looking For?</h2>
                            <div class="tpsearchbar__form">
                                <form action="#">
                                    <input type="text" name="search" placeholder="Search Product...">
                                    <button class="tpsearchbar__search-btn"><i class="icon-search"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="search-body-overlay"></div>
        <!-- header-search-end -->
        <!-- header-cart-start -->
        <div class="tpcartinfo tp-cart-info-area p-relative">
            <button class="tpcart__close"><i class="icon-x"></i></button>
            <div class="tpcart">
                <h4 class="tpcart__title">Your Cart</h4>
                <div class="tpcart__product">
                    <div class="tpcart__product-list">
                        <ul>
                            <li>
                                <div class="tpcart__item">
                                    <div class="tpcart__img">
                                        <img src="/web-site/assets/img/product/products1-min.jpg" alt="">
                                        <div class="tpcart__del">
                                            <a href="#"><i class="icon-x-circle"></i></a>
                                        </div>
                                    </div>
                                    <div class="tpcart__content">
                                 <span class="tpcart__content-title"><a href="shop-details.html">Stacy's Pita Chips Parmesan Garlic & Herb From Nature</a>
                                 </span>
                                        <div class="tpcart__cart-price">
                                            <span class="quantity">1 x</span>
                                            <span class="new-price">Rs 162.80</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="tpcart__item">
                                    <div class="tpcart__img">
                                        <img src="/web-site/assets/img/product/products12-min.jpg" alt="">
                                        <div class="tpcart__del">
                                            <a href="#"><i class="icon-x-circle"></i></a>
                                        </div>
                                    </div>
                                    <div class="tpcart__content">
                                 <span class="tpcart__content-title"><a href="shop-details.html">Banana, Beautiful Skin, Good For Health 1Kg</a>
                                 </span>
                                        <div class="tpcart__cart-price">
                                            <span class="quantity">1 x</span>
                                            <span class="new-price">Rs 138.00</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="tpcart__item">
                                    <div class="tpcart__img">
                                        <img src="/web-site/assets/img/product/products3-min.jpg" alt="">
                                        <div class="tpcart__del">
                                            <a href="#"><i class="icon-x-circle"></i></a>
                                        </div>
                                    </div>
                                    <div class="tpcart__content">
                                 <span class="tpcart__content-title"><a href="shop-details.html">Quaker Popped Rice Crisps Snacks Chocolate</a>
                                 </span>
                                        <div class="tpcart__cart-price">
                                            <span class="quantity">1 x</span>
                                            <span class="new-price">Rs 162.8</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="tpcart__checkout">
                        <div class="tpcart__total-price d-flex justify-content-between align-items-center">
                            <span> Subtotal:</span>
                            <span class="heilight-price"> Rs 300.00</span>
                        </div>
                        <div class="tpcart__checkout-btn">
                            <a class="tpcart-btn mb-10" href="cart.html">View Cart</a>
                            <a class="tpcheck-btn" href="checkout.html">Checkout</a>
                        </div>
                    </div>
                </div>
                <div class="tpcart__free-shipping text-center">
                    <span>Free shipping for orders <b>under 10km</b></span>
                </div>
            </div>
        </div>
        <div class="cartbody-overlay"></div>
        <!-- header-cart-end -->
        <!-- mobile-menu-area -->
        <div id="header-sticky-2" class="tpmobile-menu d-xl-none p-0">
            <div class="container-fluid">
                <div class="row p-relative d-flex justify-content-between" style="height: 50px;">
                    <div class="col-lg-12 text-center">
                        <button class="tp-menu-toggle"><i class="icon-menu1"></i></button>
                    </div>
                    <div class="col-lg-4 col-md-4 col-6 col-sm-4">
                        <div class="logo p-relative" style="z-index: 2;">
                            <a href="index.html"><img src="/web-site/assets/img/logo/logo.svg" alt="logo"></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-3 col-sm-5 float-right">
                        <div class="header__info d-flex align-items-center">
                            <div class="header__info-search ml-5 d-none d-sm-block">
                                <button class="tp-search-toggle"><i class="icon-search"></i></button>
                            </div>
                            <div class="header__info-user ml-5 d-none d-sm-block">
                                <a href="log-in.html"><i class="icon-user"></i></a>
                            </div>
                            <div class="header__info-wishlist ml-5 d-none d-sm-block">
                                <a href="wishlist.html"><i class="icon-heart icons"></i></a>
                            </div>
                            <div class="header__info-cart ml-5 tp-cart-toggle">
                                <button><i class="icon-cart icons"></i>
                                    <span>5</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="body-overlay"></div>
        <!-- mobile-menu-area-end -->
        <!-- sidebar-menu-area -->
        <div class="tpsideinfo">
            <button class="tpsideinfo__close">Close<i class="fal fa-times ml-10"></i></button>
            <div class="tpsideinfo__search text-center pt-2 px-3">
                <span class="tpsideinfo__search-title mb-20">What Are You Looking For?</span>
                <form action="#">
                    <input type="text" placeholder="Search Products...">
                    <button><i class="icon-search"></i></button>
                </form>
            </div>
            <div class="mobile-menu"></div>
            <div class="tpsideinfo__wishlist-link">
                <a href="wishlist.html" target="_parent"><i class="icon-heart"></i> Wishlist</a>
            </div>
            <div class="tpsideinfo__account-link">
                <a href="log-in.html"><i class="icon-user icons"></i> Login / Register</a>
            </div>
        </div>
        <!-- sidebar-menu-area-end -->
    </header>
</template>
<script setup>
import {computed, ref} from "@vue/runtime-core";
import {useAppUtility} from "@admin/Composables/appUtility";
import {useInertiaPropsUtility} from "@admin/Composables/inertiaPropsUtility";
const {getImageLink} = useAppUtility();

const {iPropsValue} = useInertiaPropsUtility();
const productInfo = iPropsValue("productInfo");
const categories = iPropsValue("categories");

const isActiveLink = (sub_category) => {
    if(productInfo != undefined && productInfo.sub_category === sub_category )
    {
        return true;
    }
    return false;
}
</script>
<style lang="scss">
.has-logo
{
    .logo
    {
        margin-top: 20px;
        z-index: 2;
    }
}
.logo
{
    img
    {
        max-width:250px;
    }
}
#mobile-menu
{
    .social
    {
        padding: 0 12px ;
    }
    .has-dropdown{
        padding: 0 15px;
        &:has(a.active)
        {
            background: var(--tp-heading-primary);
        }

    }
}
.mean-nav
{
    .mobile-expand
    {
        padding-left:12px ;
    }
    .has-dropdown{
        &:has(a.active)
        {
            color: #fff;
            background: var(--tp-heading-primary);
        }

    }
}
</style>
