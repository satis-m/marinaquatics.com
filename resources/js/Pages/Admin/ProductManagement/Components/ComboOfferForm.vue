<template>
    <el-dialog
        v-model="FormVisible"
        :before-close="closeForm"
        :title="'Combo Offer for '+productName "
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
                <el-row>
                    <el-divider>
                        <el-text size="large" type="info" style="font-size: var(--el-font-size-large)">
                            Offer 1
                        </el-text>
                    </el-divider>
                </el-row>
                <el-row :gutter="10">
                    <el-col :lg="8">
                        <el-form-item
                            label="Name"
                            prop="name"
                        >
                            <el-input
                                v-model="formData.name_1"
                                placeholder="Name"
                                autocomplete="off"
                            />
                        </el-form-item>
                    </el-col>
                    <el-col :lg="8">
                        <el-form-item
                            label="Quantity"
                            prop="quantity"
                        >
                            <el-input
                                type="number"
                                v-model="formData.quantity_1"
                                placeholder="Quantity"
                                autocomplete="off"
                            />
                        </el-form-item>
                    </el-col>
                    <el-col :lg="8">
                        <el-form-item
                            label="Price"
                            prop="price"
                        >
                            <el-input
                                type="number"
                                v-model="formData.price_1"
                                placeholder="Price"
                                autocomplete="off"
                            />
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row>
                    <el-divider>
                        <el-text size="large" type="info" style="font-size: var(--el-font-size-large)">
                            Offer 2
                        </el-text>
                    </el-divider>
                </el-row>
                <el-row :gutter="10">
                    <el-col :lg="8">
                        <el-form-item
                            label="Name"
                            prop="name"
                        >
                            <el-input
                                v-model="formData.name_2"
                                placeholder="Name"
                                autocomplete="off"
                            />
                        </el-form-item>
                    </el-col>
                    <el-col :lg="8">
                        <el-form-item
                            label="Quantity"
                            prop="quantity"
                        >
                            <el-input
                                type="number"
                                v-model="formData.quantity_2"
                                placeholder="Quantity"
                                autocomplete="off"
                            />
                        </el-form-item>
                    </el-col>
                    <el-col :lg="8">
                        <el-form-item
                            label="Price"
                            prop="price"
                        >
                            <el-input
                                type="number"
                                v-model="formData.price_2"
                                placeholder="Price"
                                autocomplete="off"
                            />
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row>
                    <el-divider >
                        <el-text size="large" type="info" style="font-size: var(--el-font-size-large)">
                            Offer 3
                        </el-text>
                    </el-divider>
                </el-row>
                <el-row :gutter="10">
                    <el-col :lg="8">
                        <el-form-item
                            label="Name"
                            prop="name"
                        >
                            <el-input
                                v-model="formData.name_3"
                                placeholder="Name"
                                autocomplete="off"
                            />
                        </el-form-item>
                    </el-col>
                    <el-col :lg="8">
                        <el-form-item
                            label="Quantity"
                            prop="quantity"
                        >
                            <el-input
                                type="number"
                                v-model="formData.quantity_3"
                                placeholder="Quantity"
                                autocomplete="off"
                            />
                        </el-form-item>
                    </el-col>
                    <el-col :lg="8">
                        <el-form-item
                            label="Price"
                            prop="price"
                        >
                            <el-input
                                type="number"
                                v-model="formData.price_3"
                                placeholder="Price"
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
                >Update</el-button
                >
            </span>
        </template>
    </el-dialog>
</template>
<script setup>
import {markRaw, ref} from "@vue/runtime-core";
import {useForm} from "@inertiajs/vue3";
import {Edit} from "@element-plus/icons-vue";

const FormVisible = ref(false);
const refForm = ref(null);
const productName = ref('');

const formData = useForm({
    _method: "PATCH",
    product: "",
    name_1: '',
    quantity_1: '',
    price_1: '',
    name_2: '',
    quantity_2: '',
    price_2: '',
    name_3: '',
    quantity_3: '',
    price_3: '',
});
const showForm = function (data) {
    FormVisible.value = true;
    productName.value = data.name;
    Object.assign(formData, data);
    formData.product = data.slug;
};
const closeForm = () => {
    FormVisible.value = false;
    refForm.value.resetFields();
    formData.reset()
};

const submitForm = () => {
    ElMessageBox.confirm("You are trying to Add Product Offer. Continue?", "Warning", {
        type: "warning",
        icon: markRaw(Edit),
        callback: (action) => {
            if (action == "confirm") {
                console.log(formData.product)
                formData.patch(route("product-offer.update", [formData.product]), {
                    preserveScroll: true,
                    onSuccess: () => {
                        closeForm();
                    },
                    onError: (errors) => {

                    },
                });
            }
        },
    });
}
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
