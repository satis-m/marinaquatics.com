<template>
    <Head title="Setting" />
    <div>
        <el-row :gutter="20">
            <el-col :span="24">
                <AddEditForm />
            </el-col>
        </el-row>
    </div>
</template>
<script setup>
defineOptions({layout: "admin"});
import AddEditForm from "./Components/AddEditForm.vue";
import {Head} from "@inertiajs/vue3";
</script>
