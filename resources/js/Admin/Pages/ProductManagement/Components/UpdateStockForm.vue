<template>
    <el-dialog
        v-model="FormVisible"
        :before-close="closeForm"
        :title="'Update Stock of '+productName"
    >
        <template #default>
            <el-tabs v-model="activeForm" @tab-change="handleTabChange" class="demo-tabs">
                <el-tab-pane label="Import Product" name="import">
                    <el-form
                        @submit.prevent
                        label-position="top"
                        :model="formDataImport"
                        ref="refFormDataImport"
                        :rules="rules"
                        :scroll-to-error="true"
                    >
                        <el-row :gutter="10">
                            <el-col :lg="8">
                                <el-form-item label="Importer Name" prop="importer">
                                    <el-select
                                        v-model="formDataImport.importer"
                                        filterable
                                        clearable
                                        allow-create
                                        default-first-option
                                        placeholder="Choose your Importer"
                                    >
                                        <el-option
                                            v-for="(item,key) in  importers"
                                            :key="key"
                                            :label="item"
                                            :value="item"
                                        >
                                            <span style="float: left">{{ item }}</span>
                                            <el-button class="float-right" type="danger" size="small"
                                                       @click="deleteImporter(item)" :icon="Delete" circle/>
                                        </el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>
                            <el-col :lg="8">
                                <el-form-item label="Quantity" prop="quantity">
                                    <el-input
                                        type="number"
                                        v-model="formDataImport.quantity"
                                    />
                                </el-form-item>
                            </el-col>

                            <el-col :lg="8">
                                <el-form-item label="Cost Price" prop="cost_price">
                                    <el-input type="number" v-model="formDataImport.cost_price"/>
                                </el-form-item>
                            </el-col>
                        </el-row>

                    </el-form>
                    <el-row justify="end">
                        <el-button @click="resetForm('import')">Reset</el-button>
                        <el-button @click="closeForm()">Cancel</el-button>
                        <el-button
                            type="primary"
                            @click="submitForm(refFormDataImport)"
                        >{{ FormAction }}
                        </el-button>
                    </el-row>
                    <el-divider/>
                    <el-row>

                        <el-table :data="latestProductImport" style="width: 100%">
                            <el-table-column prop="importer" label="Importer" />
                            <el-table-column prop="quantity" :label="'Quantity ('+productUnit+')'" />
                            <el-table-column prop="cost_price" label="Cost Price"/>
                            <el-table-column
                                align="center"
                                fixed="right"
                                label="Action"
                                width="75px"
                            >
                                <template #default="scope">
                                    <el-button type="primary" size="small" @click="populateImportFormData(scope.row)" :icon="Edit" circle />
                                </template>
                            </el-table-column>
                        </el-table>
                    </el-row>
                </el-tab-pane>
                <el-tab-pane label="Damaged Product" name="damage">
                    <el-form
                        label-position="top"
                        :model="formDataDamage"
                        @submit.prevent
                        ref="refFormDataDamage"
                        :rules="rules"
                        :scroll-to-error="true"

                    >
                        <el-row :gutter="10">
                            <el-col :lg="6">

                                <el-form-item label="Importer Name" prop="importer">
                                    <el-select
                                        v-model="formDataDamage.importer"
                                        filterable
                                        clearable
                                        default-first-option
                                        placeholder="Choose your Importer"
                                    >
                                        <el-option
                                            v-for="(item,key) in  importers"
                                            :key="key"
                                            :label="item"
                                            :value="item"
                                        />
                                    </el-select>
                                </el-form-item>
                            </el-col>
                            <el-col :lg="6">
                                <el-form-item label="Quantity" prop="quantity">
                                    <el-input
                                        type="number"
                                        v-model="formDataDamage.quantity"
                                        />
                                </el-form-item>
                            </el-col>
                            <el-col :lg="6">
                                <el-form-item label="Cost Price" prop="cost_price">
                                    <el-input type="number" v-model="formDataDamage.cost_price"/>
                                </el-form-item>
                            </el-col>
                            <el-col :lg="6">
                                <el-form-item label="Remark" prop="remark">
                                    <el-input type="text" v-model="formDataDamage.remark"/>
                                </el-form-item>
                            </el-col>
                        </el-row>

                    </el-form>
                    <el-row justify="end">
                        <el-button @click="resetForm('damage')">Reset</el-button>
                        <el-button @click="closeForm()">Cancel</el-button>
                        <el-button
                            type="primary"
                            @click="submitForm(refFormDataDamage)"
                        >{{ FormAction }}
                        </el-button>
                    </el-row>
                    <el-divider/>
                    <el-row>
                        <el-table :data="latestProductDamage" style="width: 100%">
                            <el-table-column prop="importer" label="Importer" />
                            <el-table-column prop="quantity" :label="'Quantity ('+productUnit+')'" />
                            <el-table-column prop="cost_price" label="Cost Price"/>
                            <el-table-column prop="remark" label="Remark"/>
                            <el-table-column
                                align="center"
                                fixed="right"
                                label="Action"
                                width="75px"
                            >
                                <template #default="scope">
                                    <el-button type="primary" size="small" @click="populateDamageFormData(scope.row)" :icon="Edit" circle />
                                </template>
                            </el-table-column>
                        </el-table>

                    </el-row>
                </el-tab-pane>
            </el-tabs>

        </template>
    </el-dialog>
</template>
<script setup>
import {ref, reactive, onMounted, markRaw, watch} from "@vue/runtime-core";
import {useForm} from "@inertiajs/vue3";
import {useInertiaPropsUtility} from "@/Composables/inertiaPropsUtility";
import {
    Delete,
    Edit
} from "@element-plus/icons-vue";

const {iPropsValue} = useInertiaPropsUtility();

