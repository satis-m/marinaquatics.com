<template>
  <Head title="Manage HomePage Sliders"/>
  <div>
    <EditBannerForm
        ref="refUpdateBannerForm"
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
                :label="tableColumnNames.file_path"
                v-if="isViewableColumn('file_path')"
                width="150px"
                align="center"
            >
              <template #default="props">
                <div class="">
                  <el-image
                      v-if="props.row.type=='image'"
                      :preview-teleported="true"
                      style="width: 100px; height: 100px"
                      :src="props.row.file_path"
                      :zoom-rate="1.2"
                      :preview-src-list="[props.row.file_path]"
                      :initial-index="4"
                      fit="cover"
                      :lazy="true"
                      :hide-on-click-modal="true"
                      alt="Banner File"
                  >
                    <template #error>
                      <div class="image-slot">
                        <img
                            src="/admin-site/blank_image_2.svg"
                        />
                      </div>
                    </template>
                  </el-image>
                  <template v-else>
                    <div class="cursor-pointer image-slot" @click="showVideo(props.row.file_path)">
                      <img
                          :src="props.row.alt_image"
                      />
                    </div>
                  </template>
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
                :label="tableColumnNames.type"
                sortable
                prop="type"
                v-if="isViewableColumn('type')"
            >
              <template #default="props">
                <el-tag
                    class="mx-1"
                    effect="dark"
                    round
                >
                  {{ props.row.type }}
                </el-tag>
              </template>
            </el-table-column>

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
                <el-button type="primary" @click="showUpdateSliderForm(scope.row)" :icon="Edit" circle/>
              </template>
            </el-table-column>
          </el-table>
        </el-card>
      </el-col>
    </el-row>
  </div>
    <BannerVideo ref="refBannerVideo" />
</template>

<script setup>
defineOptions({layout: "admin"});

import EditBannerForm from "./Components/EditBannerForm.vue";
import BannerVideo from "./Components/BannerVideo.vue";
import {ref, watch} from "@vue/runtime-core";
import {Head, useForm} from "@inertiajs/vue3";
import {
  Edit
} from "@element-plus/icons-vue";

import {useInertiaPropsUtility} from "@/Composables/inertiaPropsUtility";

const {iPropsValue} = useInertiaPropsUtility();

const viewableColumn = ref(["file_path", "title", 'type', "detail", 'link', 'publish']);

const tableColumnNames = {
  title: "Title",
  type: "Type",
  file_path: "File",
  detail: "Detail",
  link: "Link",
  publish: "Status",
};

//table pagination / search related
const currentPage = ref(1);
const pageSize = ref(100);
const refTable = ref(null);
const refUpdateBannerForm = ref(null);
const refBannerVideo = ref(null);
const indexMethod = (index) => (currentPage.value - 1) * pageSize.value + index + 1;
const isViewableColumn = (columnName) => viewableColumn.value.includes(columnName);

const dataList = ref(iPropsValue("banners"));
watch(
    () => iPropsValue("banners"),
    () => {
      dataList.value = iPropsValue("banners");
    }
);

const showUpdateSliderForm = (data) => refUpdateBannerForm.value.showForm(data);

const showVideo = (filePath) => refBannerVideo.value.showForm(filePath);
</script>

<style lang="scss" scoped>

</style>
