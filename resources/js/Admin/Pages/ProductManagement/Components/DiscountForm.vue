<template>
    <el-dialog
        v-model="FormVisible"
        :before-close="closeForm"
        :title="'Discount Offer for '+productName "
    >
        <template #default>
            <el-form
                :rules="rules"
                @submit.prevent
                :model="formData"
                ref="refForm"
                label-position="top"
                :scroll-to-error="true"
                status-icon
            >
                <el-row :gutter="10">
                    <el-col :lg="6">
                        <el-form-item
                            label="Discount"
                            prop="discount"
                        >
                            <el-input
                                type="number"
                                v-model.number="formData.discount"
                                placeholder="Product Discount"
                                autocomplete="off"
                                clearable
                            >
                                <template #append>%</template>
                            </el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :lg="10">
                        <el-form-item
                            label="Date"
                            prop="date"
                        >
                            <el-date-picker
                                v-model="formData.date"
                                type="datetimerange"
                                range-separator="To"
                                start-placeholder="Start date"
                                end-placeholder="End date"
                                format="YYYY-MM-DD HH:mm:ss"
                                value-format="YYYY-MM-DD HH:mm:ss"
                            />
                        </el-form-item>
                    </el-col>

                    <el-col :lg="8">
                        <el-form-item
                            label="Remark"
                            prop="remark"
                        >
                            <el-input
                                type="text"
                                v-model="formData.remark"
                                placeholder="Discount Remark"
                                autocomplete="off"
                                clearable
                            />
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row justify="end">
                    <el-button @click="closeForm()">Cancel</el-button>
                    <el-button
                        type="primary"
                        :loading="formData.processing"
                        @click="submitForm(refForm)"
                    >{{ FormType == "Add" ? "Add" : "Update" }}
                    </el-button>

                </el-row>
            </el-form>
            <el-divider/>
            <el-row>
                <el-table :data="latestProductDiscount" style="width: 100%">
                    <el-table-column prop="discount" label="Discount %">
                        <template #default="scope">
                            {{ scope.row.discount}}
                            <el-tag class="ml-2" v-if="isActiveDiscount(scope.row)" size="small" type="success">Active</el-tag>
                            <el-tag class="ml-2" v-else size="small" type="danger">Expired</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column prop="start_date" label="Start Date"/>
                    <el-table-column prop="end_date" label="End Date"/>
                    <el-table-column prop="remark" label="Remark"/>
                    <el-table-column
                        align="center"
                        fixed="right"
                        label="Action"
                        width="75px"
                    >
                        <template #default="scope">
                            <el-button type="primary" size="small" @click="populateFormData(scope.row)" :icon="Edit"
                                       circle/>
                        </template>
                    </el-table-column>
                </el-table>

            </el-row>
        </template>
    </el-dialog>
</template>
<script setup>
import {markRaw, reactive, ref} from "@vue/runtime-core";
import {useForm} from "@inertiajs/vue3";
import {Edit} from "@element-plus/icons-vue";

const FormVisible = ref(false);
const FormType = ref('Add');
const productName = ref('');
const latestProductDiscount = ref([]);
const refForm = ref(null);

const formData = useForm({
    _method: "POST",
    discount: '',
    date: '',
    product: '',
    id: "",
    remark: "",
});
const checkDiscount = (rule, value, callback) => {
    if (!value) {
        return callback(new Error('Please input the discount'))
    }
    setTimeout(() => {
        if (!Number.isInteger(value)) {
            callback(new Error('Please input digits'))
        } else {
            if (value < 1 || value > 99) {
                callback(new Error('Discount must be between 1 to  99'))
            } else {
                callback()
            }
        }
    }, 400)
}
const rules = reactive({
    discount: [
        {
            validator: checkDiscount,
            trigger: "blur",
        },
    ],
    date: [
        {
            required: true,
            message: "Please input Product Discount",
            trigger: "change",
        },
    ],

});

const populateFormData = (data) => {
    FormType.value='Update';
    Object.assign(formData, data);
    formData.date = [
        data.start_date, data.end_date
    ]
}

const showForm = function (data) {
    FormVisible.value = true;
    productName.value = data.name;
    formData.product = data.slug;
    getLatestDiscount(data.slug);
};
const closeForm = () => {
    FormVisible.value = false;
    refForm.value.resetFields();
    formData.reset();
};
const submitForm = async (formEl) => {
    if (!formEl) return;
    await formEl.validate((valid, fields) => {
        if (valid) {
            if (FormType.value == "Add") {
                formData._method = "POST";
                create();
            } else {
                formData._method = "PATCH";
                update();
            }
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

const create = async function () {
    ElMessageBox.confirm("You are trying to Add Product. Continue?", "Warning", {
        type: "warning",
        icon: markRaw(Edit),
        callback: (action) => {
            if (action == "confirm") {
                // clearServerValidationError();
                formData.post(route("product-discount.store", [formData.product]), {
                    preserveScroll: true,
                    onSuccess: () => {
                        closeForm();
                    },
                    onError: (errors) => {
                        // loadServerValidationError();
                    },
                });
            }
        },
    });
};
const update = function () {
    ElMessageBox.confirm("You are trying to edit. Continue?", "Warning", {
        type: "warning",
        icon: markRaw(Edit),
        callback: (action) => {
            if (action == "confirm") {
                try {
                    formData.post(route("product-discount.update", [formData.product, formData.id]), {
                        preserveScroll: true,
                        onSuccess: () => {
                            closeForm();
                        },
                        onError: (errors) => {
                        },
                    });
                } catch (error) {
                    ElNotification({
                        title: "Error",
                        message: "Request Form Error.",
                        type: "error",
                    });
                    console.log(error);
                }
            }
        },
    });
};

const getLatestDiscount = (productSlug) => {
    axios.get(route('product.discount.latest', productSlug))
        .then(response => {
            // Handle the JSON response data
            latestProductDiscount.value = response.data.results;
            // Use the data as needed
        })
        .catch(error => {
            // Handle any errors
        });
}

const isActiveDiscount = (row)=>{
    if(Object.keys(row).length != 0)
    {
        const startDate = new Date(row.start_date); // Replace with your start date
        const endDate = new Date(row.end_date);
        const today = new Date();
        return today >= startDate && today <= endDate;
    }
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
