<template>
    <el-dialog
        v-model="FormVisible"
        :before-close="closeForm"
        title="Product Billing"
    >
        <template #default>
            <el-form
                @submit.prevent
                :model="formData.billingInfo"
                :rules="rules"
                ref="refForm"
                label-position="top"
                :scroll-to-error="true"
                status-icon
            >
                <el-row :gutter="10">
                    <el-col :lg="12">
                        <el-form-item
                            label="Client Name"
                            prop="name"
                            :error="formErrors.name"
                        >
                            <el-input
                                v-model="formData.billingInfo.name"
                                placeholder="Client Name"
                                autocomplete="off"
                            />
                        </el-form-item>
                    </el-col>
                    <el-col :lg="12">
                        <el-form-item
                            label="Contact"
                            prop="contact"
                            :error="formErrors.contact"
                        >
                            <el-input
                                v-model="formData.billingInfo.contact"
                                placeholder="Contact Number"
                                autocomplete="off"
                            />
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row :gutter="10">
                    <el-col :lg="12">
                        <el-form-item
                            label="Address"
                            prop="address"
                        >
                            <el-input
                                v-model="formData.billingInfo.address"
                                placeholder="Client Address"
                                autocomplete="off"
                            />
                        </el-form-item>
                    </el-col>
                    <el-col :lg="12">
                        <el-form-item
                            label="Vat/Pan"
                            prop="vatpan"
                        >
                            <el-input
                                v-model="formData.billingInfo.vatpan"
                                placeholder="VAT / PAN Number"
                                autocomplete="off"
                            />
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row :gutter="10">
                    <el-col :lg="12">
                        <el-form-item
                            label="Payment Method"
                            prop="payment_method"
                            :error="formErrors.payment_method"
                        >
                            <el-select v-model="formData.billingInfo.payment_method" placeholder="Select">
                                <el-option label="Cash" value="cash"/>
                                <el-option label="Esewa" value="esewa"/>
                                <el-option label="Khalti" value="khalti"/>
                                <el-option label="Fonepay" value="fonepay"/>
                                <el-option label="Connect IPS" value="connectIPS"/>
                                <el-option label="Bank Transfer" value="bank"/>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :lg="12">
                        <el-form-item
                            label="Payment Info"
                            prop="payment_info"
                        >
                            <el-input
                                v-model="formData.billingInfo.payment_info"
                                placeholder="Payment Info"
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
                > Create Bill</el-button>
            </span>
        </template>
    </el-dialog>
</template>

<script setup>
import {reactive, ref, unref} from "@vue/runtime-core";
import {useForm} from "@inertiajs/vue3";

const formData = useForm({
    _method: "POST",
    products: [],
    subtotalAmount: 0,
    discount: 0,
    totalAmount: 0,
    billingInfo: {
        payment_method: '',
        payment_info: '',
        name: '',
        contact: '',
        address: '',
        vatpan: '',
    },
});
const rules = reactive({
    name: [
        {
            required: true,
            message: "Please input client name",
            trigger: "blur",
        },
    ],
    contact: [
        {
            required: true,
            message: "Please input client number",
            trigger: "blur",
        },
    ],
    payment_method: [
        {
            required: true,
            message: "Please input Payment method",
            trigger: "change",
        },
    ],
});
const formErrors = reactive({
    name: null,
    contact: null,
});
const FormVisible = ref(false);
const refForm = ref(null);
const showForm = (products, subtotalAmount, discount, totalAmount) => {
    formData.products = unref(products);
    formData.subtotalAmount = unref(subtotalAmount)
    formData.discount = unref(discount)
    formData.totalAmount = unref(totalAmount)

    FormVisible.value = true;
}

const closeForm = () => {
    FormVisible.value = false;
    resetForm(refForm.value);
    formData.reset();
};
const submitForm = async (formEl) => {
    if (!formEl) return;
    await formEl.validate((valid, fields) => {
        if (valid) {
            createBill();
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
const resetForm = (formEl) => {
    if (!formEl) return;

    formEl.resetFields();
    formData.reset();
};
const createBill = () => {
    formData.post(route("order.store"), {
        preserveScroll: true,
        onSuccess: () => {
            closeForm();
        },
        onError: (errors) => {
        },
    });
}

defineExpose({
    showForm,
});
</script>

<style lang="scss" scoped>

</style>
