<template>
  <el-dialog
      v-model="FormVisible"
      :before-close="closeForm"
      title="Items Ordered"
  >
    <template #default>
        <div class="text-center flex flex-row justify-between">
          <div class="w-64 text-left text-xl font-bold">
            <div>
              Order No: {{ BillData.order_no }}
            </div>
            <div v-if="BillData.order_status == 'cancelled'" class="text-red-600 capitalize">
              {{ BillData.order_status }}
            </div>
          </div>

        </div>
        <div class="mt-4">
          <table class="w-full border-b-4">
            <thead class="bg-gray-100 ">
            <tr>
              <th class="p-3">Particular</th>
              <th class="p-3 text-right">Remaining stock</th>
              <th class="p-3 text-right">Price</th>
              <th class="p-3 text-right">Qty</th>
              <th class="p-3 text-right">Total Amount</th>
            </tr>
            </thead>
            <tbody>
            <tr :key="key" v-for="(orderItem , key) in BillData.order_items">
              <td class="p-3">{{ orderItem.product.name }} - ( {{ orderItem.offer_name
                }} )</td>
              <td class="p-3 text-right">{{ orderItem.product.available_quantity }} ({{ orderItem.product.unit}})</td>
              <td class="p-3 text-right">{{ formattedCurrency(orderItem.offer_price) }}</td>
              <td class="p-3 text-right"> {{+orderItem.offer_quantity* +orderItem.quantity }}</td>
              <td class="p-3 text-right">{{ formattedCurrency((orderItem.offer_quantity * orderItem.quantity ) * orderItem.offer_price )}}</td>
            </tr>
            </tbody>
          </table>
          <div class="flex flex-col items-end ">
            <div class="w-64 py-1 px-3 flex justify-between">
              <span>Sub-Total :</span>
              <span>{{ formattedCurrency(BillData.subtotal_amount) }}</span>
            </div>
            <div class="w-64 py-1 px-3 flex justify-between">
              <span>Discount : {{ BillData.discount }}%</span>
              <span>Rs. ({{ BillData.subtotal_amount - BillData.total_amount }})</span>
            </div>
            <div class="w-64 py-1 px-3 flex justify-between">
              <span>Total : </span>
              <span>{{ formattedCurrency(BillData.total_amount) }}</span>
            </div>
          </div>

        </div>
    </template>
  </el-dialog>
</template>

<script setup>
import {onMounted, reactive, ref, unref} from "@vue/runtime-core";
import moment from "moment/moment.js";
import {useInertiaPropsUtility} from "@/Composables/inertiaPropsUtility";
const {iPropsValue} = useInertiaPropsUtility();

import {useNumberUtility} from "@/Composables/numberUtility";
const {formattedCurrency} = useNumberUtility();

const dateFormatter = (date) => moment(date).format("MMM Do, YYYY");
const BillData = ref('');
const FormVisible = ref(false);

const showItems = (billData) => {
  FormVisible.value = true;
  BillData.value = billData;
}
const closeForm = () => {
  FormVisible.value = false;
}
onMounted(() => {

});
defineExpose({
  showItems
})
</script>

<style lang="scss" scoped>

</style>