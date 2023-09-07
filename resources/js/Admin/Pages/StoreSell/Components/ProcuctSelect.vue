<template>
    <div class="el-form el-form--default el-form--label-top ">
        <el-row :gutter="10">
            <el-col :span="5">
                <el-form-item label="">
                    <el-input placeholder="name" v-model="productName"  />
                </el-form-item>
            </el-col>
            <el-col :span="5">
                <el-form-item label="">
                    <el-select
                        placeholder="Activity zone"

                        v-model="combo"
                    >
                        <el-option label="Zone one" value="shanghai" />
                        <el-option label="Zone two" value="beijing" />
                    </el-select>
                </el-form-item>
            </el-col>
            <el-col :span="3">
                <el-form-item label="">
                    <el-input placeholder="Approved by" v-model="rate" disabled  />
                </el-form-item>
            </el-col>
            <el-col :span="3">
                <el-form-item label="">
                    <el-input placeholder="quantity"  v-model="quantity"   />
                </el-form-item>
            </el-col>
            <el-col :span="3">
                <el-form-item label="">
                    <el-input placeholder="price"  v-model="price" disabled   />
                </el-form-item>
            </el-col>
            <el-col :span="1">
                <el-button type="danger" @click="removeProduct" size="small" :icon="Close" circle />
            </el-col>
        </el-row>
    </div>
</template>

<script setup>
import { ref, defineProps, defineEmits,watch } from 'vue';
import {Close, Plus} from "@element-plus/icons-vue";
const {
    productName: propProductName,
    product: propProduct,
    quantity: propQuantity,
    price: propPrice,
    rate: propRate,
    combo: propCombo
} = defineProps(['productName', 'quantity', 'price','rate','combo','product']);
const emit = defineEmits();

const product = ref(propProduct || '');
const productName = ref(propProductName || '');
const quantity = ref(propQuantity || 0);
const price = ref(propPrice || 0);
const combo = ref(propCombo || 0);
const rate = ref(propRate || 0);

watch([product,productName,rate,combo, quantity, price], () => {
    emit('update:product', product.value);
    emit('update:productName', productName.value);
    emit('update:quantity', quantity.value);
    emit('update:price', price.value);
    emit('update:rate', rate.value);
    emit('update:combo', combo.value);
});


const removeProduct = () => {
    emit('remove');
};

</script>

<style lang="scss" scoped>

</style>
