<template>
    <!-- header-cart-start -->
    <div class="tpcartinfo tp-cart-info-area">
        <div class="tpcart">
            <div class="tpcart__title pl-3 pr-2 flex flex-row justify-between align-items-center">
                <h4 class="grow h-12 text-lg flex align-items-center ">My Cart</h4>
                <button class="tpcart__close"><i class="icon-x"></i></button>
            </div>
            <div class="tpcart__product">
                <div class="tpcart__product-list flex-grow-1 overflow-y-visible">
                    <ul :key="cartItemsKey">
                        <li v-for="cartItem in userCart">
                            <CartItem :item="cartItem" @updateItem = "updateItemCount"/>
                        </li>
                    </ul>
                </div>
                <div class="tpcart__checkout">
                    <div class="tpcart__total-price d-flex justify-content-between align-items-center">
                        <span class="uppercase"> SubTotal:</span>
                        <span class="heilight-price"> Rs. {{totalAmount}}</span>
                    </div>
                    <div class="tpcart__checkout-btn d-flex gap-3">
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
import {ref, watch, onMounted} from "@vue/runtime-core";
import CartItem from "./CartItem.vue"

import {useInertiaPropsUtility} from "@admin/Composables/inertiaPropsUtility";
const {iPropsValue} = useInertiaPropsUtility();

const totalAmount = ref(0);
const cartItemsKey = ref(1);
const userCart = ref(iPropsValue('auth', 'cart'));
watch(() => iPropsValue('auth', 'cart'), (newVal) => {
    userCart.value = newVal;
    updateTotal();
    updateItemCount();
})
const updateTotal = ()=>{
    totalAmount.value = 0;
    userCart.value.forEach(item => {
        const itemTotal =(item.offer_price*item.offer_quantity)*item.quantity;
        totalAmount.value = +totalAmount.value + +itemTotal
    });
}
const updateItemCount = ()=>{
  cartItemsKey.value++;
}
onMounted(()=>{
    updateTotal();
})
</script>
<style lang="scss">
.tpcart__product-list {
    height: calc(100vh - 215px);
}
</style>
