<template>
  <!-- header-cart-start -->
  <div class="tpcartinfo tp-cart-info-area">
    <div class="tpcart">
      <div class="tpcart__title pl-3 pr-2 flex flex-row justify-between align-items-center">
        <h4 class="grow h-12 text-lg flex align-items-center ">My Cart</h4>
        <button class="tpcart__close"><i class="icon-x"></i></button>
      </div>
      <div class="tpcart__product">
        <div  v-if="userCart.length > 0"  class="tpcart__product-list flex-grow-1 overflow-y-visible">
          <ul :key="cartItemsKey">
            <li :key="key" v-for="(cartItem,key) in userCart">
              <CartItem :item="cartItem" @updateItem="updateItemCount"/>
            </li>
          </ul>
        </div>
        <div  v-else class="tpcart__product-list flex-grow-1 overflow-y-visible">
          <p class="text-center flex justify-center flex-col h-100 items-center">
            <img src="/web-site/assets/img/icon/empty-cart.svg" style="width: 75px;" alt="">
            <span class="mt-2">Cart is empty.</span>
          </p>
        </div>
        <div v-if="userCart.length > 0" class="tpcart__checkout">
          <div class="tpcart__total-price d-flex justify-content-between align-items-center">
            <span class="uppercase"> SubTotal:</span>
            <span class="heilight-price"> Rs. {{ totalAmount.toLocaleString() }}</span>
          </div>
          <div  class="tpcart__checkout-btn d-flex gap-3">
            <NavLink class="tpcheck-btn flex-1 cart_close" :href="appRoute('cart.checkout')"> Checkout</NavLink>
          </div>
        </div>
      </div>
      <div class="tpcart__free-shipping text-center">
        <span>Free shipping for orders <b>over Rs {{ iPropsValue('app_info','cod_threshold_amount') }}</b> inside Ring Road.</span>
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
  if (iPropsValue('auth')) {
    userCart.value = newVal;
    updateTotal();
    updateItemCount();

  }
})
const updateTotal = () => {
  totalAmount.value = 0;
  userCart.value.forEach(item => {
    let itemTotal = 0;
    if (item.last_discount != null && item.offer_name == 'Standard') {
      itemTotal = (+item.offer_price - (+item.last_discount.discount / 100) * +item.offer_price) * +item.quantity;
    } else {
      itemTotal = (+item.offer_price * +item.offer_quantity) * +item.quantity;
    }
    totalAmount.value = +totalAmount.value + +itemTotal
  });
}
const updateItemCount = () => {
  cartItemsKey.value++;
}
onMounted(() => {
  updateTotal();
})
</script>
<style lang="scss">
.tpcart__product-list {
  height: calc(100vh - 215px);
}
</style>
