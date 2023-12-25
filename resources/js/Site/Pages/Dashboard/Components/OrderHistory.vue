<template>
  <Head>
    <title>Order History</title>
  </Head>
  <div class="flex flex-col w-100 gap-3">
    <div :key="key" v-for="(order,key) in orders" v-if="orders.length > 0" class="orders bg-white p-3  rounded  divide-y">
      <div class="order-info flex justify-between">
        <div class="flex flex-col justify-between">
          <p>Order Id: <span class="text-red font-bold">{{ order.order_no }}</span> (<span class="text-sm">{{ order.delivery_type == 'pick' ? 'Store Pickup' : 'Delivery'}}</span>)</p>
          <p class="text-sm mt-1">Total Amount: {{ formattedCurrency(order.total_amount) }}
            <Popper arrow placement="right">
              <i class="font-bolder hover:cursor-pointer rounded-2xl p-0.5 bg-blue-700 text-white icon-info"></i>
              <template #content>
                <div>
                  <p class="text-white">Payment Info</p>
                  <hr>
                  <p class="text-white font-light text-sm">Type : {{ order.payment_method == "cod" ? 'Cash On Delivery' : 'Bank Transfer' }}</p>
                  <p class="text-white  font-light  text-sm ">Status : {{ order.payment_status }}</p>
                </div>
              </template>
            </Popper>
          </p>
        </div>
        <div class="flex justify-center max-sm:flex-col px-2">
          <div :class="order.order_status" class="capitalize h-7 text-sm tracking-wider">{{ order.order_status}}</div>
          <div v-if="order.order_status == 'queue' && order.payment_method == 'cod' " class="capitalize text-sm tracking-wider bg-red-700 rounded-3xl flex justify-center items-center w-7 h-7 hover:cursor-pointer text-white" @click="confirmOrderCancel(order.order_no)" title="cancel order">
            <i class="icon-x"></i>
          </div>
        </div>
        <div class="text-sm text-gray-500">
          <p>Ordered Date: {{ order.order_date }}</p>
          <p v-if="order.delivery_type == 'ship'">Delivered Date: {{ order.delivered_date ?? 'To be confirmed...' }}</p>
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
            <div class="text-sm"> {{ orderItem.quantity }} x {{ formattedCurrency(orderItem.offer_price) }}</div>

          </div>
          <div class="grow-0 flex align-items-center">
            {{ formattedCurrency(orderItem.item_total) }}
          </div>
        </div>
      </div>
    </div>
    <div v-else>
      <NoRecords>Order list is empty.</NoRecords>
    </div>
  </div>
</template>

<script setup>
import {ref, watch, onMounted} from "@vue/runtime-core";
import NoRecords from "@/Components/NoRecords.vue";
import Popper from "vue3-popper";

import {useInertiaPropsUtility} from "@admin/Composables/inertiaPropsUtility";
const {iPropsValue} = useInertiaPropsUtility();

import {useNumberUtility} from "@admin/Composables/numberUtility";
import Swal from "sweetalert2";
import {useForm} from "@inertiajs/vue3";
const {formattedCurrency} = useNumberUtility();
const showPopper = ref(false);
const orders = ref(iPropsValue('orders'));
watch(() => iPropsValue('orders'), (newValue) => {
  orders.value = newValue
})
const confirmOrderCancel = (orderNo)=>{
  Swal.fire({
    title: '<strong>Cancel Order</strong>',
    icon: 'error',
    html: 'Do you want to cancel this order?',
    showCloseButton: false,
    showCancelButton: true,
    focusConfirm: true,
    confirmButtonColor:'#d0112b',
    confirmButtonText:
        'Yes, Cancel',
    confirmButtonAriaLabel: 'Thumbs up, great!',
    cancelButtonText:
        'No',
    cancelButtonAriaLabel: 'Thumbs down'
  }).then((result) => {
    if (result.isConfirmed) {
      try {
        const formData = useForm({ orderNo });
        formData.delete(route("user.order.cancel"), {
          preserveScroll: true,
          onSuccess: (data) => {
            formData.reset();
          },
        })
      } catch (error) {
        vt.error("Request Form Error")
        console.log(error);
      }
    }
  })
}
onMounted(() => {
})
</script>
<style>
:root {
  --popper-theme-background-color: #565656;
  --popper-theme-background-color-hover: #565656;
  --popper-theme-text-color: #f5f5f5;
  --popper-theme-border-width: 0px;
  --popper-theme-border-style: solid;
  --popper-theme-border-radius: 6px;
  --popper-theme-padding: 4px 8px;
  --popper-theme-box-shadow: 0 6px 30px -6px rgba(0, 0, 0, 0.25);
}
.queue{
  background: #e89a05;
  padding: 4px 10px;
  border-radius: 30px;
}
.cancelled{
  background: var(--tp-theme-1);
  color: #fff;
  padding: 4px 10px;
  border-radius: 30px;
}
.shipped
{
  background: #4c80bb;
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
.popper
{
  z-index: 1 !important;
}
</style>
