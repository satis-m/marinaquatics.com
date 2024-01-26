<template>
    <el-dialog
        v-model="FormVisible"
        :before-close="closeForm"
        title="Cart Product List"
    >
        <template #default>
            <el-table :data="cartItems"  height="350"  style="width: 100%">
                <el-table-column prop="product.name" label="Product name"/>
                <el-table-column label="No of Product">
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
const {iPropsValue} = useInertiaPropsUtility();

const cartItems = ref([]);
const FormVisible = ref(false);

const showList = (customerInfo) => {
    FormVisible.value = true;
    cartItems.value = [];
    axios.get(route('client.cartItem.list', customerInfo.id))
        .then(response => {
            // Handle the JSON response data
            cartItems.value = response.data.results;
            // Use the data as needed
        })
        .catch(error => {
            // Handle any errors
        });
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
