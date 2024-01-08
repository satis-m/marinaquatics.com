<template>
    <Head title="Manage Product"/>
    <div>
        <AddEditForm
            ref="refAddEditForm"
            :parentFormInput="formInputNames"
        />
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
                    <el-col :span="8">
                        <el-button-group>
                            <el-tooltip
                                v-if="iPropsValue('userCan', 'create')"
                                class="box-item"
                                effect="dark"
                                content="Add "
                                placement="bottom"
                            >
                                <el-button
                                    :plain="isDarkMode"
                                    type="success"
                                    size="default"
                                    rounded
                                    @click="addForm"
                                    :icon="Plus"
                                >
                                </el-button>
                            </el-tooltip>
                        </el-button-group>
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
                        <el-table-column v-if="isScreenMd" type="expand">
                            <template #default="props">
                                <div class="ml-28">
                                    <p class="mb-2">
                                        Product Name: {{ props.row.name }}
                                    </p>
                                    <p class="mb-2">
                                        Price: Rs. {{ props.row.price }}
                                    </p>
                                    <p class="mb-2">
                                        In Stock: Rs. {{ props.row.available_quantity }}
                                    </p>
                                    <p class="mb-2">
                                        Brand: {{ props.row.brand }}
                                    </p>
                                    <p class="mb-2">
                                        status:  <StatusBadge :type="props.row.publish ? 'success': 'danger'">
                                        {{ props.row.publish ? 'published' : 'unpublished' }}
                                    </StatusBadge>
                                    </p>
                                    <p class="mb-2">
                                        tags:
                                        <el-tag
                                            v-for="(item ,key) in props.row.tag"
                                            :key="key"
                                            type="info"
                                            class="mx-1"
                                            effect="dark"
                                            round
                                        >
                                            {{ item }}
                                        </el-tag>
                                    </p>
                                </div>
                            </template>
                        </el-table-column>
                        <el-table-column
                            type="index"
                            :index="indexMethod"
                            fixed="left"
                            width="50px"
                        />
                        <el-table-column
                            label="Picture"
                            prop="main_picture"
                            v-if="isViewableColumn('main_picture')"
                            width="150px"
                            align="center"
                        >
                            <template #default="props">
                                <div class="">
                                    <el-image
                                        :preview-teleported="true"
                                        style="width: 100px; height: 100px"
                                        :src="props.row.main_picture?.thumbnail"
                                        :zoom-rate="1.2"
                                        :preview-src-list="getSrcList(props.row)"
                                        :initial-index="4"
                                        fit="cover"
                                        :lazy="true"
                                        :hide-on-click-modal="true"
                                        alt="product images"
                                    >
                                        <template #error>
                                            <div class="image-slot">
                                                <img
                                                    src="/admin-site/blank_image_2.svg"
                                                />
                                            </div>
                                        </template>
                                    </el-image>
                                </div>
                            </template>
                        </el-table-column>

                        <el-table-column
                            :label="tableColumnNames.title"
                            sortable
                            prop="title"
                            v-if="isViewableColumn('title')"
                        />
                        <el-table-column
                            :label="tableColumnNames.body"
                            v-if="isViewableColumn('body')"
                            prop="body"
                        />
                        <el-table-column
                            :label="tableColumnNames.tag"
                            v-if="isViewableColumn('tag')"
                            prop="tag"
                        >
                            <template #default="props">
                                <el-tag
                                    v-for="(item ,key) in props.row.tag"
                                    :key="key"
                                    type="info"
                                    class="mx-1"
                                    effect="dark"
                                    round
                                >
                                    {{ item }}
                                </el-tag>
                            </template>
                        </el-table-column>
                        <el-table-column
                            :label="tableColumnNames.publish"
                            v-if="isViewableColumn('publish')"
                            :filters="[
                                { text: 'published', value: 'published' },
                                { text: 'unpublished', value: 'unpublished' },
                            ]"
                            :filter-method="filterStatus"
                            filter-placement="bottom-end"
                        >
                            <template #default="props">
                                <StatusBadge :type="props.row.publish ? 'success': 'danger'">
                                    {{ props.row.publish ? 'published' : 'unpublished' }}
                                </StatusBadge>
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
                                                divided
                                                @click="previewBlog(scope.row)"
                                            >Preview
                                            </el-dropdown-item
                                            >
                                            <el-dropdown-item
                                                @click="editForm(scope.row)"
                                            >Edit
                                            </el-dropdown-item
                                            >
                                            <el-dropdown-item
                                                @click="deleteForm(scope.row)"
                                            >Delete
                                            </el-dropdown-item
                                            >
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
    </div>
