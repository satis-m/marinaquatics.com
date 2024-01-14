<template>
    <el-row :gutter="20">
        <el-col :span="24">
            <el-card>
                <el-table
                    id="printTable"
                    :data="dataList"
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
                        :label="tableColumnNames.category"
                        v-if="isViewableColumn('category')"
                        prop="category"
                    >
                        <template #default="props">
                            {{ props.row.category?.name }} => {{ props.row.category?.sub_category }}
                        </template>
                    </el-table-column>
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
                        :label="tableColumnNames.price"
                        v-if="isViewableColumn('price')"
                        sortable
                        prop="price"
                    >
                        <template #default="props">
                            Rs. {{ props.row.price }}
                        </template>
                    </el-table-column>
                    <el-table-column
                        :label="tableColumnNames.available_quantity"
                        v-if="isViewableColumn('available_quantity')"
                        prop="available_quantity"
                    >
                        <template #default="props">
                            {{ props.row.available_quantity }} ({{ props.row.unit }})
                        </template>
                    </el-table-column>
                    <el-table-column
                        :label="tableColumnNames.publish"
                        v-if="isViewableColumn('publish')"
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
                                            @click="handleRestore(scope.row)"
                                        >
                                            Restore
                                        </el-dropdown-item>
                                        <el-dropdown-item

                                            @click="handleDelete(scope.row)"
                                        >
                                            Delete
                                        </el-dropdown-item>
                                    </el-dropdown-menu>
                                </template>
                            </el-dropdown>
                        </template>
                    </el-table-column>
                </el-table>
            </el-card>
        </el-col>
    </el-row>

</template>
<script setup>
import {Delete, MoreFilled,RefreshLeft} from "@element-plus/icons-vue";
import {markRaw, ref, watch} from "@vue/runtime-core";
import {useInertiaPropsUtility} from "@/Composables/inertiaPropsUtility";
import {useAppUtility} from "@/Composables/appUtility";
import StatusBadge from "@/Components/StatusBadge.vue";
import {useForm} from "@inertiajs/vue3";
const {isScreenMd, isDarkMode} = useAppUtility();
//variable declare
const refTable = ref(null);
const isMobile = ref(isScreenMd);
let { iPropsValue } = useInertiaPropsUtility();

const indexMethod = (index) => (1 - 1) * 1000 + index + 1;
const isViewableColumn = (columnName) => viewableColumn.value.includes(columnName);
const viewableColumn = ref(
    !isMobile.value
        ? ["title","tag", 'category', 'main_picture', 'body', 'publish']
        : ["title", 'main_picture']
);
watch(
    () => isMobile.value,
    () => {
        viewableColumn.value = !isMobile.value
            ? ["title","tag", 'category', 'main_picture', 'body', 'publish']
            : ["title", 'main_picture']
    }
);
const tableColumnNames = {
    title: "Title",
    body: "Body",
    tag: "Tag",
    category: "Category",
    publish: "Status",
};
const dataList = ref(iPropsValue("trashBlog"));

watch(
    () => iPropsValue("trashBlog"),
    () => {
        dataList.value = iPropsValue("trashBlog");
    }
);
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

const handleRestore = (data)=>{
    ElMessageBox.confirm("It will restore product. Continue?", "Warning", {
        type: "warning",
        icon: markRaw(RefreshLeft),
        callback: (action) => {
            if (action == "confirm") {
                const formData = useForm({});
                formData.patch(route("trash.blog.restore", data.id), {
                    preserveScroll: true,
                    onSuccess: () => {
                        formData.reset();
                    },
                });
            }
        },
    });
    return;
}
const handleDelete =  (data) => {
    ElMessageBox.confirm("It will permanently delete. Continue?", "Danger", {
        type: "error",
        icon: markRaw(Delete),
        callback: (action) => {
            if (action == "confirm") {
                const formData = useForm({});
                formData.delete(route("trash.blog.destroy", data.id), {
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

</script>
