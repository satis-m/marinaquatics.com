<template>
    <el-dialog
        v-model="FormVisible"
        title="Banner Video"
        :fullscreen="false"
    >
        <template #default>
            <video autoplay controls>
                <source :src="videoPath">
            </video>
        </template>
    </el-dialog>
</template>

<script setup>
import {ref} from "@vue/runtime-core";

const FormVisible = ref(false);
const videoPath = ref('');
const showForm = function (filePath = "") {
    FormVisible.value = true;
    videoPath.value = filePath;
}

defineExpose({
    showForm,
});
</script>

<style lang="scss" scoped>

</style>
