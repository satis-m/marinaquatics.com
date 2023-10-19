<template>
  <Head>
    <title>Change Password</title>
  </Head>
  <div class="col-md-6 col-12 px-2 mb-2">
    <div class="tptrack__email white-bg ">
      <span><i class="icon-user"></i></span>
      <input type="password" v-model="formData.current_password" placeholder="Current Password">
    </div>
      <div class="error-msg">{{ currentPasswordError}}</div>
  </div>
  <div class="col-md-6 col-12 px-2  mb-2 ">
    <div class="tptrack__email white-bg">
      <span><i class="icon-phone"></i></span>
      <input type="password" v-model="formData.password" @blur="validatePassword" placeholder="New Password">
    </div>
      <div class="error-msg">{{ passwordError }}</div>
  </div>
  <div class="col-md-6 col-12 px-2 mb-2">
    <div class="tptrack__email white-bg ">
      <span><i class="icon-phone"></i></span>
      <input type="password" v-model="formData.password_confirmation" @blur="validateConfirmPassword" placeholder="Confirm Password">
    </div>
      <div class="error-msg">{{ confirmPasswordError }}</div>
  </div>
  <div class="col-12 px-2 inline-block">
    <div class="d-flex justify-content-start gap-3">
      <div class="tptrack__btn">
        <button class="action-btn btn-red relative" v-bind:disabled="!validatePassword() || !validateConfirmPassword()" type="button" @click="updateClientPassword">Update
          <div v-if="loading" class="lds-ring">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
          </div>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref,onMounted} from "vue"
import {useForm} from "@inertiajs/vue3";

import {useInertiaPropsUtility} from "@admin/Composables/inertiaPropsUtility";
const {iPropsValue} = useInertiaPropsUtility();

const loading = ref(false);
const passwordError = ref('');
const confirmPasswordError = ref('');
const currentPasswordError = ref('');
const formData = useForm({
  current_password: '',
  password: '',
  password_confirmation: '',
})

const validatePassword = ()=>{
  if (formData.password.length < 8) {
    passwordError.value = 'Password must be at least 8 characters long';
    return false;
  }
  else
  {
    const containsNumber = /\d/.test(formData.password);
    const containsLowerCase = /[a-z]/.test(formData.password);
    const containsUpperCase = /[A-Z]/.test(formData.password);

    if (!containsNumber || !containsLowerCase || !containsUpperCase) {
      passwordError.value = 'Password must contain at least one number, one lowercase letter, and one uppercase letter';
      return false;
    } else {
      passwordError.value = '';
      return true;
    }
  }

}
const validateConfirmPassword = ()=>{
  if (!validatePassword() || formData.password_confirmation !== formData.password) {
    confirmPasswordError.value = 'Passwords do not match';
    return false;
  }
  confirmPasswordError.value = '';
  return true;
}

const updateClientPassword = ()=>{
  loading.value = true;
  formData.put(route('password.update'), {
    preserveScroll: true,
    onSuccess: () => {
      loading.value = false;
      formData.current_password= ''
      formData.password= ''
      formData.password_confirmation= ''
      currentPasswordError.value = ''
      confirmPasswordError.value = ''
    },
    onError: (errors) => {
      currentPasswordError.value = formData.errors.current_password
      confirmPasswordError.value = formData.errors.password
      loading.value = false;
    },
  })
}
onMounted(()=>{

})
</script>

<style lang="scss" scoped>
.error-msg
{
  color:var(--tp-theme-1);
  font-size: 14px;
}
.action-btn[disabled]
{
  background-color: #d17380;
}
</style>
