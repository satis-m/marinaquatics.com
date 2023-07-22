<template>
    <el-dialog
        v-model="FormVisible"
        :before-close="closeForm"
        :title="'Discount Offer for '+productName "
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
                    <el-col :lg="8">
                        <el-form-item
                            label="Name"
                            prop="name"
                        >
                            <el-input
                                v-model="formData.name"
                                placeholder="Product Name"
                                autocomplete="off"
                            />
                        </el-form-item>
                    </el-col>
                    <el-col :lg="8">
                        <el-form-item
                            label="Name"
                            prop="name"
                        >
                            <el-input
                                v-model="formData.name"
                                placeholder="Product Name"
                                autocomplete="off"
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
import {ref} from "@vue/runtime-core";
import {useForm} from "@inertiajs/vue3";

const FormVisible = ref(false);
const viewData = ref();
const productName = ref('');
const closeForm = () => {
    FormVisible.value = false;
};

const formData = useForm({
    _method: "POST",
    product: "",
    quantity: '',
    cost_price: '',
    importer: '',
    prev_quantity:0,
    id: "",
});
const showForm = function (data) {
    FormVisible.value = true;
    productName.value = data.name;
};
defineExpose({
    showForm,
});
</script>
<style lang="scss">
.info-list {
    table {
        td.el-descriptions__cell {
            padding: 3px 3px 3px 8px !important;
        }
    }
}
</style>
