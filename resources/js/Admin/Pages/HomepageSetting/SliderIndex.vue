<template>
    <Head title="Manage HomePage Sliders"/>
    <div>
        <EditSliderForm
            ref="refUpdateSliderForm"
        />

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
                        <el-table-column
                            type="index"
                            :index="indexMethod"
                            fixed="left"
                            width="50px"
                        />
                        <el-table-column
                            :label="tableColumnNames.image"
                            prop="main_picture"
                            v-if="isViewableColumn('image')"
                            width="150px"
                            align="center"
                        >
                            <template #default="props">
                                <div class="">
                                    <el-image
                                        :preview-teleported="true"
                                        style="width: 100px; height: 100px"
                                        :src="props.row.image"
                                        :zoom-rate="1.2"
                                        :preview-src-list="[props.row.image]"
                                        :initial-index="4"
                                        fit="cover"
                                        :lazy="true"
                                        :hide-on-click-modal="true"
                                        alt="slider images"
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
                            :label="tableColumnNames.detail"
                            v-if="isViewableColumn('detail')"
                            prop="detail"
                        />
                        <el-table-column
                            :label="tableColumnNames.link"
                            v-if="isViewableColumn('link')"
                            prop="link"
                        />
                        <el-table-column
                            :label="tableColumnNames.publish"
                            v-if="isViewableColumn('publish')"
                            prop="publish"
                        >
                          <template #default="props">
                            <el-tag
                                :type="props.row.publish ? 'success':'info'"
                                class="mx-1"
                                effect="dark"
                                round
                            >
                              {{ props.row.publish ? 'Published' : 'Un-Published' }}
                            </el-tag>
                          </template>
                        </el-table-column>
                        <el-table-column
                            label="Action"
                            align="center"
                            fixed="right"
                            width="75px"
                        >
                            <template #default="scope">
                                <el-button type="primary" @click="showUpdateSliderForm(scope.row)" :icon="Edit" circle />
                            </template>
                        </el-table-column>
                    </el-table>
                </el-card>
            </el-col>
        </el-row>
    </div>
</template>

<script setup>
defineOptions({layout: "admin"});

import EditSliderForm from "./Components/EditSliderForm.vue";
import {ref, watch} from "@vue/runtime-core";
import {Head, useForm} from "@inertiajs/vue3";
import {
    Edit
} from "@element-plus/icons-vue";

import {useInertiaPropsUtility} from "@/Composables/inertiaPropsUtility";
const {iPropsValue} = useInertiaPropsUtility();

const viewableColumn = ref(["image", "title", "detail", 'link','publish']);

const tableColumnNames = {
    title: "Title",
    image: "Image",
    detail: "Detail",
    link: "Link",
    publish: "Status",
};

//table pagination / search related
const currentPage = ref(1);
const pageSize = ref(100);
const refTable = ref(null);
const refUpdateSliderForm = ref(null);
const indexMethod = (index) => (currentPage.value - 1) * pageSize.value + index + 1;
const isViewableColumn = (columnName) => viewableColumn.value.includes(columnName);

const dataList = ref(iPropsValue("sliders"));
watch(
    () => iPropsValue("sliders"),
    () => {
        dataList.value = iPropsValue("sliders");
    }
);

const showUpdateSliderForm = (data) => refUpdateSliderForm.value.showForm(data);
</script>

<style lang="scss" scoped>

</style>
