<template>
    <el-dialog
        v-model="FormVisible"
        :before-close="closeForm"
        :title="FormType + ' Blog'"
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
                    <el-col :lg="12">
                        <el-form-item
                            label="Title"
                            prop="title"
                            :error="formErrors.title"
                        >
                            <el-input
                                v-model="formData.title"
                                placeholder="Blog Title"
                                autocomplete="off"
                            />
                        </el-form-item>
                    </el-col>
                    <el-col :lg="6">

                        <el-form-item label="Tag" prop="tag">
                            <el-select
                                v-model="formData.tag"
                                multiple
                                filterable
                                clearable
                                allow-create
                                default-first-option
                                :reserve-keyword="false"
                                placeholder="Choose tags for your blog"
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

                        <el-form-item label="Category" prop="category">
                            <el-select
                                v-model="formData.category"
                                filterable
                                clearable
                                default-first-option
                                :reserve-keyword="false"
                                placeholder="Choose Category for your blog"
                            >
                                <el-option
                                    v-for="(item,key) in  categories"
                                    :key="key"
                                    :label="item"
                                    :value="key"
                                />
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row :gutter="10">
                    <el-col :lg="24">
                        <el-form-item
                            label="Body Content"
                            prop="body"
                            :error="formErrors.body"
                        >
                            <content-editor editorHeight="380px" :toolbarOptions="toolbarOptions" ref="refBlogBodyContentEditor"
                                            v-model="formData.body"></content-editor>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row :gutter="10">
                    <el-col :lg="6">
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

                    <el-col :lg="12">
                        <el-form-item label="Main Picture" prop="main_picture">
                            <SingleFileUploader
                                ref="refSingleImageUpload"
                                :acceptExtension="'.jpg, .jpeg, .png, .webp'"
                                :acceptSize="4096"
                                :listType="'picture-card'"
                                @uplodable="uplodableMainPicture"
                                @clearUplodable="uplodableMainPicture"
                                @deleteFile="deleteMainPicture"
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
const refBlogBodyContentEditor = ref(null);
const refSingleImageUpload = ref(null);
const refForm = ref();
const FormType = ref("Add");
const editFormData = ref(); //default edit form data
const tags = ref(iPropsValue("tags"));
const categories = ref(iPropsValue("categories"));
const formData = useForm({
    _method: "POST",
    ...props.parentFormInput,
    main_picture: "",
    id: "",
});
const toolbarOptions = [['bold', 'italic', 'underline', 'strike'],        // toggled buttons
    // ['blockquote', 'code-block'],

    [{ 'header': 1 }, { 'header': 2 }],               // custom button values
    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
    [{ 'script': 'sub' }, { 'script': 'super' }],     // superscript/subscript
    [{ 'indent': '-1' }, { 'indent': '+1' }],         // outdent/indent
    // [{ 'direction': 'rtl' }],                         // text direction

    [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
    // [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

    [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
    [{ 'font': [] }],
    [{ 'align': [] }],

    // ['link', 'video', 'image'],
    ['link'],

    ['clean'] ];
watch(
    () => iPropsValue("tags"),
    () => {
        tags.value = iPropsValue("tags");
    }
);
const rules = reactive({
    title: [
        {
            required: true,
            message: "Please input blog title",
            trigger: "blur",
        },
    ],
    body: [
        {
            required: true,
            message: "Please input blog body content",
            trigger: "blur",
        },
    ],
    category: [
        {
            required: true,
            message: "Please input blog category",
            trigger: "change",
        },
    ]

});
const formErrors = reactive({
    title: null,
    body: null,
});
const loadServerValidationError = () => {
    Object.assign(formErrors, formData.errors);
};
const clearServerValidationError = () => {
    for (const key in formErrors) {
        formErrors[key] = null;
    }
};
const uplodableMainPicture = (file) => {
    formData.main_picture = file;
};

const deleteMainPicture = (file) => {
    if (FormType.value == "Edit" && file.id) {
        const formData = useForm({});
        formData.delete(route("manageBlog.picture", file.id), {
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
    refBlogBodyContentEditor.value.clearContent();

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
    formData.body = '';
    formData.reset();
    if (formType === "Edit") {
        editFormData.value = data;
        setTimeout(() => {
            populateFormData(data);
        }, 200)
    }
};
const populateFormData = function (data) {
    Object.assign(formData, data);
    const main_picture = getObjectRow(data.media, "collection_name", "blog_main_picture");

    if (main_picture != null && main_picture.length > 0) {
        refSingleImageUpload.value.fileList = [
            {
                name: main_picture[0].file_name,
                url: main_picture[0].original_url,
                id: main_picture[0].id,
            },
        ];
    }

    formData.main_picture = '';
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
    ElMessageBox.confirm("You are trying to Add Blog. Continue?", "Warning", {
        type: "warning",
        icon: markRaw(Edit),
        callback: (action) => {
            if (action == "confirm") {
                clearServerValidationError();
                formData.post(route("manageBlog.store"), {
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
                    formData.post(route("manageBlog.update", editFormData.value.id), {
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
