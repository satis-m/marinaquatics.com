<template>
    <el-form
        @submit.prevent
        :model="formData"
        :rules="rules"
        label-position="top"
        ref="formRef"
    >
        <el-row :gutter="20">
            <el-col :xs="24" :sm="24">
                <el-card class="box-card h-full">
                    <el-row :gutter="20" class="mb-6">
                        <el-col :xs="24" :sm="12" :md="12">
                            <el-form-item
                                label="Organization / Company Name"
                                prop="title"
                            >
                                <el-input v-model="formData.title" />
                            </el-form-item>
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="12">
                            <el-form-item label="Address" prop="address">
                                <el-input v-model="formData.address" />
                            </el-form-item>
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="12">
                            <el-form-item label="Email" prop="email">
                                <el-input v-model="formData.email" />
                            </el-form-item>
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="12">
                            <el-form-item label="Contact" prop="contact">
                                <el-input
                                    type="number"
                                    v-model="formData.contact"
                                />
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-divider class="!mt-0 !mb-4" />
                    <el-row :gutter="20" class="mb-6">
                        <el-col :sm="24" :md="8">
                            <el-form-item
                                label="Application Logo"
                                class="!mb-0"
                                prop="title"
                            >
                                <SingleFileUploader
                                    ref="refLogoUpload"
                                    :acceptExtension="'.jpg, .jpeg, .svg, .png'"
                                    :acceptSize="2048"
                                    :listType="'picture'"
                                    @uplodable="uplodableLogo"
                                    @clearUplodable="uplodableLogo"
                                />
                            </el-form-item></el-col>
                        <el-col :sm="24" :md="8"
                        ><el-form-item
                            label="Fav Icon (Light Themed)"
                            prop="title"
                        >
                            <SingleFileUploader
                                ref="refFavLightUpload"
                                :acceptExtension="'.png, .svg'"
                                :acceptSize="150"
                                :listType="'picture'"
                                @uplodable="uplodableFavIconLight"
                                @clearUplodable="uplodableFavIconLight"
                            />
                        </el-form-item></el-col>
                        <el-col :sm="24" :md="8">
                            <el-form-item
                                label="Fav Icon (Dark Themed)"
                                prop="title"
                                class="dark-themed"
                            >
                                <SingleFileUploader

                                    ref="refFavDarkUpload"
                                    :acceptExtension="'.png, .svg'"
                                    :acceptSize="150"
                                    :listType="'picture'"
                                    @uplodable="uplodableFavIconDark"
                                    @clearUplodable="uplodableFavIconDark"
                                />
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row >
                        <span class="">
                            <el-button
                                type="primary"
                                :loading="formData.processing"
                                @click="submitForm(formRef)"
                            >Update</el-button
                            >
                            <el-button @click="closeForm()">Cancel</el-button>
                        </span>
                    </el-row>

                </el-card>
            </el-col>
        </el-row>
    </el-form>
</template>

<script setup>
//library import
import {markRaw, onMounted, reactive, ref, watch} from "@vue/runtime-core";
import {Edit} from "@element-plus/icons-vue";
import {useForm} from "@inertiajs/vue3";
import SingleFileUploader from "@/Components/SingleFileUploader.vue";
//composable import
import {useInertiaPropsUtility} from "@/Composables/inertiaPropsUtility";
import {useObjectUtility} from "@/Composables/objectUtility";
//variable declaration
const formLabelWidth = "140px";
let { iPropsValue } = useInertiaPropsUtility();
let { getObjectRow } = useObjectUtility();
let formRef = ref();
let FormType = ref("Add");
let editFormData = ref(); //default edit form data
const refLogoUpload = ref(null);
const refFavLightUpload = ref(null);
const refFavDarkUpload = ref(null);
const defaultData = ref(iPropsValue("appInfo"));
watch(
    () => iPropsValue("appInfo"),
    () => {
        defaultData.value = iPropsValue("appInfo");
    }
);

