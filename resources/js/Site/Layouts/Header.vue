<template>
    <!-- Scroll-top -->
    <button class="scroll-top scroll-to-target" data-target="html">
        <i class="icon-chevrons-up"></i>
    </button>
    <!-- Scroll-top-end-->
    <!-- header-area-start -->
    <header>
        <div id="header-sticky" class="header__main-area d-none d-xl-block">
            <div class="container-fluid">
                <div class="p-relative">
                    <div class="row align-items-center  p-relative">
                        <div class="col-xl-12">
                            <div class="header__menu main-menu text-center">
                                <nav id="desktop-menu">
                                    <div class="logo">
                                        <NavLink :href="appRoute('homepage')">
                                            <img :src="iPropsValue('app_info','brandLogo')"
                                                 style="-webkit-filter: invert(1);filter: invert(1); height: 75px"
                                                 alt="logo"/>
                                        </NavLink>
                                    </div>
                                    <ul style="height: 75px; display: inline-flex;">
                                        <li class="menu-item">
                                            <a href="javascript:void(0)" class="mobile-expand">Japanese Koi</a>
                                            <div class="sub-menu">
                                                <div class="sub-menu-container">
                                                    <div class="sub-category-container" :key="key"
                                                         v-for="(category ,key) in categories['Japanese Koi']">
                                                        <NavLink :href="appRoute('product.category.view',category.slug)">
                                                            {{ category.sub_category }}

                                                        </NavLink>
                                                        <ul class="sub-category">
                                                            <li :key="key" v-for="(type ,key) in category.types">
                                                                <NavLink :href="appRoute('product.category.view',type.slug)">
                                                                    {{ type.name }}
                                                                </NavLink>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="sub-menu-image-container">
                                                    <img
                                                        src="https://marineaquatics.test/storage/38/conversions/banner-2-poster-medium.webp"
                                                        alt="banner-2-poster.webp">
                                                </div>
                                            </div>
                                        </li>
                                        <li class="menu-item">
                                            <a href="javascript:void(0)" class="mobile-expand">Exotic Livestock</a>
                                            <div class="sub-menu">
                                                <div class="sub-menu-container">

                                                    <div class="sub-category-container" :key="key"
                                                         v-for="(category ,key) in categories['Exotic Livestock']">
                                                        <NavLink :href="appRoute('product.category.view',category.slug)">
                                                            {{ category.sub_category }}
                                                        </NavLink>
                                                        <ul class="sub-category">
                                                            <li :key="key" v-for="(type ,key) in category.types"> {{ type.name }}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="sub-menu-image-container">
                                                    te
                                                </div>
                                            </div>
                                        </li>

                                        <li class="menu-item">
                                            <a href="javascript:void(0)" class="mobile-expand">Aquariums</a>
                                            <div class="sub-menu">
                                                <div class="sub-menu-container">

                                                    <div class="sub-category-container" :key="key"
                                                         v-for="(category ,key) in categories['Aquariums']">
                                                        <NavLink :href="appRoute('product.category.view',category.slug)">
                                                            {{ category.sub_category }}
                                                        </NavLink>
                                                        <ul class="sub-category">
                                                            <li :key="key" v-for="(type ,key) in category.types"> {{ type.name }}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="sub-menu-image-container">
                                                    te
                                                </div>
                                            </div>
                                        </li>
                                        <li class="menu-item">
                                            <a href="javascript:void(0)" class="mobile-expand">Aquarium Supplies</a>
                                            <div class="sub-menu">
                                                <div class="sub-menu-container">

                                                    <div class="sub-category-container" :key="key"
                                                         v-for="(category ,key) in categories['Aquarium Supplies']">
                                                        <NavLink :href="appRoute('product.category.view',category.slug)">
                                                            {{ category.sub_category }}
                                                        </NavLink>
                                                        <ul class="sub-category">
                                                            <li :key="key" v-for="(type ,key) in category.types"> {{ type.name }}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="sub-menu-image-container" style="width: 400px">
                                                    te
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="header__top d-none d-xl-block" style="width: 168px">
                                        <div
                                            class="header__info header__top-right justify-content-end d-flex align-items-center gap-3 me-2">

                                            <button class="tp-search-toggle"><i
                                                class="icon-search"></i></button>

                                            <NavLink
                                                :href=" iPropsValue('auth') != null ? appRoute('client.dashboard'):  appRoute('client.login')">
                                                <i class="icon-user"></i></NavLink>

                                            <NavLink v-if="iPropsValue('auth')" :href="appRoute('client.login')"><i
                                                class="icon-heart icons"></i></NavLink>

                                            <button type="button" v-if="!iPropsValue('auth')"
                                                    class="header__info-cart tp-cart-toggle"><i
                                                class="icon-cart icons"></i>
                                                <span>5</span>
                                            </button>
                                            <NavLink v-if="iPropsValue('auth')" title="logout" method="post" as="button"
                                                     type="button"
                                                     :href="appRoute('client.logout')"><i
                                                class="icon-log-out icons"></i></NavLink>

                                        </div>
                                    </div>
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
        <SideCart/>
        <!-- header-cart-end -->
        <!-- mobile-header-menu-area -->
        <div id="header-sticky-2" class="tpmobile-menu d-xl-none p-0">
            <div class="container-fluid">
                <div class="row p-relative d-flex justify-content-between" style="height: 75px;">
                    <div class="col-lg-12 text-center">
                        <button class="tp-menu-toggle"><i class="icon-menu1"></i></button>
                    </div>
                    <div class="col-lg-4 col-md-4 col-6 col-sm-4">
                        <div class="logo p-relative" style="z-index: 2;">
                            <NavLink :href="appRoute('homepage')">
                                <img :src="iPropsValue('app_info','brandLogo')"
                                     style="-webkit-filter: invert(1);filter: invert(1); height: 75px"
                                     alt="logo">
                            </NavLink>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-3 col-sm-5 h-full float-right">
                        <div class="header__info d-flex h-full justify-content-end align-items-center gap-3 me-3">
                            <button class="tp-search-toggle d-none d-sm-block"><i class="icon-search"></i></button>
                            <NavLink
                                :href=" iPropsValue('auth') != null ? appRoute('client.dashboard'):  appRoute('client.login')">
                                <i class="icon-user"></i></NavLink>

                            <NavLink v-if="iPropsValue('auth')" :href="appRoute('client.login')"
                                     class="d-none d-sm-block"><i class="icon-heart icons"></i></NavLink>

                            <button type="button" class="header__info-cart tp-cart-toggle" v-if="iPropsValue('auth')"><i
                                class="icon-cart icons"></i>
                                <span>5</span>
                            </button>

                            <NavLink v-if="iPropsValue('auth')" title="logout" method="post" as="button" type="button"
                                     :href="appRoute('client.logout')"><i
                                class="icon-log-out icons"></i></NavLink>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- mobile-header-menu-area-end -->
        <MobileHeader/>
    </header>
