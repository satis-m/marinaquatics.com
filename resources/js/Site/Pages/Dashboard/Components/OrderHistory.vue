<template>
  <Head>
    <title>Order History</title>
  </Head>
  <div class="flex flex-col w-100 gap-3">
    <div :key="key" v-for="(order,key) in orders" class="orders bg-white p-3  rounded  divide-y">
      <div class="order-info flex justify-between">
        <div class="flex flex-col justify-between">
          <p>Order Id: <span class="text-red font-bold">{{ order.order_no }}</span> (<span class="text-sm">{{ order.delivery_type == 'pick' ? 'Store Pickup' : 'Deliver'}}</span>)</p>
          <p class="text-sm mt-1">Total Amount: Rs. {{ order.total_amount }}</p>
        </div>
        <div>
          <span :class="order.order_status" class="capitalize text-sm tracking-wider">{{ order.order_status}}</span>
        </div>
        <div class="text-sm text-gray-500">
          <p>Ordered Date: {{ order.order_date }}</p>
          <p v-if="order.delivered_date">Delivered Date: {{ order.delivered_date }}</p>
        </div>
      </div>
      <div class="order-item">
        <div v-for="orderItem in order.order_items" class="pt-3 flex gap-2">
          <div class="grow-0">
            <NavLink :href="appRoute('product.view', orderItem.product_slug )">
              <img :src="orderItem.product_main_picture.thumbnail" class="w-[75px] rounded" :alt="orderItem.product_slug">
            </NavLink>
          </div>
          <div class="grow flex flex-col justify-between ml-2">
            <div><NavLink class="hover:text-red-700" :href="appRoute('product.view', orderItem.product_slug )"> {{ orderItem.product_name }} - {{ orderItem.offer_name }}</NavLink></div>
            <div class="text-sm"> {{ orderItem.quantity }} x Rs. {{ orderItem.offer_price }}</div>

          </div>
          <div class="grow-0 flex align-items-center">
            Rs. {{ orderItem.item_total }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref, watch, onMounted} from "@vue/runtime-core";

import {useInertiaPropsUtility} from "@admin/Composables/inertiaPropsUtility";

const {iPropsValue} = useInertiaPropsUtility();

const orders = ref(iPropsValue('orders'));
watch(() => iPropsValue('orders'), (newValue) => {
  orders.value = newValue
})
onMounted(() => {
})
</script>
<style>
.queue{
  background: #e89a05;
  padding: 4px 10px;
  border-radius: 30px;
}
.canceled{
  background: var(--tp-theme-1);
  color: #fff;
  padding: 4px 10px;
  border-radius: 30px;
}
.delivered
{
  background: #859A00;
  color: #fff;
  padding: 4px 10px;
  border-radius: 30px;
}
</style>
