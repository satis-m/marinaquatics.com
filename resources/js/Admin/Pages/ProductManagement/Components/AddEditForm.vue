<template>
    <el-dialog
        v-model="FormVisible"
        :before-close="closeForm"
        :title="FormType + ' Product'"
        :fullscreen="true"
    >
        <template #default>
            <el-form

                @submit.prevent
                :model="formData"
                :rules="rules"
                ref="refForm"
                label-position="top"
                :scroll-to-error="true"
                status-icon
            >
                <el-row :gutter="10">
                    <el-col :lg="6">
                        <el-form-item
                            label="Name"
                            prop="name"
                            :error="formErrors.name"
                        >
                            <el-input
                                v-model="formData.name"
                                placeholder="Product Name"
                                autocomplete="off"
                            />
                        </el-form-item>
                    </el-col>
                    <el-col :lg="6">
                        <el-form-item label="Category" prop="category" :error="formErrors.category">
                            <el-select v-model="formData.category" @change="updateSubCategory" placeholder="Select">
                                <el-option
                                    v-for="(item , key ) in iPropsValue('categories')"
                                    :key="key"
                                    :label="item"
                                    :value="item"
                                />
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :lg="6">
                        <el-form-item
                            label="Sub Category"
                            prop="sub_category"
                            :error="formErrors.sub_category"
                        >
                            <el-select v-model="formData.sub_category" @change="updateProductType" placeholder="Select">
                                <el-option
                                    v-for="(item , key ) in sub_category"
                                    :key="key"
                                    :label="item.sub_category"
                                    :value="item.slug"
                                />
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :lg="6">
                        <el-form-item
                            label="Type"
                            prop="type"
                            :error="formErrors.type"
                        >
                            <el-select v-model="formData.type" placeholder="Select">
                                <el-option
                                    v-for="(item , key ) in product_type"
                                    :key="key"
                                    :label="item.name"
                                    :value="item.slug"
                                />
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row :gutter="10">
                    <el-col :lg="12">
                        <el-form-item
                            label="Product Information"
                            prop="product_info"
                            :error="formErrors.product_info"
                        >
                            <content-editor ref="refProductInfoContentEditor"
                                            v-model="formData.product_info"></content-editor>
                        </el-form-item>
                    </el-col>
                    <el-col :lg="12">
                        <el-form-item
                            label="Desctiption"
                            prop="description"
                            :error="formErrors.description"
                        >
                            <content-editor ref="refProductDescriptionContentEditor"
                                            v-model="formData.description"></content-editor>
                        </el-form-item>
                    </el-col>

                </el-row>
                <el-row :gutter="10">
                    <el-col :lg="12">

                        <el-form-item label="Tag" prop="tag">
                            <el-select
                                v-model="formData.tag"
                                multiple
                                filterable
                                clearable
                                allow-create
                                default-first-option
                                :reserve-keyword="false"
                                placeholder="Choose tags for your product"
                            >
                                <el-option
                                    v-for="(item,key) in  tags"
                                    :key="key"
                                    :label="item"
                                    :value="item"
                                />
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :lg="6">
                        <el-form-item label="Brand" prop="brand">
                            <el-select
                                v-model="formData.brand"
                                filterable
                                clearable
                                allow-create
                                default-first-option
                                placeholder="Choose your product Brand"
                            >
                                <el-option
                                    v-for="(item,key) in  brands"
                                    :key="key"
                                    :label="item"
                                    :value="item"
                                />
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :lg="6">
                        <el-form-item label="Unit" prop="unit" :error="formErrors.name">
                            <el-select
                                v-model="formData.unit"
                                filterable
                                clearable
                                allow-create
                                default-first-option
                                placeholder="Choose your product Unit"
                            >
                                <el-option label="pcs" value="pcs"/>
                                <el-option label="pkt" value="pkt"/>
                                <el-option label="kg" value="kg"/>
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row :gutter="10">
                    <el-col :lg="12">
                        <el-form-item
                            label="Video Link"
                            prop="video_link"
                        >
                            <el-input
                                v-model="formData.video_link"
                                placeholder="Product Video"
                                autocomplete="off"
                            />
                        </el-form-item>

                    </el-col>
                    <el-col :lg="8">
                        <el-form-item
                            label="Price"
                            prop="price"
                            :error="formErrors.price"
                        >

                            <el-input
                                placeholder="Product Price"
                                type="number"
                                v-model="formData.price"
                                autocomplete="off"
                            >
                                <template #prepend>Rs.</template>
                            </el-input>
                        </el-form-item>
                    </el-col>

                    <el-col :lg="4">
                        <el-form-item
                            label="Publish"
                            prop="publish"
                            size="large"
                        >
                            <el-switch
                                :active-value="1"
                                :inactive-value="0"
                                v-model="formData.publish"
                            />
                        </el-form-item>

                    </el-col>
                </el-row>
                <el-row :gutter="10">
                    <el-col :lg="12">
                        <el-form-item label="Main Picture" prop="main_picture">
                            <SingleFileUploader
                                ref="refSingleImageUpload"
                                :acceptExtension="'.jpg, .jpeg, .png, .webp'"
                                :acceptSize="2048"
                                :listType="'picture-card'"
                                @uplodable="uplodableMainPicture"
                                @clearUplodable="uplodableMainPicture"
                                @deleteFile="deleteMainPicture"
                            />
                        </el-form-item>
                    </el-col>

                    <el-col :lg="12">
                        <el-form-item label="Alternative Picture" prop="alternative_picture">
                            <MultipleFileUploader
                                ref="refMultipleImageUpload"
                                :acceptExtension="'.jpg, .jpeg, .jpg, .jpeg, .png, .webp'"
                                :acceptSize="2048"
                                :listType="'picture-card'"
                                @uplodable="uplodableAlternatePicture"
                                @clearUplodable="clearAlternatePicture"
                                @deleteFile="deleteAlternatePicture"
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
                >{{ FormType == "Add" ? "Add" : "Update" }}</el-button
                >
            </span>
        </template>
    </el-dialog>
