<template>
    <div class="el-form el-form--default el-form--label-top ">
        <el-row :gutter="10">
            <el-col :span="5">
                <el-form-item label="">
                    <el-select
                        placeholder="Name"
                        v-model="selectedProduct"
                        @change="selectProduct"
                    >
                        <el-option v-for="(product, key) in products" :disabled="product.available_quantity == 0" :key="key" :label="product.name" :value="product" :value-key="product.name">
                            <span style="float: left">{{ product.name }}</span>
                            <span
                                style=" float: right;
                                          color: var(--el-text-color-secondary);
                                          font-size: 13px;
                                        "
                            >{{ product.available_quantity }}</span
                            >
                        </el-option>

                    </el-select>
                </el-form-item>
            </el-col>
            <el-col :span="5">
                <el-form-item label="">
                    <el-select
                        placeholder="Offer"
                        v-model="comboIndex"
                        @change="offerChange"
                    >
                            <template v-if="comboOffers != ''" v-for="index in 3" :key="index" >
                                <el-option
                                    v-if="comboOffers['name_'+index] != null && comboOffers['name_'+index] != ''"
                                    :disabled="availableQuantity >= comboOffers['quantity_'+index] ? false:true"
                                    :value="index"
                                    :label="comboOffers['name_'+index]"
                                />
                            </template>
                    </el-select>
                </el-form-item>
            </el-col>
            <el-col :span="3">
                <el-form-item label="">
                    <el-input placeholder="Approved by" @keydown.enter.shift.prevent="handleShiftEnter" v-model="rate" disabled/>
                </el-form-item>
            </el-col>
            <el-col :span="3">
                <el-form-item label="">
                    <el-input-number v-model="quantity" @keydown.enter.shift.prevent="handleShiftEnter" :min="1" :max="maxQuantity" @keyup="updatePrice" @change="updatePrice" />
                </el-form-item>
            </el-col>
            <el-col :span="3">
                <el-form-item label="">
                    <el-input placeholder="price" @keydown.enter.shift.prevent="handleShiftEnter" v-model="price" disabled/>
                </el-form-item>
            </el-col>
            <el-col :span="1">
                <el-button type="danger" @keydown.enter.shift.prevent="handleShiftEnter" @click="removeProduct" size="small" :icon="Close" circle/>
            </el-col>
        </el-row>
    </div>
</template>

<script setup>
import {ref, defineProps, defineEmits, watch} from 'vue';
import {Close, Plus} from "@element-plus/icons-vue";
import {useInertiaPropsUtility} from "@/Composables/inertiaPropsUtility";

const {iPropsValue} = useInertiaPropsUtility();
const {
    productName: propProductName,
    product: propProduct,
    quantity: propQuantity,
    price: propPrice,
    rate: propRate,
    combo: propCombo
} = defineProps(['productName', 'quantity', 'price', 'rate', 'combo', 'product']);
const emit = defineEmits();


const products = ref(iPropsValue('products'));
const product = ref(propProduct || '');
const productName = ref(propProductName || '');
const quantity = ref(propQuantity || 0);
const price = ref(propPrice || 0);
const combo = ref(propCombo || '');
const rate = ref(propRate || 0);

const selectedProduct = ref('');
const comboOffers = ref('');
const comboIndex = ref('');
const availableQuantity = ref();
const maxQuantity = ref();
watch([product, productName, rate, combo, quantity, price], () => {
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
const selectProduct = ( productInfo)=>{
    productName.value = productInfo.name
    product.value = productInfo.slug
    comboOffers.value = productInfo.combo_offer
    comboIndex.value = 1
    availableQuantity.value = productInfo.available_quantity
    combo.value =  comboOffers.value['name_1']
    rate.value = comboOffers.value['price_1']
    setMaxQuantity();
    updatePrice();
    // console.log(productInfo)
    // console.log(availableQuantity.value)
}

const offerChange = (offerKey) => {
    combo.value =  comboOffers.value['name_'+offerKey]
    rate.value = comboOffers.value['price_'+offerKey]
    updatePrice()
}

const updatePrice = ()=>{
    if(rate.value > 0)
    {
    setMaxQuantity()
    price.value =  rate.value * (quantity.value * comboOffers.value['quantity_'+comboIndex.value])
    }
}
const setMaxQuantity = ()=>{
    maxQuantity.value = Math.floor((availableQuantity.value / comboOffers.value['quantity_'+comboIndex.value]));
}

const handleShiftEnter = function(){
    emit('addProduct');
}
</script>

<style lang="scss" scoped>

</style>
