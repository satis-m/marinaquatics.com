<template>
    <!-- header-cart-start -->
    <div class="tpcartinfo tp-cart-info-area">
        <button class="tpcart__close"><i class="icon-x"></i></button>
        <div class="tpcart">
            <h4 class="tpcart__title">My Cart</h4>
            <div class="tpcart__product">
                <div class="tpcart__product-list flex-grow-1 overflow-y-visible">
                    <ul>
                        <li>
                            <div class="tpcart__item">
                                <div class="tpcart__img">
                                    <img src="/web-site/assets/img/product/products1-min.jpg" alt="">
                                    <div class="tpcart__del">
                                        <a @click="confirmRemove" href="#"><i class="icon-x-circle"></i></a>
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
                                        <a @click="confirmRemove" href="#"><i class="icon-x-circle"></i></a>
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
                                        <a @click="confirmRemove" href="#"><i class="icon-x-circle"></i></a>
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
                    <div class="tpcart__checkout-btn d-flex gap-3">
                        <a class="tpcart-btn flex-1" href="cart.html">View Cart</a>
                        <a class="tpcheck-btn flex-1" href="checkout.html">Checkout</a>
                    </div>
                </div>
            </div>
            <div class="tpcart__free-shipping text-center">
                <span>Free shipping for orders <b>over Rs 5000</b> inside Ring Road.</span>
            </div>
        </div>
    </div>
    <div class="cartbody-overlay"></div>
    <!-- header-cart-end -->
</template>
<script setup>
import {useInertiaPropsUtility} from "@admin/Composables/inertiaPropsUtility";
const {iPropsValue} = useInertiaPropsUtility();
import Swal from 'sweetalert2'
const confirmRemove = ()=>{
    Swal.fire({
        title: '<strong>Cart Update</strong>',
        icon: 'info',
        html:'Remove Product From Cart ',
        showCloseButton: false,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText:
            'Remove',
        confirmButtonAriaLabel: 'Thumbs up, great!',
        cancelButtonText:
            'Cancel',
        cancelButtonAriaLabel: 'Thumbs down'
    })
}
</script>
<style lang="scss">
.tpcart__product-list
{
    height: calc( 100vh - 215px);
}
</style>
