<template>
    <Head title="Manage Product"/>
    <section class="product-select-container rounded border-solid border border-gray-500 " >
        <h3 class="p-2  border-b border-gray-500 font-bold text-xl text-lightBlue-600">Select Products
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
               @remove="removeProduct(index)"/>
            </div>
        </div>
        <div>
            <el-button  type="primary" @click="proceedPayment" :icon="Check">Proceed</el-button>
        </div>
    </section>
    <section>
        <div>total</div>
        <div>discount</div>
        <div>final</div>
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
const removeProduct = (index) => {
    products.value.splice(index, 1);
};

const proceedPayment = () =>{
    console.log(products.value)
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