</template>
<script setup>
defineOptions({layout: "admin"});
import {Head, useForm} from "@inertiajs/vue3";
//composable imports
import {useInertiaPropsUtility} from "@/Composables/inertiaPropsUtility";
import {useObjectUtility} from "@/Composables/objectUtility";
import {useAppUtility} from "@/Composables/appUtility";
import {useStringUtility} from "@/Composables/stringUtility";
//library imports
import {
    markRaw,
    onMounted,
    reactive,
    watch,
    ref,
    inject,
} from "@vue/runtime-core";
//Component imports
import AddEditForm from "./Components/AddEditForm.vue";
import StatusBadge from "@/Components/StatusBadge.vue";

import moment from "moment";
import {
    Plus,
    Delete,
    Refresh,
    Search,
    Switch,
    DocumentAdd,
    MoreFilled,
} from "@element-plus/icons-vue";

//composable function import
const {iPropsValue} = useInertiaPropsUtility();
const {filterObjectWithGroupedValue} = useObjectUtility();
const {isScreenMd, isDarkMode} = useAppUtility();
const {readableWord} = useStringUtility();
//variable declare
const isMobile = ref(isScreenMd);
const refAddEditForm = ref(null);
const refUpdateStockForm = ref(null);
const refComboOfferForm = ref(null);
const refDiscountForm = ref(null);
const refAddByExcelForm = ref(null);
const exportLoading = ref(false);
const viewableColumn = ref(
    !isMobile.value
        ? ["title", "body", "tag", 'publish']
        : ["title", 'tag']
);
watch(
    () => isMobile.value,
    () => {
        viewableColumn.value = !isMobile.value
            ? ["title", "body", "tag", 'publish']
            : ["title", 'tag']
    }
);
const tableColumnNames = {
    title: "Title",
    body: "Description",
    tag: "Tag",
    publish: "Status",
};
const exportTableOption = reactive({
    header: [
        "Title",
        "Body",
        "Tag",
        "Status"
    ],
    headerValue: [

        "title",
        "body",
        "tag",
        'publish'
    ],
    fileName: "blogList",
});
const formInputNames = {
    title: "",
    body: "",
    tag: "",
    publish: 1,
};
const addForm = () => refAddEditForm.value.showForm("Add");
const editForm = (data) => refAddEditForm.value.showForm("Edit", data);
const filterStatus = (value, row) => {
    if (value == "published") {
        return row.publish;
    } else {
        return !row.publish;
    }
};
const deleteForm = (data) => {
    ElMessageBox.confirm("Move to trash, You can restore from trash. Continue?", "Warning", {
        type: "warning",
        icon: markRaw(Delete),
        callback: (action) => {
            if (action == "confirm") {
                const formData = useForm({});
                formData.delete(route("manageBlog.destroy", data.id), {
                    preserveScroll: true,
                    onSuccess: () => {
                        formData.reset();
                    },
                });
            }
        },
    });
    return;
};
const getFilterKey = (columnKey) => {
    const filteredValues = filterObjectWithGroupedValue(dataList, columnKey);
    let filterKey = [];
    filteredValues.forEach((item, index) => {
        filterKey[index] = {text: item, value: item};
    });
    return filterKey
}
const dateFormatter = (row, column) => moment(row.date).format("MMM Do, YYYY");
//table pagination / search related
const currentPage = ref(1);
const pageSize = ref(100);
const totalSize = ref(0);
const refTable = ref(null);
const searchText = ref("");
const filterDataList = ref();
const indexMethod = (index) => (currentPage.value - 1) * pageSize.value + index + 1;
const isViewableColumn = (columnName) => viewableColumn.value.includes(columnName);
const dataList = ref(iPropsValue("blogList"));
watch(
    () => iPropsValue("blogList"),
    () => {
        dataList.value = iPropsValue("blogList");
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
const getSrcList = (row) => {
    let srclist = [];
    if (row.main_picture) {
        srclist.push(row.main_picture.original)
    }
    if (row.alternative_picture) {
        row.alternative_picture.forEach((data) => {
            srclist.push(data.original);
        })
    }
    return srclist;

}
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
const previewBlog = (blogInfo) => {
    window.open(
        route('blog.view',blogInfo.slug), "_blank");
}
//page event cycle
onMounted(() => {
    changePage();
});
</script>

