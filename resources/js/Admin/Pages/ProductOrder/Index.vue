<template>
    <Head title="In-store sales"/>
    <el-row class="mb-3 justify-between" :gutter="20">
    <el-col :xs="12" :sm="12" :md="10">
        <el-row :gutter="20">
            <el-col :span="16"
            >
                <el-input
                    v-model="searchText"
                    placeholder="Type to search"
                    @input="searchFilter"
                    class="searchable"
                    clearable
                >
                    <template #prepend
                    >
                        <el-button :icon="Search"
                        />
                    </template>
                </el-input>
            </el-col>
        </el-row>
    </el-col>
    </el-row>

    <el-row :gutter="20">
        <el-col :span="24">
            <el-card>
                <el-table
                    id="printTable"
                    :data="filterDataList"
                    style="width: 100%"
                    ref="refTable"
                    table-layout="auto"
                    border
                    max-height="70vh"
                >
                    <el-table-column
                        type="index"
                        :index="indexMethod"
                        fixed="left"
                        width="50px"
                    />
                    <el-table-column
                        label="Order Number"
                        prop="order_no"
                    >
                        <template #default="props">
                            {{ props.row.order_no }}
                            <el-tag
                                v-if="props.row.order_status == 'cancelled'"
                                type="danger"
                                class="mx-1 flex-sra "
                                effect="dark"
                                round
                                size="small"
                            >
                                {{ props.row.order_status }}
                            </el-tag>
                            <el-tag
                                v-else-if="props.row.order_status == 'queue'"
                                type="warning"
                                class="mx-1 flex-sra "
                                effect="dark"
                                round
                                size="small"
                            >
                              {{ props.row.order_status }}
                            </el-tag>
                          <el-tag
                              v-else-if="props.row.order_status == 'delivered'"
                              type="success"
                              class="mx-1 flex-sra "
                              effect="dark"
                              round
                              size="small"
                          >
                            {{ props.row.order_status }}
                          </el-tag>

                        </template>
                    </el-table-column>
                    <el-table-column
                        label="Payment Method"
                        prop="payment_method"
                    >
                        <template #default="props">
                            {{ props.row.payment_method }}
                            <span v-if="props.row.payment_info != '' && props.row.payment_info != null">
                            ( {{ props.row.payment_info }} )
                            </span>
                        </template>
                    </el-table-column>
                    <el-table-column
                        label="Sub-Total Amount"
                        prop="subtotal_amount"
                    >
                        <template #default="props">
                            Rs. {{ props.row.subtotal_amount }}
                        </template>
                    </el-table-column>
                    <el-table-column
                        label="Discount"
                        prop="discount"
                        sortable
                    >
                        <template #default="props">
                            {{ props.row.discount }}%
                        </template>
                    </el-table-column>
                    <el-table-column
                        label="Total Amount"
                        prop="total_amount"
                    >
                        <template #default="props">
                            <span class="text-green-800 font-bold">Rs. {{ props.row.total_amount }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column
                        align="center"
                        fixed="right"
                        label="Action"
                        width="75px"
                    >
                        <template #default="scope">
                            <el-dropdown trigger="click">
                                    <span class="el-dropdown-link">
                                        <el-button
                                            type="primary"
                                            :plain="isDarkMode"
                                            :icon="MoreFilled"
                                            circle
                                        />
                                    </span>
                                <template #dropdown>
                                    <el-dropdown-menu>
                                        <el-dropdown-item
                                            @click="billPrint(scope.row)"
                                        >
                                            Bill Print
                                        </el-dropdown-item>
                                        <el-dropdown-item

                                            @click="showOrderItems(scope.row)"
                                        >
                                            View Items
                                        </el-dropdown-item>
                                        <el-dropdown-item
                                            divided
                                            @click="updateStatusForm(scope.row)"
                                        >
                                           Update Status
                                        </el-dropdown-item>
                                      <el-dropdown-item
                                          @click="updateStatusForm(scope.row)"
                                      >
                                        Cancel Order
                                      </el-dropdown-item>

                                    </el-dropdown-menu>
                                </template>
                            </el-dropdown>
                        </template>
                    </el-table-column>
                </el-table>
                <el-pagination
                    class="mt-5 !p-0"
                    v-model:currentPage="currentPage"
                    v-model:page-size="pageSize"
                    :total="totalSize"
                    :page-sizes="[100, 200, 300, 400]"
                    background
                    layout="total, sizes, prev, pager, next, jumper"
                    @size-change="changePageSize"
                    @current-change="changePage"
                />
            </el-card>
        </el-col>
    </el-row>

    <BillPrint ref="refBillPrint"/>
</template>

<script setup>
import {MoreFilled, Search} from "@element-plus/icons-vue";

defineOptions({layout: "admin"});

import {Head} from "@inertiajs/vue3";
import {onMounted, ref, watch} from "@vue/runtime-core";
import moment from "moment/moment.js";
import BillPrint from "./Components/BillPrint.vue";

//composable imports
import {useInertiaPropsUtility} from "@/Composables/inertiaPropsUtility";
import {useObjectUtility} from "@/Composables/objectUtility";
import {useAppUtility} from "@/Composables/appUtility";
import {useStringUtility} from "@/Composables/stringUtility";

const {iPropsValue} = useInertiaPropsUtility();
const {filterObjectWithGroupedValue} = useObjectUtility();
const {isScreenMd, isDarkMode} = useAppUtility();
const {readableWord} = useStringUtility();

const isMobile = ref(isScreenMd);
const refBillPrint = ref(null);
const printData = ref();
//table variables
const dateFormatter = (row, column) => moment(row.date).format("MMM Do, YYYY");
const currentPage = ref(1);
const pageSize = ref(100);
const totalSize = ref(0);
const refTable = ref(null);
const searchText = ref("");
const filterDataList = ref();
const indexMethod = (index) => (currentPage.value - 1) * pageSize.value + index + 1;
const dataList = ref(iPropsValue("orderList"));
const viewableColumn = ref(
    !isMobile.value
        ? ["order_no"]
        : ["order_no"]
);
watch(
    () => iPropsValue("orderList"),
    () => {
        dataList.value = iPropsValue("orderList");
        changePage(currentPage.value);
    }
);

const changePageSize = (val) => {
    pageSize.val = val;
    changePage();
};
const changePage = (val = 1) => {
    currentPage.value = val;
    const listStorage = dataList.value;
    // CHECK IF SEARCH EMPTY
    if (listStorage) {
        if (searchText.value == "") {
            totalSize.value = listStorage.length;
            const append = listStorage.slice(
                (currentPage.value - 1) * pageSize.value,
                (currentPage.value - 1) * pageSize.value + pageSize.value
            );
            filterDataList.value = append;
        } else {
            const filteredPosts = listStorage.filter((data) => {
                let hasValue = false;
                viewableColumn.value.forEach((value) => {
                    if (
                        data[value] &&
                        data[value]
                            .toString()
                            .toLowerCase()
                            .includes(searchText.value.toLowerCase())
                    )
                        hasValue = true;
                });
                return hasValue;
            });
            totalSize.value = filteredPosts.length;
            const append = filteredPosts.slice(
                (currentPage.value - 1) * pageSize.value,
                (currentPage.value - 1) * pageSize.value + pageSize.value
            );
            filterDataList.value = append;
        }
    }
};

const searchFilter = () => {
    currentPage.value = 1;
    const listStorage = dataList.value;

    const filteredPosts = listStorage.filter((data) => {
        let hasValue = false;
        viewableColumn.value.forEach((value) => {
            if (
                data[value] &&
                data[value]
                    .toString()
                    .toLowerCase()
                    .includes(searchText.value.toLowerCase())
            )
                hasValue = true;
        });
        return hasValue;
    });
    totalSize.value = filteredPosts.length;
    const append = filteredPosts.slice(
        (currentPage.value - 1) * pageSize.value,
        (currentPage.value - 1) * pageSize.value + pageSize.value
    );
    filterDataList.value = append;
};

const billPrint = (order)=>{
    refBillPrint.value.showBill(order);
}
const showOrderItems = (order)=>{

}
const updateStatusForm = (order)=>{

}
onMounted(() => {
    changePage();
});
</script>

<style lang="scss" scoped>

</style>
