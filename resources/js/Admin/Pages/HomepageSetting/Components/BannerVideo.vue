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

import {useAppUtility} from "@/Composables/appUtility";
const {siteUrl} = useAppUtility();

const FormVisible = ref(false);
const videoPath = ref('');
const showForm = function (filePath = "") {
    FormVisible.value = true;
    videoPath.value = siteUrl(filePath);
}

defineExpose({
    showForm,
});
</script>

<style lang="scss" scoped>

</style>
