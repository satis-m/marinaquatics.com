<template>
    <el-row :gutter="12">
        <el-col :sm="8">
            <el-card shadow="always" class="product-card dashboard-card">
                <div class="card-icon text-white">
                    <el-icon><Goods /></el-icon>
                </div>
                <div class="card-detail flex flex-col text-white" >
                    <div class="title">Products</div>
                    <div class="body">
                        <div class="flex">
                            <div class="w-20">In-Stock</div>  <div class="inline-block" style="width:100px">{{ iPropsValue('productCount','inStockCount') }}</div>
                        </div>
                        <div class="flex">
                            <div class="w-20">Out-Stock</div> <div class="inline-block">{{ iPropsValue('productCount','outStockCount') }}</div>
                        </div>
                    </div>
                </div>
            </el-card>
        </el-col><el-col :sm="8">
            <el-card shadow="always"  class="user-card dashboard-card">
                <div class="card-icon text-white">
                    <el-icon><Avatar /></el-icon>
                </div>
                <div class="card-detail flex flex-col text-white " >
                    <div class="title">Users</div>
                    <div class="body">110</div>
                </div>
            </el-card>
        </el-col><el-col :sm="8">
            <el-card shadow="always"  class="cash-card dashboard-card">
                <div class="card-icon text-white">
                    <el-icon><Coin /></el-icon>
                </div>
                <div class="card-detail flex flex-col text-white" >
                    <div class="title">Sells</div>
                    <div class="body">
                            <div class="flex">
                               <div class="w-20">Total</div>  <div class="inline-block" style="width:100px">1000</div>
                            </div>
                            <div class="flex">
                                <div class="w-20">Today</div> <div class="inline-block">100</div>
                            </div>
                    </div>
                </div>
            </el-card>
        </el-col>
    </el-row>
</template>
<script setup>
defineOptions({layout: "admin"});
import {Goods,Avatar,Coin} from "@element-plus/icons-vue";
import {useInertiaPropsUtility} from "@/Composables/inertiaPropsUtility";
let { iPropsValue } = useInertiaPropsUtility();
</script>
<style  lang="scss">
.dashboard-card
{
    height: 150px;
    color: #f1e8e8;
    &.product-card
    {
        background: #2d8dc2;
    }
    &.user-card
    {
        background: #9146c2;
    }
    &.cash-card
    {
        background: #4ea888;
    }

    .el-card__body
    {
        padding: 10px;
        height: 100%;
        display: flex;
        justify-content: space-between;
        .card-icon
        {
            font-size: 75px;
            align-items: center;
            display: flex;
        }
        .card-detail
        {
            min-width: 50%;
            .title{
                font-size: 2rem;
            }
            .body{
                font-size: 1rem;
            }
        }
    }
}

</style>
