<template>
  <el-dialog
      v-model="FormVisible"
      :before-close="closeForm"
      :title="'Update Order status: ' +orderData.order_no "
      width="36%"
  >
    <template #default>
      <el-form
          :label-position="isScreenMd ? 'top':'left'"
          label-width="120px"
          ref="refForm"
          :model="formData"
          status-icon
      >

        <el-row :gutter="10" >
          <el-col :xl="18">
            <el-form-item
                label="Delivery Date"
                prop="discount"
            >
              <el-date-picker
                  v-model="formData.delivery_on"
                  type="date"
                  format="YYYY-MM-DD"
                  value-format="YYYY-MM-DD"
                  :disabled="orderData.order_status == 'delivered'"
              />
            </el-form-item>
          </el-col>
        </el-row>
        <el-row :gutter="10">
          <el-col :xl="18">
            <el-form-item
                label="Payment Status"
                prop="discount"
            >

                <el-select v-model="formData.payment_status" placeholder="Payment status">
                  <el-option label="Pending" v-if="orderData.payment_status != 'verified'" value="pending"/>
                  <el-option label="Verified" value="verified"/>
                </el-select>

            </el-form-item>
          </el-col>
        </el-row>
        <el-row :gutter="10">
          <el-col :xl="18">
            <el-form-item
                label="Order Status"
                prop="discount"
            >
              <el-select v-model="formData.order_status" @change="checkStatus" placeholder="Order Status">
                <el-option label="Queue" v-if="orderData.order_status != 'processing' && orderData.order_status != 'shipped' && orderData.order_status != 'delivered'" value="queue"/>
                <el-option label="Processing" v-if="orderData.order_status != 'shipped' && orderData.order_status != 'delivered'" value="processing"/>
                <el-option label="Shipped" v-if="orderData.order_status != 'delivered'" value="shipped"/>
                <el-option label="Delivered"  value="delivered"/>
              </el-select>
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
                    @click="updateStatus"
                >Update</el-button
                >
            </span>
    </template>
  </el-dialog>
</template>

<script setup>
import {markRaw, ref} from "@vue/runtime-core";
import {useForm} from "@inertiajs/vue3";
import {useAppUtility} from "@/Composables/appUtility";
import {Edit} from "@element-plus/icons-vue";
const { isScreenMd } = useAppUtility();
const FormVisible = ref(false);
const orderData = ref('');
const refForm = ref();
const showForm = function (order) {
  orderData.value = order;
  FormVisible.value = true;
  formData.payment_status = order.payment_status
  formData.order_status = order.order_status
};
const formData = useForm({
  payment_status : '',
  order_status : '',
  delivery_on : '',
})
const closeForm = () => {
  FormVisible.value = false;
  resetForm(refForm.value);
  formData.reset();
};

const updateStatus = function () {
  ElMessageBox.confirm("You are trying to Update Order Status. Continue?", "Warning", {
    type: "warning",
    icon: markRaw(Edit),
    callback: (action) => {
      if (action == "confirm") {
        try {
          formData.patch(route("order.update-status", orderData.value.order_no), {
            preserveScroll: true,
            onSuccess: () => {
              closeForm();
            },
            onError: (errors) => {
              loadServerValidationError();
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
const checkStatus = ()=>{
  if(formData.order_status == 'delivered')
  {
    formData.payment_status = 'verified'
  }
}
defineExpose({
  showForm,
});
</script>

<style lang="scss" scoped>

</style>