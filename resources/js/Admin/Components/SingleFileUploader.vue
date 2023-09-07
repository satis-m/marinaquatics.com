<template>
    <el-upload
        ref="refLogoUpload"
        class="w-full"
        v-model:file-list="fileList"
        :class="props.listType + '-uploader'"
        action="#"
        :accept="props.acceptExtension"
        :limit="1"
        :on-exceed="handleLogoExceed"
        :on-change="logoUpload"
        :auto-upload="false"
        :list-type="props.listType == 'none' ? null : props.listType"
        :on-remove="clearUploadFile"
        :on-preview="handlePictureCardPreview"
        :show-file-list="props.listType != 'none'"
        :before-remove="handleRemove"
    >
        <template #trigger>
            <el-icon v-if="props.listType == 'picture-card'"><Plus /></el-icon>
            <el-button v-else type="primary" :plain="isDarkMode"
            >select file</el-button
            >
        </template>
        <template #tip>
            <div class="el-upload__tip text-red">
                {{ props.acceptExtension }} files. less than
                {{ props.acceptSize }}KB.
            </div>
        </template>
    </el-upload>
    <el-dialog v-model="dialogVisible">
        <img w-full :src="dialogImageUrl" alt="Preview Image" />
    </el-dialog>
</template>

<script setup>
import {genFileId} from "element-plus";
import {Delete, Plus} from "@element-plus/icons-vue";

import {useAppUtility} from "@/Composables/appUtility";
import {markRaw, ref} from "@vue/runtime-core";
import {useForm} from "@inertiajs/vue3";

const { isDarkMode } = useAppUtility();
const props = defineProps({
    acceptExtension: { type: String, required: true },
    acceptSize: { type: Number, required: true },
    listType: { type: String, required: false, default: "list" },
    fileList: { type: Object, required: false },
});

const emit = defineEmits(["uplodable", "clearUplodable",'deleteFile']);
const fileList = ref([]);
const refLogoUpload = ref();
const handleLogoExceed = (files) => {
    const file = files[0];
    if (beforeLogoUpload(file)) {
        clearUploadFile();
        file.uid = genFileId();
        refLogoUpload.value.handleStart(file);
    }
};
const handleRemove = async (files) => {
    await ElMessageBox.confirm("It will permanently delete. Continue?", "Warning", {
        type: "error",
        icon: markRaw(Delete),
        callback: (action) => {
            if (action == "confirm") {
                fileList.value = '';
                emit("deleteFile",files);
                return true;
            }
        },
    });

}
const clearUploadFile = () => {
    refLogoUpload.value.clearFiles();
    emit("clearUplodable", null);
};
const logoUpload = function (file, response) {
    if (beforeLogoUpload(file.raw)) {
        emit("uplodable", file.raw);
        return false;
    }
    setTimeout(()=>{
        clearUploadFile();
    },200);
};
const beforeLogoUpload = function (uploadFile) {
    const file = uploadFile;

    const isAcceptable = file.type === props.acceptExtension;
    const isLt2M = file.size / 1024 <= props.acceptSize;
    if (!isAcceptableFile(file.type)) {
        ElMessage.error("File must be " + props.acceptExtension + " format!");
        return false;
    }
    if (!isLt2M) {
        ElMessage.error("File size can not exceed " + props.acceptSize + " KB");
        return false;
    }
    return true;
};

const isAcceptableFile = (fileType) => {
    const allowedExtensions = props.acceptExtension
        .replace(/\s+|\./g, "")
        .split(","); //[("jpg", "jpeg", "png")];
    let allowedType = [];

    const imageExtensions = ["jpg", "jpeg", "png", "svg",'webp'];
    const videoExtensions = ["mp4", "mpeg","webm"];
    const audioExtensions = ["mp3", "m4a"];
    const fileExtensions = ["pdf", "doc", "xls"];
    const zipExtensions = ["zip", "7zip", "rar"];
    allowedExtensions.forEach((value) => {
        imageExtensions.forEach((extension) => {
            if (value.toLowerCase() == extension) {
                if (extension == "svg") allowedType.push("image/svg+xml");
                else allowedType.push("image/" + extension);
            }
        });
        videoExtensions.forEach((extension) => {
            if (value.toLowerCase() == extension) {
                allowedType.push("audio/" + extension);
            }
        });
        audioExtensions.forEach((extension) => {
            if (value.toLowerCase() == extension) {
                allowedType.push("video/" + extension);
            }
        });
        fileExtensions.forEach((extension) => {
            if (value.toLowerCase() == extension) {
                if (extension == "pdf") allowedType.push("application/pdf");
                if (extension == "xls")
                    allowedType.push("application/vnd.ms-excel");
                if (extension == "doc") allowedType.push("application/msword");
                if (extension == "csv") allowedType.push("text/csv");
                if (extension == "docx")
                    allowedType.push(
                        "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                    );
                if (extension == "xlsx")
                    allowedType.push(
                        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                    );
            }
        });
        zipExtensions.forEach((extension) => {
            if (value.toLowerCase() == extension) {
                if (extension == "zip")
                    allowedType.push("application/x-zip-compressed");
                if (extension == "7zip") allowedType.push("image/svg+xml");
            }
        });
    });

    return allowedType.includes(fileType);
};
const dialogImageUrl = ref("");
const dialogVisible = ref(false);
const handlePictureCardPreview = (uploadFile) => {
    dialogImageUrl.value = uploadFile.url;
    dialogVisible.value = true;
};

defineExpose({ clearUploadFile, fileList });
</script>

<style>
.picture-uploader .el-upload-list__item .el-upload-list__item-info {
    width: calc(100% - 70px) !important;
}
</style>
