<template>
    <el-dialog
        v-model="FormVisible"
        :before-close="closeForm"
        title="Ordered Product List"
    >
        <template #default>
            <el-table :data="orderedItems"  height="350"  style="width: 100%">
                <el-table-column prop="product.name" label="Product name"/>
                <el-table-column label=" No of Product">
                    <template #default="scope">
                        {{ scope.row.quantity * scope.row.offer_quantity}} ({{ scope.row.product.unit}})
                    </template>
                </el-table-column>
            </el-table>
        </template>
    </el-dialog>
</template>

<script setup>
import {onMounted, reactive, ref, unref} from "@vue/runtime-core";

import {useInertiaPropsUtility} from "@/Composables/inertiaPropsUtility";
import moment from "moment/moment.js";
const {iPropsValue} = useInertiaPropsUtility();

const dateFormatter = (date) => moment(date).format("MMM Do, YYYY");
const orderedItems = ref([]);
const FormVisible = ref(false);

const showList = (customerInfo) => {
    FormVisible.value = true;
    orderedItems.value = [];
    axios.get(route('client.productOrder.list', customerInfo.id))
        .then(response => {
            // Handle the JSON response data
            orderedItems.value = response.data.results;
            // Use the data as needed
        })
        .catch(error => {
            // Handle any errors
        });
    console.log('modal ',customerInfo);
}
const closeForm = () => {
    FormVisible.value = false;
}
onMounted(() => {

});
defineExpose({
    showList
})
</script>

<style lang="scss" scoped>

</style>