const uplodableLogo = (file) => {
    formData.logo = file;
};
const uplodableFavIconLight = (file) => {
    formData.favLight = file;
};
const uplodableFavIconDark = (file) => {
    formData.favDark = file;
};
const formData = useForm({
    _method: "PATCH",
    title: "",
    email: "",
    address: "",
    contact: "",
    logo: "",
    favLight: "",
    favDark: "",
});
const rules = reactive({
    name: [
        {
            required: true,
            message: "Please Input Name",
            trigger: "blur",
        },
    ],
});
const submitForm = async (formEl) => {
    if (!formEl) return;
    await formEl.validate((valid, fields) => {
        if (valid) {
            update();
        } else {
            ElNotification({
                title: "Warning",
                message:
                    "Form validation Error, please check before submitting!",
                type: "warning",
            });
            console.log("error submit!", fields);
        }
    });
};
const resetForm = (formEl) => {
    if (!formEl) return;
    refLogoUpload.value.clearUploadFile();
    refFavLightUpload.value.clearUploadFile();
    refFavDarkUpload.value.clearUploadFile();
    formEl.resetFields();
    formData.reset();
    setTimeout(() => {
        populateFormData(defaultData.value);
    }, 300);
};
const closeForm = () => {
    resetForm(formRef.value);
};

const update = function () {
    ElMessageBox.confirm(
        "You are trying to update default application Information. Continue?",
        "Warning",
        {
            type: "warning",
            icon: markRaw(Edit),
            callback: (action) => {
                if (action == "confirm") {
                    try {
                        formData.post(route("appSetting.update"), {
                            preserveScroll: true,
                            onSuccess: () => {
                                closeForm();
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
        }
    );
};
let populateFormData = function (data) {
    formData.title = data.title;
    formData.email = data.email;
    formData.contact = data.contact;
    formData.address = data.address;
    const logo = getObjectRow(data.media, "collection_name", "logo");
    const fav_light = getObjectRow(
        data.media,
        "collection_name",
        "fav-icon-light"
    );
    const fav_dark = getObjectRow(
        data.media,
        "collection_name",
        "fav-icon-dark"
    );
    if (logo !=null && logo.length > 0) {
        console.log(refLogoUpload.value.fileList);
        refLogoUpload.value.fileList = [
            {
                name: logo[0].file_name,
                url: logo[0].original_url,
            },
        ];
    }
    if (fav_light !=null && fav_light.length > 0) {
        refFavLightUpload.value.fileList = [
            {
                name: fav_light[0].file_name,
                url: fav_light[0].original_url,
            },
        ];
    }
    if (fav_dark !=null && fav_dark.length > 0) {
        refFavDarkUpload.value.fileList = [
            {
                name: fav_dark[0].file_name,
                url: fav_dark[0].original_url,
            },
        ];
    }
};

onMounted(() => {
    populateFormData(defaultData.value);
});
</script>
<style scoped>
li.icon {
    height: 50px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-right: 1px solid var(--el-border-color);
    border-bottom: 1px solid var(--el-border-color);
}
li.icon:hover {
    cursor: pointer;
    background: rgb(226, 226, 226);
}
ul.icon-picker {
    border-top: 1px solid var(--el-border-color);
    border-left: 1px solid var(--el-border-color);
}

.card-footer {
    position: absolute;
    bottom: 20px;
}
.demo-color-block {
    margin-right: 10px;
}

.el-button--text {
    margin-right: 15px;
}
.el-select {
    width: 300px;
}
.el-input {
    width: 300px;
}
.dialog-footer button:first-child {
    margin-right: 10px;
}

</style>
<style lang="scss">
.dark-themed li.el-upload-list__item
{
    background-color: #343434;
    .el-upload-list__item-info a
    {
        color: #f0f0f0;
    }
    img{
        background-color: #343434;
    }
    .el-icon--close
    {
        color:#ffffff;
    }
}
</style>
