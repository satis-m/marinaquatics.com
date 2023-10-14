<template>
  <el-dialog
      v-model="FormVisible"
      :before-close="closeForm"
      title="Update Banner"
      :fullscreen="false"
  >
    <template #default>
      <el-form
          @submit.prevent
          :model="formData"
          ref="refForm"
          label-position="top"
          :scroll-to-error="true"
          status-icon
      >
        <el-row :gutter="10">
          <el-col :lg="6">
            <el-form-item
                label="Title"
                prop="title"
            >
              <el-input
                  v-model="formData.title"
                  placeholder="Slider Title"
                  autocomplete="off"
              />
            </el-form-item>
          </el-col>
          <el-col :lg="6">
            <el-form-item
                label="Detail"
                prop="detail"
            >
              <el-input
                  v-model="formData.detail"
                  placeholder="Slider Detail"
                  autocomplete="off"
              />
            </el-form-item>
          </el-col>
          <el-col :lg="6">
            <el-form-item
                label="Link"
                prop="link"
            >
              <el-input
                  v-model="formData.link"
                  placeholder="Slider Link"
                  autocomplete="off"
              />
            </el-form-item>
          </el-col>
          <el-col :lg="6">
            <el-form-item
                label="Publish"
                prop="publish"
            >
              <el-switch v-model="formData.publish" :active-value="1" :inactive-value="0" active-text="Publish"
                         inactive-text="Un-Publish"/>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row :gutter="10">
          <el-col :lg="6">
            <el-form-item
                label="Publish"
                prop="publish"
            >
              <el-select v-model="formData.type" placeholder="Select">
                <el-option
                    label="Image"
                    value="image"
                />
                <el-option
                    label="Video"
                    value="video"
                />
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :lg="9">
            <el-form-item label="Main File" prop="file_path">
              <SingleFileUploader
                  ref="refSingleFileUpload"
                  :acceptExtension="formData.type=='video' ? videoExtension : imageExtension"
                  :acceptSize="102400"
                  :listType="'text'"
                  @uplodable="uplodableFile"
                  @clearUplodable="uplodableFile"
                  @deleteFile="deleteMainFile"
              />
            </el-form-item>
          </el-col>
          <el-col :lg="9">
            <el-form-item label="Alternative Image" v-show="formData.type=='video'" prop="alt_image">
              <SingleFileUploader
                  ref="refSingleThumbUpload"
                  :acceptExtension="'.jpg,.jpeg,.png,.webp,.gif'"
                  :acceptSize="102400"
                  :listType="'picture-card'"
                  @uplodable="uplodableAltImage"
                  @clearUplodable="uplodableAltImage"
                  @deleteFile="deleteAltImage"
              />
            </el-form-item>
          </el-col>
        </el-row>

      </el-form>
    </template>
    <template #footer>
            <span class="dialog-footer">
                <el-button @click="closeForm()">Cancel</el-button>
                <el-button
                    type="primary"
                    :loading="formData.processing"
                    @click="submitForm(refForm)"
                >Update</el-button
                >
            </span>
    </template>
  </el-dialog>

</template>

<script setup>

import SingleFileUploader from "@/Components/SingleFileUploader.vue";
import {markRaw, ref} from "@vue/runtime-core";
import {useForm} from "@inertiajs/vue3";
import {Edit} from "@element-plus/icons-vue";

const FormVisible = ref(false);
const refForm = ref();
const imageExtension = ref('.jpg,.jpeg,.png,.gif,.webp');
const videoExtension = ref('.webm,.mp4,.mpeg');
const editFormData = ref();
const refSingleFileUpload = ref(null);
const refSingleThumbUpload = ref(null);

const formData = useForm({
  _method: "POST",
  title: "",
  file_path: "",
  alt_image: "",
  detail: "",
  link: "",
  id: "",
  publish: '',
  type: ''
});

const resetForm = (formEl) => {
  if (!formEl) return;

  refSingleFileUpload.value.clearUploadFile();
  refSingleThumbUpload.value.clearUploadFile();

  formEl.resetFields();
  formData.reset();
};
const closeForm = () => {
  FormVisible.value = false;
  resetForm(refForm.value);
  formData.reset();
};

const uplodableFile = (file) => {
  formData.file_path = file;
};
const uplodableAltImage = (file) => {
  formData.alt_image = file;
};

const deleteMainFile = (file) => {
  // if (FormType.value == "Edit" && file.id) {
  //   const formData = useForm({});
  //   formData.delete(route("manage.product.picture", file.id), {
  //     preserveScroll: true,
  //     onSuccess: () => {
  //       return true;
  //     },
  //   });
  // }
};

const deleteAltImage = (file) => {
  // if (FormType.value == "Edit" && file.id) {
  //   const formData = useForm({});
  //   formData.delete(route("manage.product.picture", file.id), {
  //     preserveScroll: true,
  //     onSuccess: () => {
  //       return true;
  //     },
  //   });
  // }
};
const showForm = function (data = "") {
  FormVisible.value = true;
  formData.reset();

  editFormData.value = data;
  setTimeout(() => {
    populateFormData(data);
  }, 200)

};

const populateFormData = function (data) {
  // console.log(data)
  Object.assign(formData, data);

  if (data.file_path != null && data.file_path.length > 0) {
    refSingleFileUpload.value.fileList = [
      {
        name: data.file_path,
        url: data.file_path,
        id: data.id,
      },
    ];
  }
  if (data.type == 'video' && data.alt_image != '') {
    refSingleThumbUpload.value.fileList = [
      {
        name: data.alt_image,
        url: data.alt_image,
        id: data.id,
      },
    ];
  }

};

const submitForm = async (formEl) => {
  if (!formEl) return;

  formData._method = "PATCH";
  update();
};

const update = function () {
  ElMessageBox.confirm("You are trying to edit. Continue?", "Warning", {
    type: "warning",
    icon: markRaw(Edit),
    callback: (action) => {
      if (action == "confirm") {
        try {
          formData.post(route("admin.homepage-banner.update", editFormData.value.id), {
            preserveScroll: true,
            onSuccess: () => {
              closeForm();
            },
            onError: (errors) => {

            },
          });
        } catch (error) {
          ElNotification({
            title: "Error",
            message: "Request Form Error.",
            type: "error",
          });
          console.log(error);
        }
      }
    },
  });
};
defineExpose({
  showForm,
});
</script>

<style lang="scss" scoped>

</style>
