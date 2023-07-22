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
                <el-row :gutter="10">
                    <el-col :lg="8">
                        <el-form-item
                            label="Combo Name"
                            prop="name"
                        >
                            <el-input
                                v-model="formData.name1"
                                placeholder="Combo Name"
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
                                v-model="formData.quantity1"
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
                                v-model="formData.price1"
                                placeholder="Price"
                                autocomplete="off"
                            />
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row :gutter="10">
                    <el-col :lg="8">
                        <el-form-item
                            label="Combo Name"
                            prop="name"
                        >
                            <el-input
                                v-model="formData.name2"
                                placeholder="Combo Name"
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
                                v-model="formData.quantity2"
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
                                v-model="formData.price2"
                                placeholder="Price"
                                autocomplete="off"
                            />
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row :gutter="10">
                    <el-col :lg="8">
                        <el-form-item
                            label="Combo Name"
                            prop="name"
                        >
                            <el-input
                                v-model="formData.name3"
                                placeholder="Combo Name"
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
                                v-model="formData.quantity3"
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
                                v-model="formData.price3"
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
import {ref} from "@vue/runtime-core";
import {useForm} from "@inertiajs/vue3";

const FormVisible = ref(false);
const viewData = ref();
const refForm = ref(null);
const productName = ref('');
const closeForm = () => {
    FormVisible.value = false;
};
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
};
const submitForm = ()=>{
return true;
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
