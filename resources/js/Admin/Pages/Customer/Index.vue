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
                        label="Email"
                        prop="email"
                    >
                        <template #default="props">
                            {{ props.row.email }}

                        </template>
                    </el-table-column>
                    <el-table-column
                        label="Customer Name"
                        prop="name"
                    >
                        <template #default="props">
                            {{ props.row.name }}

                        </template>
                    </el-table-column>

                    <el-table-column
                        label="Status"
                        prop="status"
                    >
                        <template #default="props">
                            <el-tag
                                v-if="props.row.status == 'active'"
                                type="success"
                                class="mx-1"
                                effect="dark"
                                round
                                size="small"
                            >
                                {{ props.row.status }}
                            </el-tag>
                            <el-tag
                                v-else
                                type="danger"
                                class="mx-1"
                                effect="dark"
                                round
                                size="small"
                            >
                                {{ props.row.status }}
                            </el-tag>

                        </template>
                    </el-table-column>
                    <el-table-column
                        label="Cancelled Order"
                        prop="cancelled_order"
                    >
                        <template #default="props">
                            <el-tag
                                type="danger"
                                class="mx-1"
                                effect="dark"
                                round
                                size="small"
                            >
                                {{ props.row.cancelled_order }}
                            </el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column
                        label="Total Ordered Amount"
                        prop="total_ordered_amount"
                    >
                        <template #default="props">
                            <span class="text-green-800 font-bold">{{
                                    formattedCurrency(props.row.orders_sum_total_amount)
                                }}</span>
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
                                            @click="listCartItems(scope.row)"
                                        >
                                            Cart Products
                                        </el-dropdown-item>
                                        <el-dropdown-item
                                            @click="listOrdered(scope.row)"
                                        >
                                            Ordered Products
                                        </el-dropdown-item>
                                        <el-dropdown-item
                                            v-if="scope.row.status=='active'"
                                            @click="updateAccount(scope.row,'block')"
                                        >
                                            Block Account
                                        </el-dropdown-item>
                                        <el-dropdown-item
                                            v-else
                                            @click="updateAccount(scope.row,'active')"
                                        >
                                            Activate Account
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
    <OrderedProductList ref="refOrderedProductList"></OrderedProductList>
    <CartProductList ref="refCartProductList"></CartProductList>
</template>

<script setup>
import {Delete, MoreFilled, Search} from "@element-plus/icons-vue";

defineOptions({layout: "admin"});

import {Head, useForm} from "@inertiajs/vue3";
import {markRaw, onMounted, ref, watch} from "@vue/runtime-core";
import moment from "moment/moment.js";

//composable imports
import {useInertiaPropsUtility} from "@/Composables/inertiaPropsUtility";
import {useObjectUtility} from "@/Composables/objectUtility";
import {useAppUtility} from "@/Composables/appUtility";
import {useStringUtility} from "@/Composables/stringUtility";
import {useNumberUtility} from "@/Composables/numberUtility";
import OrderedProductList from "./Components/OrderedProductList.vue";
import CartProductList from "./Components/CartProductList.vue";

const {formattedCurrency} = useNumberUtility();
const {iPropsValue} = useInertiaPropsUtility();
const {filterObjectWithGroupedValue} = useObjectUtility();
const {isScreenMd, isDarkMode} = useAppUtility();
const {readableWord} = useStringUtility();
const isMobile = ref(isScreenMd);
const refOrderedProductList = ref(null);
const refCartProductList = ref(null);
//table variables
const dateFormatter = (row, column) => moment(row.date).format("MMM Do, YYYY");
const currentPage = ref(1);
const pageSize = ref(100);
const totalSize = ref(0);
const refTable = ref(null);
const searchText = ref("");
const filterDataList = ref();
const indexMethod = (index) => (currentPage.value - 1) * pageSize.value + index + 1;
const dataList = ref(iPropsValue("customerList"));
const viewableColumn = ref(
    !isMobile.value
        ? ["order_no"]
        : ["order_no"]
);

watch(
    () => iPropsValue("customerList"),
    () => {
        dataList.value = iPropsValue("customerList");
       // console.log(dataList);
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

const updateAccount = (accountInfo, status) => {
    ElMessageBox.confirm("Update Account Status", "Warning", {
        type: "error",
        dangerouslyUseHTMLString: true,
        icon: markRaw(Delete),
        callback: (action) => {
            if (action == "confirm") {
                const formData = useForm({'status': status});
                formData.patch(route("client.status.update", accountInfo.id), {
                    preserveScroll: true,
                    onSuccess: () => {
                        formData.reset();
                    },
                });
            }
        },
    });
}
const listOrdered = (customerInfo) => {
    refOrderedProductList.value.showList(customerInfo)
}
const listCartItems = (customerInfo) => {
    refCartProductList.value.showList(customerInfo)
}
onMounted(() => {
    changePage();
});
</script>

<style lang="scss" scoped>

</style>
