<template>
    <el-upload
        ref="refFileUpload"
        class="w-full"
        v-model:file-list="fileList"
        :class="props.listType + '-uploader'"
        action="#"
        multiple
        :accept="props.acceptExtension"
        :limit="props.fileLimit"
        :on-exceed="handleFileExceed"
        :on-change="fileUpload"
        :auto-upload="false"
        :list-type="props.listType == 'none' ? null : props.listType"
        :on-preview="handleFileCardPreview"
        :show-file-list="props.listType != 'none'"
        :before-remove="handleRemove"
    >
        <template #trigger>
            <el-icon v-if="props.listType == 'picture-card'">
                <Plus/>
            </el-icon>
            <el-button v-else type="primary" :plain="isDarkMode"
            >select file
            </el-button
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
        <img w-full :src="dialogImageUrl" alt="Preview Image"/>
    </el-dialog>
</template>

<script setup>
import {genFileId} from "element-plus";
import {Delete, Plus} from "@element-plus/icons-vue";

import {useAppUtility} from "@/Composables/appUtility";
import {markRaw, ref} from "@vue/runtime-core";
import {useForm} from "@inertiajs/vue3";

const {isDarkMode} = useAppUtility();
const props = defineProps({
    acceptExtension: {type: String, required: true},
    acceptSize: {type: Number, required: true},
    listType: {type: String, required: false, default: "list"},
    fileList: {type: Object, required: false},
    fileLimit: {type: Number, required: false, default: 4},
});

const emit = defineEmits(["uplodable", "clearUplodable", "deleteFile"]);
const fileList = ref([]);
const refFileUpload = ref();
const handleFileExceed = (files, uploadFiles) => {
    ElMessage.warning(
        `The limit is ${props.fileLimit}, you selected ${files.length} files this time, it will be ${
            files.length + uploadFiles.length
        } total.`
    )
};
const handleRemove = async (files) => {
    await ElMessageBox.confirm("It will permanently delete. Continue?", "Warning", {
        type: "error",
        icon: markRaw(Delete),
        callback: (action) => {
            if (action == "confirm") {
                const filteredList = fileList.value.filter((data) => {
                    return data.id != files.id
                })
                fileList.value = filteredList
                emit("deleteFile", files);
                return true;
            }
        },
    });

}
const clearUploadFile = () => {
    refFileUpload.value.clearFiles();
    emit("clearUplodable");
};
const fileUpload = function (file, response) {
    if (beforeFileUpload(file.raw)) {
        emit("uplodable", file.raw);
        return;
    } else {
        fileList.value = fileList.value.slice(0, -1)
    }
    //return false;
};
const beforeFileUpload = function (uploadFile) {
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
    const videoExtensions = ["mp4", "mpeg",'webm'];
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
const handleFileCardPreview = (uploadFile) => {
    dialogImageUrl.value = uploadFile.url;
    dialogVisible.value = true;
};

defineExpose({clearUploadFile, fileList});
</script>

<style>
.picture-uploader .el-upload-list__item .el-upload-list__item-info {
    width: calc(100% - 70px) !important;
}
</style>
