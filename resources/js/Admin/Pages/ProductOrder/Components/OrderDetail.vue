<template>
  <el-dialog
      v-model="FormVisible"
      :before-close="closeForm"
      title="Items Ordered"
  >
    <template #default>
        <div class="text-center flex flex-row justify-between -mt-4">
          <div class="w-64 text-left text-xl font-bold">
            <div>
              Order No: {{ BillData.order_no }}
            </div>
            <div v-if="BillData.order_status == 'cancelled'" class="text-red-600 capitalize">
              {{ BillData.order_status }}
            </div>
          </div>
        </div>
        <div>
            <el-descriptions title="Order Info" border :column="3">
                <el-descriptions-item label="Customer Name">{{ BillData.customer.name }}</el-descriptions-item>
                <el-descriptions-item label="email">{{ BillData.customer.email }}</el-descriptions-item>
                <el-descriptions-item label="Payment Method">{{ BillData.payment_method }}</el-descriptions-item>
                <el-descriptions-item label="Payment Status">
                    <el-tag
                        v-if="BillData.payment_status == 'pending'"
                        type="warning"
                        class="mx-1"
                        effect="dark"
                        round
                        size="small"
                    >
                        {{ BillData.payment_status }}
                    </el-tag>
                    <el-tag
                        v-else-if="BillData.payment_status == 'verified'"
                        type="success"
                        class="mx-1"
                        effect="dark"
                        round
                        size="small"
                    >
                        {{ BillData.payment_status }}
                    </el-tag>
                </el-descriptions-item>

                <el-descriptions-item label="Delivery Type">{{ BillData.delivery_type }}</el-descriptions-item>
                <el-descriptions-item label="Order Status">
                    <el-tag
                        v-if="BillData.order_status == 'cancelled'"
                        type="danger"
                        class="mx-1"
                        effect="dark"
                        round
                        size="small"
                    >
                        {{ BillData.order_status }}
                    </el-tag>
                    <el-tag
                        v-else-if="BillData.order_status == 'queue'"
                        type="info"
                        class="mx-1"
                        effect="dark"
                        round
                        size="small"
                    >
                        {{ BillData.order_status }}
                    </el-tag>
                    <el-tag
                        v-else-if="BillData.order_status == 'processing'"
                        type="warning"
                        class="mx-1"
                        effect="dark"
                        round
                        size="small"
                    >
                        {{ BillData.order_status }}
                    </el-tag>
                    <el-tag
                        v-else-if="BillData.order_status == 'delivered'"
                        type="success"
                        class="mx-1"
                        effect="dark"
                        round
                        size="small"
                    >
                        {{ BillData.order_status }}
                    </el-tag>
                    <el-tag
                        v-else-if="BillData.order_status == 'shipped'"
                        type="primary"
                        class="mx-1"
                        effect="dark"
                        round
                        size="small"
                    >
                        {{ BillData.order_status }}
                    </el-tag>
                </el-descriptions-item>
                <el-descriptions-item label="Remarks"  width="150px">
                   {{BillData.note != '' ? BillData.note : '-'}}
                </el-descriptions-item>
            </el-descriptions>
            <el-descriptions title="Billing Info" border class="mt-2" :column="3">
                <el-descriptions-item label="contact">{{ BillData.billing.billing_contact ?? '-' }}</el-descriptions-item>
                <el-descriptions-item label="Landmark" width="150px">{{ BillData.billing.billing_landmark ?? '-' }}</el-descriptions-item>
               <el-descriptions-item label="Address"
                >{{ BillData.billing.billing_address }},{{ BillData.billing.billing_city }},{{ BillData.billing.billing_state }}</el-descriptions-item
                >
            </el-descriptions>
            <el-descriptions title="Shipping Info" class="mt-2" border :column="3">
                <el-descriptions-item label="Contact">{{ BillData.billing.shipping_contact ?? '-' }}</el-descriptions-item>
                <el-descriptions-item label="Landmark" width="150px">{{ BillData.billing.shipping_landmark ??'-' }}</el-descriptions-item>
                <el-descriptions-item label="Address"
                >{{ BillData.billing.shipping_address }},{{ BillData.billing.shipping_city }},{{ BillData.billing.shipping_state }}</el-descriptions-item
                >
            </el-descriptions>
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
