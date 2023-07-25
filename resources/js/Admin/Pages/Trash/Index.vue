<template>
    <el-tabs v-model="activeName" class="demo-tabs" @tab-click="handleClick">
        <el-tab-pane label="Product" name="product">
            <ProductList/>
        </el-tab-pane>
    </el-tabs>
</template>
<script setup>
import ProductList from "./Components/ProductList.vue";

defineOptions({layout: "admin"});
import {ref} from "@vue/runtime-core";

const activeName = ref('product')
const handleClick = (tab, event) => {
    // console.log(tab, event)
}
</script>