</template>
<script setup>

//library import
import {markRaw, reactive, ref, watch} from "@vue/runtime-core";
import {Edit} from "@element-plus/icons-vue";
import {useForm} from "@inertiajs/vue3";
import SingleFileUploader from "@/Components/SingleFileUploader.vue";
import MultipleFileUploader from "@/Components/MultipleFileUploader.vue";
import ContentEditor from "@/Components/ContentEditor.vue";
//composable import
import {useInertiaPropsUtility} from "@/Composables/inertiaPropsUtility";
import {useAppUtility} from "@/Composables/appUtility";
import {useObjectUtility} from "@/Composables/objectUtility.js";
//variable declaration
const {iPropsValue} = useInertiaPropsUtility();
const {isScreenMd} = useAppUtility();
let {getObjectRow} = useObjectUtility();
const props = defineProps({
    parentFormInput: Object,
});

const FormVisible = ref(false);
const formLabelWidth = "140px";
const refProductInfoContentEditor = ref(null);
const refProductDescriptionContentEditor = ref(null);
const refSingleImageUpload = ref(null);
const refMultipleImageUpload = ref(null);
const refForm = ref();
const sub_category = ref([]);
const product_type = ref([]);
const all_sub_category = iPropsValue('subCategories');
const all_product_type = iPropsValue('productTypes');
const FormType = ref("Add");
const editFormData = ref(); //default edit form data
const tags = ref(iPropsValue("tags"));
const brands = ref(iPropsValue("brands"));
const formData = useForm({
    _method: "POST",
    ...props.parentFormInput,
    main_picture: "",
    alternative_picture: [],
    id: "",
});

watch(
    () => iPropsValue("tags"),
    () => {
        tags.value = iPropsValue("tags");
    }
);
watch(
    () => iPropsValue("brands"),
    () => {
        brands.value = iPropsValue("brands");
    }
);

