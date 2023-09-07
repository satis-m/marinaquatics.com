<template>
    <div class="body-overlay"></div>
    <!-- mobile-side-menu-area -->
    <div class="tpsideinfo">
        <button class="tpsideinfo__close d-flex px-3 justify-center align-items-center">
            Close
        </button>
        <div class="tpsideinfo__search text-center pt-2 px-3">
            <span class="tpsideinfo__search-title mb-20">What Are You Looking For?</span>
            <form action="#">
                <input type="text" placeholder="Search Products...">
                <button><i class="icon-search"></i></button>
            </form>
        </div>
        <div class="mean-container flex">
            <div class="mean-bar">
                <a href="#nav" class="meanmenu-reveal" style="right: 0px; left: auto; display: inline;"><span><span><span></span></span></span></a>
                <nav id="mobile-menu" class="mean-nav">
                    <ul>
                        <li class="has-dropdown">
                            <a class="mean-expand" href="#" style="font-size: 18px">
                                <i class="icon-plus"></i>
                            </a>
                            <a href="javascript:void(0)" class="mobile-expand">Japanese Koi</a>
                            <ul class="sub-menu" style="display: none;">
                                    <li :key="key" v-for="(category ,key) in categories['Japanese Koi']" class="has-dropdown">
                                        <a class="mean-expand" href="#" style="font-size: 18px">
                                            <i class="icon-plus"></i>
                                        </a>
                                        <NavLink @click="handleMobileMenuClick"
                                                 class="mobile-expand-sub"
                                                 :href="appRoute('product.category.view',category.slug)">
                                            {{ category.sub_category }}
                                        </NavLink>
                                        <ul class="sub-menu" style="display: none;">
                                            <li :key="key" v-for="(type ,key) in category.types">
                                                <NavLink @click="handleMobileMenuClick" :href="appRoute('product.category.view',type.slug)">
                                                    {{ type.name }}
                                                </NavLink>
                                            </li>
                                        </ul>
                                    </li>
                            </ul>
                        </li>
                        <li class="has-dropdown">
                            <a class="mean-expand" href="#" style="font-size: 18px">
                                <i class="icon-plus"></i>
                            </a>
                            <a href="javascript:void(0)" class="mobile-expand">Exotic Livestock</a>
                            <ul class="sub-menu" style="display: none;">
                                <li :key="key" v-for="(category ,key) in categories['Exotic Livestock']" class="has-dropdown">
                                    <a class="mean-expand" href="#" style="font-size: 18px">
                                        <i class="icon-plus"></i>
                                    </a>
                                    <NavLink @click="handleMobileMenuClick"
                                             :href="appRoute('product.category.view',category.slug)">
                                        {{ category.sub_category }}
                                    </NavLink>
                                    <ul class="sub-menu" style="display: none;">
                                        <li :key="key" v-for="(type ,key) in category.types">
                                            <NavLink @click="handleMobileMenuClick" :href="appRoute('product.category.view',type.slug)">
                                                {{ type.name }}
                                            </NavLink>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="has-dropdown">
                            <a class="mean-expand" href="#" style="font-size: 18px">
                                <i class="icon-plus"></i>
                            </a>
                            <a href="javascript:void(0)" class="mobile-expand">Aquariums</a>
                            <ul class="sub-menu" style="display: none;">
                                <li :key="key" v-for="(category ,key) in categories['Aquariums']" class="has-dropdown">
                                    <a class="mean-expand" href="#" style="font-size: 18px">
                                        <i class="icon-plus"></i>
                                    </a>
                                    <NavLink @click="handleMobileMenuClick"
                                             :href="appRoute('product.category.view',category.slug)">
                                        {{ category.sub_category }}
                                    </NavLink>
                                    <ul class="sub-menu" style="display: none;">
                                        <li :key="key" v-for="(type ,key) in category.types">
                                            <NavLink @click="handleMobileMenuClick" :href="appRoute('product.category.view',type.slug)">
                                                {{ type.name }}
                                            </NavLink>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="has-dropdown">
                            <a class="mean-expand" href="#" style="font-size: 18px">
                                <i class="icon-plus"></i>
                            </a>
                            <a href="javascript:void(0)" class="mobile-expand">Aquarium Supplies</a>
                            <ul class="sub-menu" style="display: none;">
                                <li :key="key" v-for="(category ,key) in categories['Aquarium Supplies']" class="has-dropdown">
                                    <a class="mean-expand" href="#" style="font-size: 18px">
                                        <i class="icon-plus"></i>
                                    </a>
                                    <NavLink @click="handleMobileMenuClick"
                                             :href="appRoute('product.category.view',category.slug)">
                                        {{ category.sub_category }}
                                    </NavLink>
                                    <ul class="sub-menu" style="display: none;">
                                        <li :key="key" v-for="(type ,key) in category.types">
                                            <NavLink @click="handleMobileMenuClick" :href="appRoute('product.category.view',type.slug)">
                                                {{ type.name }}
                                            </NavLink>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li v-if="iPropsValue('auth')">
                            <a href="appRoute('client.dashboard')"><i class="icon-user icons"></i> My Profile</a>
                        </li>
                        <li v-else>
                            <a href="appRoute('client.login')"><i class="icon-user icons"></i> Login / Register</a>
                        </li>
                        <li v-if="iPropsValue('auth')">
                            <a href="wishlist.html" target="_parent"><i class="icon-heart"></i> Wishlist</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- mobile-side-menu-area-end -->
</template>
<script setup>
import {useInertiaPropsUtility} from "@admin/Composables/inertiaPropsUtility";
const {iPropsValue} = useInertiaPropsUtility();
const handleMobileMenuClick = (event) => {
    console.log(event.target);
    const list = document.querySelectorAll('#mobile-menu ul li.has-dropdown .sub-menu li a');
    // list.forEach((element) => {
    //     console.log(element)
    //     // element.classList.remove("active");
    // })
    // event.target.classList.add('active');
    $(".tpsideinfo").removeClass("tp-sidebar-opened");
    $(".body-overlay").removeClass("opened");

}
const productInfo = iPropsValue("productInfo");
const categories = iPropsValue("categories");
const isActiveLink = (sub_category) => {
    if (route().current('product.category.view', {slug: sub_category}) || (productInfo != undefined && productInfo.sub_category === sub_category)) {
        return true;
    }
    return false;
}
</script>
