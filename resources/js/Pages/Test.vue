<script>
export default {
    layout: "admin",
    data() {
        return {};
    },
};
</script>
<script setup>
import { useInertiaPropsUtility } from "@/Composables/inertiaPropsUtility";
const { iPropsValue } = useInertiaPropsUtility();
const testData = iPropsValue('app_info','title');
</script>

<template>
    <p>{{testData}}</p>
    <el-row class="mb-4">
        <el-button type="primary">Primary</el-button>
        <el-button type="success">Success</el-button>
        <el-button type="info">Info</el-button>
        <el-button type="warning">Warning</el-button>
        <el-button type="danger">Danger</el-button>
        <el-button>中文</el-button>
    </el-row>
</template>

