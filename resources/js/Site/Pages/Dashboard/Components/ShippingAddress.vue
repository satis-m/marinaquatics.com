<template>
  <Head>
    <title>Shipping Information</title>
  </Head>
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
      <input type="text" v-model="formData.city" placeholder="Shipping City">
      <div class="error-msg"></div>
    </div>
  </div>
  <div class="col-md-6 col-12 px-2 inline-block">
    <div class="tptrack__email white-bg mb-2">
      <span><i class="icon-map-pin"></i></span>
      <input type="text" v-model="formData.address" placeholder="Shipping address">
      <div class="error-msg"></div>
    </div>
  </div>
  <div class="col-md-6 col-12 px-2 inline-block">
    <div class="tptrack__email white-bg mb-2">
      <span><i class="icon-phone"></i></span>
      <input type="text" v-model="formData.contact" placeholder="Shipping Contact">
      <div class="error-msg"></div>
    </div>
  </div>
  <div class="col-md-6 col-12 px-2 inline-block">
    <div class="tptrack__email white-bg mb-2">
      <span><i class="icon-map-pin"></i></span>
      <input type="text" v-model="formData.landmark" placeholder="Shipping Landmark">
      <div class="error-msg"></div>
    </div>
  </div>
  <div class="col-12 px-2 inline-block">
    <div class="d-flex justify-content-end gap-3">
      <div class="tptrack__btn">
        <button class="action-btn btn-red relative" type="button" @click="updateShippingInfo">Update
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
const formData = useForm({
  address: iPropsValue('auth', 'user.address.shipping_address'),
  state: iPropsValue('auth', 'user.address.shipping_state') ?? '',
  city: iPropsValue('auth', 'user.address.shipping_city'),
  contact: iPropsValue('auth', 'user.address.shipping_contact'),
  landmark: iPropsValue('auth', 'user.address.shipping_landmark'),
})
const updateShippingInfo = ()=>{
  loading.value = true;
  formData.patch(route('client.shipping-info.update'), {
    preserveScroll: true,
    onSuccess: () => {
      loading.value = false;
    }
  })
}
onMounted(()=>{

})
</script>