const rules = reactive({
    name: [
        {
            required: true,
            message: "Please input product name",
            trigger: "blur",
        },
    ],
    product_info: [
        {
            required: true,
            message: "Please input product information",
            trigger: "blur",
        },
    ],
    category: [
        {
            required: true,
            message: "Please select category",
            trigger: "change",
        },
    ],sub_category: [
        {
            required: true,
            message: "Please select sub-category",
            trigger: "change",
        },
    ],
    type: [
        {
            required: true,
            message: "Please select product type",
            trigger: "change",
        },
    ],
    price: [
        {
            required: true,
            message: "Please input product price",
            trigger: "blur",
        }
    ],
    unit: [
        {
            required: true,
            message: "Please select unit",
            trigger: "change",
        },
    ],

});
const formErrors = reactive({
    name: null,
    type: null,
    category: null,
    sub_category: null,
    product_info: null,
    description: null,
    price: null,
    unit: null,
});
const loadServerValidationError = () => {
    Object.assign(formErrors, formData.errors);
    if (formData.errors.email) existEmail.add(formData.email);
};
const clearServerValidationError = () => {
    for (const key in formErrors) {
        formErrors[key] = null;
    }
};
const uplodableMainPicture = (file) => {
    formData.main_picture = file;
};
const uplodableAlternatePicture = (file) => {
    formData.alternative_picture.push(file);
};
const clearAlternatePicture = () => {
    formData.alternative_picture = [];
};
const deleteMainPicture = (file) => {
    if (FormType.value == "Edit" && file.id) {
        const formData = useForm({});
        formData.delete(route("manage.product.picture", file.id), {
            preserveScroll: true,
            onSuccess: () => {
                return true;
            },
        });
    }
};
const deleteAlternatePicture = (file) => {
    if (FormType.value == "Edit" && file.id) {
        const formData = useForm({});
        formData.delete(route("manage.product.picture", file.id), {
            preserveScroll: true,
            onSuccess: () => {
                return true;
            },
        });
    }
};
const resetForm = (formEl) => {
    if (!formEl) return;
    refSingleImageUpload.value.clearUploadFile();
    refMultipleImageUpload.value.clearUploadFile();
    refProductInfoContentEditor.value.clearContent();
    refProductDescriptionContentEditor.value.clearContent();

    formEl.resetFields();
    formData.reset();
};
const closeForm = () => {
    FormVisible.value = false;
    resetForm(refForm.value);
    formData.reset();
};
const showForm = function (formType, data = "") {
    FormVisible.value = true;
    FormType.value = formType;
    formData.description = '';
    formData.reset();
    if (formType === "Add") {
        formData.product_info = '<p></p><ul><li>Brand : </li><li>Type : </li></ul>';
    }
    if (formType === "Edit") {
        editFormData.value = data;
        setTimeout(() => {
            populateFormData(data);
        }, 200)
    }
};
const populateFormData = function (data) {
    Object.assign(formData, data);
    sub_category.value = all_sub_category[data.category.name];
    const main_picture = getObjectRow(data.media, "collection_name", "main_picture");
    const alternative_picture = getObjectRow(
        data.media,
        "collection_name",
        "alternative_picture"
    );
    if (main_picture != null && main_picture.length > 0) {
        refSingleImageUpload.value.fileList = [
            {
                name: main_picture[0].file_name,
                url: main_picture[0].original_url,
                id: main_picture[0].id,
            },
        ];
    }
    if (alternative_picture != null && alternative_picture.length > 0) {
        alternative_picture.forEach((item, index) => {

            refMultipleImageUpload.value.fileList.push({
                name: item.file_name,
                url: item.original_url,
                id: item.id,
            })
        })
    }
    formData.main_picture = '';
    formData.alternative_picture = [];

    formData.category = data.category.name;
    formData.sub_category = data.category.slug;
};
const submitForm = async (formEl) => {
    if (!formEl) return;
    await formEl.validate((valid, fields) => {
        if (valid) {
            if (FormType.value == "Add") {
                formData._method = "POST";
                create();
            } else {
                formData._method = "PATCH";
                update();
            }
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
const create = async function () {
    ElMessageBox.confirm("You are trying to Add Product. Continue?", "Warning", {
        type: "warning",
        icon: markRaw(Edit),
        callback: (action) => {
            if (action == "confirm") {
                clearServerValidationError();
                formData.post(route("product.store"), {
                    preserveScroll: true,
                    onSuccess: () => {
                        closeForm();
                    },
                    onError: (errors) => {
                        loadServerValidationError();
                    },
                });
            }
        },
    });
};
const update = function () {
    ElMessageBox.confirm("You are trying to edit. Continue?", "Warning", {
        type: "warning",
        icon: markRaw(Edit),
        callback: (action) => {
            if (action == "confirm") {
                try {
                    clearServerValidationError();
                    formData.post(route("product.update", editFormData.value.id), {
                        preserveScroll: true,
                        onSuccess: () => {
                            closeForm();
                        },
                        onError: (errors) => {
                            loadServerValidationError();
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
const updateSubCategory = function (selectedVal) {
    sub_category.value = all_sub_category[selectedVal];
    formData.sub_category = '';
}
const updateProductType = function (selectedVal) {
    product_type.value = all_product_type[selectedVal].sort((a, b) => a.name.localeCompare(b.name));
    formData.type = '';
}

defineExpose({
    showForm,
});
</script>
<style lang="scss" scoped>
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
</style>
<style lang="scss">
.date-picker {
    .el-input__wrapper {
        width: 100%;
    }
}

.el-select {
    width: 100%;
}
</style>
