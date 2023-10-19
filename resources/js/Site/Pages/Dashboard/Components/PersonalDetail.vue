<template>
  <Head>
    <title>User Dashboard</title>
  </Head>
  <div class="col-md-6 col-12 px-2 inline-block">
    <div class="tptrack__email white-bg mb-2">
      <span><i class="icon-user"></i></span>
      <input type="text" v-model="formData.name" placeholder="Full Name">
      <div class="error-msg"></div>
    </div>
  </div>
  <div class="col-md-6 col-12 px-2 inline-block">
    <div class="tptrack__email white-bg mb-2">
      <span><i class="icon-phone"></i></span>
      <input type="text" v-model="formData.contact" placeholder="Contact">
      <div class="error-msg"></div>
    </div>
  </div>

  <div class="col-md-6 col-12 px-2 inline-block">
    <div class="tptrack__email white-bg mb-2 flex h-[60px]">
      <div class="flex items-center pl-7 pr-2"><i class="icon-map"></i></div>
      <div class="flex items-center grow">
        <select class="h-100 w-full focus-visible:outline-0" v-model="formData.state">
          <option value="">State / Province</option>
          <option value="Bagmati">Bagmati Province</option>
          <option value="Gandaki">Gandaki Province</option>
          <option value="Karnali">Karnali Province</option>
          <option value="Koshi">Koshi Province</option>
          <option value="Lumbini">Lumbini Province</option>
          <option value="Madhesh">Madhesh Province</option>
          <option value="Sudurpashchim">Sudurpashchim Province</option>
        </select>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-12 px-2 inline-block">
    <div class="tptrack__email white-bg mb-2">
      <span><i class="icon-map"></i></span>
      <input type="text" v-model="formData.city" placeholder="City">
      <div class="error-msg"></div>
    </div>
  </div>
  <div class="col-md-6 col-12 px-2 inline-block">
    <div class="tptrack__email white-bg mb-2">
      <span><i class="icon-map-pin"></i></span>
      <input type="text" v-model="formData.address" placeholder="address">
      <div class="error-msg"></div>
    </div>
  </div>
  <div class="col-md-6 col-12 px-2 inline-block">
    <div class="tptrack__email white-bg mb-2">
      <span><i class="icon-calendar"></i></span>
      <input type="text" onfocus="(this.type='date')" onblur="(this.value == '' ? this.type='text' :'')" :min="min_dob"
             :max="max_dob" v-model="formData.dob" placeholder="Birth Date">
      <div class="error-msg"></div>
    </div>
  </div>
  <div class="col-md-6 col-12 px-2 inline-block">
    <p class="mb-2">Gender</p>
    <label class="mr-2">
      <input type="radio" v-model="formData.gender" value="female"> Female
    </label>
    <label class="mr-2">
      <input type="radio" v-model="formData.gender" value="male"> Male
    </label>
    <label class="mr-2">
      <input type="radio" v-model="formData.gender" value="other"> Others
    </label>

  </div>
  <div class="col-12 px-2 inline-block">
    <div class="d-flex justify-content-end gap-3">
      <div class="tptrack__btn">
        <button class="action-btn btn-red relative" type="button" @click="updateUserInfo">Update
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
import {ref, onMounted} from "vue"
import {useForm} from "@inertiajs/vue3";

import {useInertiaPropsUtility} from "@admin/Composables/inertiaPropsUtility";
const {iPropsValue} = useInertiaPropsUtility();

const getDateBeforeYear = (yr) => {
  const currentDate = new Date();

  // Subtract 4 years
  currentDate.setFullYear(currentDate.getFullYear() - yr);

  // Format the date as needed (e.g., to display it)
  const year = currentDate.getFullYear();
  const month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Add 1 because months are 0-indexed
  const day = String(currentDate.getDate()).padStart(2, '0');

  return `${year}-${month}-${day}`;
}

const min_dob = getDateBeforeYear(100)
const max_dob = getDateBeforeYear(6)
const loading = ref(0);
const formData = useForm({
  address: iPropsValue('auth', 'user.address.billing_address'),
  state: iPropsValue('auth', 'user.address.billing_state') ?? '',
  city: iPropsValue('auth', 'user.address.billing_city'),
  name: iPropsValue('auth', 'user.name'),
  contact: iPropsValue('auth', 'user.address.billing_contact'),
  dob: iPropsValue('auth', 'user.dob'),
  gender: iPropsValue('auth', 'user.gender')
})

const updateUserInfo = () => {
  loading.value = true;
  formData.patch(route('client.personal-info.update'), {
    preserveScroll: true,
    onSuccess: () => {
      loading.value = false;
    }
  })
}

</script>