const productUnit = ref('')
const activeForm = ref('import')
const FormVisible = ref(false);
const productName = ref('');
const FormAction = ref('Add');
const refFormDataImport = ref(null);
const refFormDataDamage = ref(null);
const latestProductImport = ref([]);
const latestProductDamage = ref([]);
const importers = ref(iPropsValue("importers"));
watch(() => iPropsValue("importers"),
    () => {
        importers.value = iPropsValue("importers")
    }
)
const formDataImport = useForm({
    _method: "POST",
    product: "",
    quantity: '',
    cost_price: '',
    importer: '',
    prev_quantity:0,
    id: "",
});
const formDataDamage = useForm({
    _method: "POST",
    product: "",
    quantity: '',
    cost_price: '',
    prev_quantity:0,
    importer: '',
    remark: '',
    id: "",
});
const rules = reactive({
    importer: [
        {
            required: true,
            message: "Please input Importer name",
            trigger: "blur",
        },
    ],
    cost_price: [
        {
            required: true,
            message: "Please input cost price",
            trigger: "blur",
        },
    ],

    quantity: [
        {
            required: true,
            message: "Please input quantity",
            trigger: "blur",
        }
    ]

});
const resetForm = (formName)=> {
    FormAction.value='Add';
    if (formName == 'import') {
        refFormDataImport.value.resetFields();
        formDataImport.reset();
    } else {
        refFormDataDamage.value.resetFields();
        formDataDamage.reset();
    }
}
const closeForm = (formName) => {
    FormVisible.value = false;
    latestProductImport.value = []
    latestProductDamage.value = []
    resetForm(formName);
};

const showForm = function (data) {
    FormVisible.value = true;
    formDataImport.reset();
    formDataDamage.reset();
    productName.value = data.name
    formDataImport.product = data.slug
    formDataDamage.product = data.slug
    productUnit.value=data.unit
    getLatestImport(data.slug)
    getLatestDamage(data.slug)
    // formData.reset();
};
const submitForm = async (formEl) => {
    if (!formEl) return;
    await formEl.validate((valid, fields) => {
        if (valid) {
            if (activeForm.value == "import") {
                if (FormAction.value == 'Add') {
                    formDataImport._method = "POST";
                    createImport();
                } else {
                    formDataImport._method = "PATCH";
                    updateImport();
                }

            } else {
                if (FormAction.value == 'Add') {
                    formDataDamage._method = "POST";
                    createDamage();
                } else {
                    formDataDamage._method = "PATCH";
                    updateDamage();
                }

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

}

const createImport = async function () {
    ElMessageBox.confirm("You are trying to Add Product. Continue?", "Warning", {
        type: "warning",
        icon: markRaw(Edit),
        callback: (action) => {
            if (action == "confirm") {

                formDataImport.post(route("product-import.store", [formDataImport.product]), {
                    preserveScroll: true,
                    onSuccess: () => {
                        closeForm('import');
                    },
                    onError: (errors) => {

                    },
                });
            }
        },
    });
};
const updateImport = function () {
    ElMessageBox.confirm("You are trying to edit. Continue?", "Warning", {
        type: "warning",
        icon: markRaw(Edit),
        callback: (action) => {
            if (action == "confirm") {
                try {

                    formDataImport.post(route("product-import.update", [formDataImport.product, formDataImport.id]), {
                        preserveScroll: true,
                        onSuccess: () => {
                            closeForm('import');
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

const createDamage = async function () {
    ElMessageBox.confirm("You are trying to Add Product. Continue?", "Warning", {
        type: "warning",
        icon: markRaw(Edit),
        callback: (action) => {
            if (action == "confirm") {

                formDataDamage.post(route("product-damage.store", [formDataDamage.product]), {
                    preserveScroll: true,
                    onSuccess: () => {
                        closeForm('damage');
                    },
                    onError: (errors) => {

                    },
                });
            }
        },
    });
};
const updateDamage = function () {
    ElMessageBox.confirm("You are trying to edit. Continue?", "Warning", {
        type: "warning",
        icon: markRaw(Edit),
        callback: (action) => {
            if (action == "confirm") {
                try {

                    formDataDamage.post(route("product-damage.update", [formDataDamage.product, formDataDamage.id]), {
                        preserveScroll: true,
                        onSuccess: () => {
                            closeForm('damage');
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

const getLatestImport = (productSlug) => {
    axios.get(route('product.import-list.latest', productSlug))
        .then(response => {
            // Handle the JSON response data
            latestProductImport.value = response.data.results;
            // Use the data as needed
        })
        .catch(error => {
            // Handle any errors
        });
}
const getLatestDamage = (productSlug) => {
    axios.get(route('product.damage-list.latest', productSlug))
        .then(response => {
            // Handle the JSON response data
            latestProductDamage.value = response.data.results;
            // Use the data as needed
        })
        .catch(error => {
            // Handle any errors
        });
}

const deleteImporter = (item) => {
    axios.delete(route('importer', item))
        .then(response => {
            if (response.data == 1) {
                ElNotification({
                    title: 'Importer Deleted',
                    type: "success",
                });
                importers.value = importers.value.filter((data) => {
                    return data != item
                })
                formDataImport.importer = '';
            }

        })
        .catch(error => {
            // Handle any errors
        });
}

const populateImportFormData = function (data) {
    FormAction.value='Update';
    Object.assign(formDataImport, data);
    formDataImport.prev_quantity =data.quantity
};
const populateDamageFormData = function (data) {
    FormAction.value='Update';
    Object.assign(formDataDamage, data);
    formDataDamage.prev_quantity = data.quantity
};


defineExpose({
    showForm,
});

</script>

<style>
.el-select-dropdown__item {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
</style>