</template>
<script setup>
import {computed, onMounted, ref} from "@vue/runtime-core";
import {useAppUtility} from "@admin/Composables/appUtility";
import {useInertiaPropsUtility} from "@admin/Composables/inertiaPropsUtility";
import MobileHeader from "./MobileHeader.vue";
import SideCart from "./SideCart.vue";

const {getImageLink} = useAppUtility();
const handleMenuClick = (event) => {
    console.log(event.target);
    // const list = document.querySelectorAll('#desktop-menu ul li.has-dropdown .sub-menu li a');
    // list.forEach((element) => {
    //     element.classList.remove("active");
    // })
    // event.target.classList.add('active');

}


const navKey = ref(1);
const {iPropsValue} = useInertiaPropsUtility();
const productInfo = iPropsValue("productInfo");
const categories = iPropsValue("categories");
const isActiveLink = (sub_category) => {
    if (route().current('product.category.view', {slug: sub_category}) || (productInfo != undefined && productInfo.sub_category === sub_category)) {
        return true;
    }
    return false;
}
</script>
<style lang="scss">
.has-logo {
    .logo {
        margin-top: 20px;
        z-index: 2;
    }
}

.logo {
    img {
        max-width: 250px;
    }
}

#desktop-menu {
    display: flex;
    justify-content: space-between;
    align-items: center;

    .social {
        padding: 0 12px;
        align-items: baseline;
    }

    .has-dropdown, .menu-item {
        padding: 0 10px;


        ul.sub-menu {
            a.active {
                color: var(--tp-heading-primary);
            }
        }

    }
}

.mean-nav {
    .mobile-expand {
        padding-left: 12px;
    }

    .has-dropdown, .menu-item{
        &:has(a.active) {
            a.mobile-expand,a.mobile-expand-sub {
                color: #fff;
                background: var(--tp-heading-primary);
            }
        }

        ul.sub-menu {
            a.active {
                color: #fff;
                background: var(--tp-heading-primary);
            }
        }
    }
}

a.cstm-icon {
    display: flex;
    justify-content: center;
    align-items: center;

    img {
        width: 20px;
        height: 20px;
    }
}

.main-menu ul li a {
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.menu-item {
    .sub-menu {
        display: flex;
        justify-content: space-between;
        padding: 0 !important;

        .sub-menu-container {
            display: flex;
            flex-direction: row;
            width: 100%;

            .sub-category-container {
                display: flex;
                flex-flow: column;
                margin: 5px 10px;
                flex-grow: 1;

                > a {
                    padding: 10px 0;
                    font-weight: 600;
                    height: 40px;
                    font-size: 1.2rem;
                    justify-content: start;
                    color: var(--tp-heading-primary);
                    border-bottom: 1px solid black;
                }

                .sub-category {
                    display: flex;
                    flex-flow: column;
                    max-height: 450px;
                    flex-wrap: wrap;
                    li {
                        justify-content: start;
                        font-family: Roboto Condensed,sans-serif;
                        font-style: normal;
                        font-weight: 400;
                        font-size: 1rem;
                        padding: 0.4375rem 1.4375rem 0.4375rem 0;
                        text-align:left;
                        cursor: pointer;
                        &hover{

                        }

                    }

                }
            }
        }

        .sub-menu-image-container {
            width: 550px;
            display: block;
            padding: 20px;

            img {
                border-radius: 6px;
            }
        }
    }
}
</style>
