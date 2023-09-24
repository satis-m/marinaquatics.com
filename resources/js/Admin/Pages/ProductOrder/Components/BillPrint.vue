<template>
    <el-dialog
        v-model="FormVisible"
        :before-close="closeForm"
        title="Product Billing"
    >
        <template #default>
            <div id="print-me">
                <div class="text-center flex flex-row justify-between">
                    <div class="w-64 text-left text-xl font-bold">
                        <div>
                            Order No: {{ BillData.order_no }}
                        </div>
                        <div v-if="BillData.order_status == 'canceled'" class="text-red-600 capitalize">
                            {{ BillData.order_status }}
                        </div>
                    </div>

                    <div class="flex flex-col text-right">
                        <span class=""><img :src="iPropsValue('app_info', 'brandLogo')" :alt="iPropsValue('app_info', 'title')" style=" width:250px" ></span>
                        <span class="">{{ iPropsValue('app_info', 'address') }}</span>
                        <span class="mt-1">Contact:  {{ iPropsValue('app_info', 'contact') }}</span>
                    </div>

                </div>
                <div >
                    <div><span class="font-bold">Customer Name: </span> {{ BillData.billing.billing_name }}</div>
                    <div><span class="font-bold">Address: </span> {{ BillData.billing.billing_address }}</div>
                    <div><span class="font-bold">Contact No: </span> {{ BillData.billing.billing_contact }}</div>
                    <div><span class="font-bold">VAT / PAN no.: </span> {{ BillData.billing.vat_pan }}</div>
                    <div><span class="font-bold">Date: </span> {{dateFormatter(BillData.billing.created_at)}} </div>
                </div>
                <div class="mt-4">
                    <table class="w-full border-b-4">
                        <thead class="bg-gray-100 ">
                        <tr>
                            <th class="p-3">Particular</th>
                            <th class="p-3 text-right">Price</th>
                            <th class="p-3 text-right">Qty</th>
                            <th class="p-3 text-right">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr :key="key" v-for="(orderItem , key) in BillData.order_items">
                            <td class="p-3">{{ orderItem.product.name }} - ( {{ orderItem.offer_name
                                }} )</td>
                            <td class="p-3 text-right">Rs.{{ orderItem.offer_price }}</td>
                            <td class="p-3 text-right"> <span v-show="orderItem.offer_quantity > 1">{{ orderItem.offer_quantity }} x </span>{{ orderItem.quantity }}</td>
                            <td class="p-3 text-right">Rs.{{ (orderItem.offer_quantity * orderItem.quantity ) * orderItem.offer_price }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="flex flex-col items-end ">
                        <div class="w-64 py-1 px-3 flex justify-between">
                            <span>Sub-Total :</span>
                            <span>Rs. {{ BillData.subtotal_amount }}</span>
                        </div>
                        <div class="w-64 py-1 px-3 flex justify-between">
                            <span>Discount : {{ BillData.discount }}%</span>
                            <span>Rs. ({{ BillData.subtotal_amount - BillData.total_amount }})</span>
                        </div>
                        <div class="w-64 py-1 px-3 flex justify-between">
                            <span>Total : </span>
                            <span>Rs. {{ BillData.total_amount }}</span>
                        </div>
                    </div>

                </div>

            </div>
        </template>
    </el-dialog>
</template>

<script setup>
import {onMounted, reactive, ref, unref} from "@vue/runtime-core";
import {usePaperizer} from 'paperizer'

const {paperize} = usePaperizer('print-me', {
    styles: [
        'https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css',
        '/print.css'
    ]
})
import {useInertiaPropsUtility} from "@/Composables/inertiaPropsUtility";
import moment from "moment/moment.js";
const {iPropsValue} = useInertiaPropsUtility();

const dateFormatter = (date) => moment(date).format("MMM Do, YYYY");
const BillData = ref('');
const FormVisible = ref(false);

const showBill = (billData) => {
    FormVisible.value = true;
    BillData.value = billData;
    setTimeout(() => {
        paperize();
    }, 300)
}
const closeForm = () => {
    FormVisible.value = false;
}
onMounted(() => {

});
defineExpose({
    showBill
})
</script>

<style lang="scss" scoped>

</style>
