<template>
    <el-row :gutter="12">
        <el-col :sm="24" :md="12" :lg="8" :xl="6">
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
        </el-col>
        <el-col :sm="24" :md="12" :lg="8" :xl="6">
            <el-card shadow="always"  class="user-card dashboard-card">
                <div class="card-icon text-white">
                    <el-icon><Avatar /></el-icon>
                </div>
                <div class="card-detail flex flex-col text-white " >
                    <div class="title">Users Account</div>
                    <div class="body">
                      <div class="flex">
                        <div class="w-28">Active</div>
                        <div>{{ iPropsValue('userCount','active') }}</div>
                      </div>
                      <div class="flex">
                        <div class="w-28">Blocked</div>
                        <div>{{ iPropsValue('userCount','block') > 0 ? iPropsValue('userCount','block') : 0 }}</div>
                      </div>
                    </div>
                </div>
            </el-card>
        </el-col>
        <el-col :sm="24" :md="12" :lg="8" :xl="6">
            <el-card shadow="always"  class="cash-card dashboard-card">
                <div class="card-icon text-white">
                    <el-icon><Coin /></el-icon>
                </div>
                <div class="card-detail flex flex-col text-white" >
                    <div class="title">Sells</div>
                    <div class="body">
                            <div class="flex">
                               <div class="w-28">Total</div>
                              <div>{{ formattedCurrency(iPropsValue('sales','till_date_total')) }}</div>
                            </div>
                            <div class="flex">
                               <div class="w-28"> {{ iPropsValue('sales','current_month') }} </div>
                              <div>{{ formattedCurrency(iPropsValue('sales','monthly_total')) }}</div>
                            </div>
                            <div class="flex">
                                <div class="w-28">Today</div>
                              <div>{{ formattedCurrency(iPropsValue('sales','today_total')) }}</div>
                            </div>
                    </div>
                </div>
            </el-card>
        </el-col>
        <el-col :sm="24" :md="12" :lg="8" :xl="6">
            <el-card shadow="always"  class="order-card dashboard-card">
                <div class="card-icon text-white">
                    <el-icon><ShoppingCartFull /></el-icon>
                </div>
                <div class="card-detail flex flex-col text-white" >
                    <div class="title">Orders</div>
                    <div class="body">
                        <div class="flex">
                            <div class="w-28">Total</div>
                            <div>{{ iPropsValue('orders','till_date_total') }}</div>
                        </div>
                        <div class="flex">
                            <div class="w-28"> {{ iPropsValue('orders','current_month') }} </div>
                            <div>{{ iPropsValue('orders','monthly_total') }}</div>
                        </div>
                        <div class="flex">
                            <div class="w-28">Today</div>
                            <div>{{ iPropsValue('orders','today_total') }}</div>
                        </div>
                    </div>
                </div>
            </el-card>
        </el-col>
    </el-row>
</template>
<script setup>
defineOptions({layout: "admin"});
import {Goods,Avatar,Coin,ShoppingCartFull} from "@element-plus/icons-vue";
import {useInertiaPropsUtility} from "@/Composables/inertiaPropsUtility";
let { iPropsValue } = useInertiaPropsUtility();

import {useNumberUtility} from "@/Composables/numberUtility";
const {formattedCurrency} = useNumberUtility();

</script>
<style  lang="scss">
.dashboard-card
{
    height: 100%;
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
    &.order-card{
        background: #ddb94e;
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
