<template>
    <Head title="Manage Product"/>
    <section class="product-select-container rounded border-solid border border-gray-300 " >
        <h3 class="p-2  border-b border-gray-300 font-bold text-xl text-lightBlue-600">Select Products
            <el-button type="success" @click="addProduct" :icon="Plus" circle />
        </h3>
        <div class="product-list p-2 h-[60vh] overflow-y-auto ">
            <el-row :gutter="10">
                <el-col :span="5">
                    Name
                </el-col>
                <el-col :span="5">
                    Combo
                </el-col>
                <el-col :span="3">
                    Rate
                </el-col>
                <el-col :span="3">
                    Quantity
                </el-col>
                <el-col :span="3">
                    Price
                </el-col>
                <el-col :span="3">
                </el-col>
            </el-row>
            <div v-for="(product, index) in products" :key="index">
            <ProductSelect
                v-model:product="products[index].product"
                v-model:productName="products[index].productName"
                v-model:quantity="products[index].quantity"
                v-model:price="products[index].price"
                v-model:combo="products[index].combo"
                v-model:rate="products[index].rate"
               @remove="removeProduct(index)"
                @addProduct="addProduct"
            />
            </div>
        </div>
    </section>
        <div class="mt-3">
            <el-button  type="primary" @click="proceedPayment" :icon="Check">Proceed</el-button>
        </div>
    <section>
        <el-row :gutter="10">
            <el-col :span="16">
                Total -
            </el-col>
            <el-col :span="8">
               Rs. {{totalPrice}}
            </el-col>
        </el-row>
        <el-row :gutter="10">
            <el-col :span="16">
                Discount -
            </el-col>
            <el-col :span="8">
                <input type="number" max="80" class="border border-gray-300 px-2 rounded w-10 text-right" placeholder="%" v-model="discount" /> %
            </el-col>
        </el-row>
        <el-row :gutter="10">
            <el-col :span="16">
                Final -
            </el-col>
            <el-col :span="8">
                Rs. {{finalPrice}}
            </el-col>
        </el-row>
    </section>
</template>

<script setup>import {
    Plus,Check
} from '@element-plus/icons-vue'
defineOptions({layout: "admin"});
import {Head} from "@inertiajs/vue3";
import ProductSelect from "./Components/ProcuctSelect.vue";
import {ref} from "vue";

const products = ref([
    {
        product:"",
        productName: "",
        combo: "",
        rate: "",
        quantity: 0,
        price: 0,
    }
]);
const addProduct = ()=> {
    products.value.push({
        product:"",
        productName: "",
        combo: "",
        rate: "",
        quantity: 0,
        price: 0,
    });
};
const totalPrice = ref(0);
const discount = ref(0);
const finalPrice = ref(0);
const removeProduct = (index) => {
    products.value.splice(index, 1);
};

const proceedPayment = () =>{
    totalPrice.value = 0;
    products.value.forEach(function(product){
        totalPrice.value = totalPrice.value + product.price
    })
    discount.value
    finalPrice.value = discount.value > 0 ? totalPrice.value - (discount.value/100)*totalPrice.value : totalPrice.value;
}
</script>

<style lang="scss" scoped>
.product-select-container
{
    h3{

    }
    .product-list{

    }
}
</style>
