<template>
  <Head>
    <title>Chechout</title>
  </Head>
  <!-- breadcrumb-area-start -->
  <div class="breadcrumb__area py-3">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="tp-breadcrumb__content">
            <div class="tp-breadcrumb__list">
              <span class="tp-breadcrumb__active"><NavLink :href="appRoute('homepage')">Home</NavLink></span>
              <span class="dvdr">/</span>
              <span>Checkout</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- breadcrumb-area-end -->
  <section class="checkout-area  pb-50">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-md-12">
          <div class="checkout-form">
            <form @submit.prevent>
              <div class="delivery-type">
                <p class="text-2xl">
                  Delivery
                </p>
                <div class="flex flex-row gap-4 mt-2">
                  <div class="flex items-center ">
                    <input required id="delivery-type-1" v-model="formData.delivery_type" type="radio" value="ship"
                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300  dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                    <label for="delivery-type-1" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Ship
                      to address </label>
                  </div>
                  <div class="flex items-center">
                    <input required id="delivery-type-2" v-model="formData.delivery_type" type="radio" value="pick"
                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                    <label for="delivery-type-2" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Store
                      Pick up</label>
                  </div>

                </div>
              </div>
              <hr class="my-3">
              <p class="text-2xl">
                Billing Details
              </p>
              <div class="row">
                <div class="col-md-6">
                  <div class="country-select">
                    <label>Province / State <span class="required">*</span></label>
                    <select required v-model="formData.billing_info.state" @change="validateBilling('state')">
                      <option value="Bagmati">Bagmati Province</option>
                      <option value="Gandaki">Gandaki Province</option>
                      <option value="Karnali">Karnali Province</option>
                      <option value="Koshi">Koshi Province</option>
                      <option value="Lumbini">Lumbini Province</option>
                      <option value="Madhesh">Madhesh Province</option>
                      <option value="Sudurpashchim">Sudurpashchim Province</option>
                    </select>
                    <div class="error-msg">{{ billingError.state }}</div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="checkout-form-list">
                    <label>Town / City <span class="required">*</span></label>
                    <input required type="text" v-model="formData.billing_info.city" @blur="validateBilling('city')"
                           placeholder="Town / City">
                    <div class="error-msg">{{ billingError.city }}</div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="checkout-form-list">
                    <label>Full Name <span class="required">*</span></label>
                    <input required type="text" v-model="formData.billing_info.full_name"
                           @blur="validateBilling('full_name')" placeholder="">
                    <div class="error-msg">{{ billingError.full_name }}</div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="checkout-form-list">
                    <label>Mobile Number <span class="required">*</span></label>
                    <input required type="text" v-model="formData.billing_info.phone" @blur="validateBilling('phone')"
                           placeholder="">
                    <div class="error-msg">{{ billingError.phone }}</div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="checkout-form-list">
                    <label>Address <span class="required">*</span></label>
                    <input required type="text" v-model="formData.billing_info.address"
                           @blur="validateBilling('address')" placeholder="">
                    <div class="error-msg">{{ billingError.address }}</div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="checkout-form-list">
                    <label>Landmark (optional)</label>
                    <input type="text" v-model="formData.billing_info.landmark" placeholder="">
                  </div>
                </div>
              </div>
              <div class="different-address" v-if="formData.delivery_type == 'ship'">
                <div class="ship-different-title">
                  <h3>
                    <label for="ship-different" class="text-lg text-red">Ship to a different address?</label>
                    <input v-model="formData.ship_different" id="ship-different" type="checkbox">
                  </h3>
                </div>
                <div v-show="formData.ship_different">
                  <div class="row mt-2">
                    <div class="col-md-6">
                      <div class="country-select">
                        <label>Province / State <span class="required">*</span></label>
                        <select v-model="formData.shipping_info.state" @change="validateShipping('state')"
                                v-bind:required="formData.ship_different">
                          <option value="Bagmati">Bagmati Province</option>
                          <option value="Gandaki">Gandaki Province</option>
                          <option value="Karnali">Karnali Province</option>
                          <option value="Koshi">Koshi Province</option>
                          <option value="Lumbini">Lumbini Province</option>
                          <option value="Madhesh">Madhesh Province</option>
                          <option value="Sudurpashchim">Sudurpashchim Province</option>
                        </select>
                        <div class="error-msg">{{ shippingError.state }}</div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="checkout-form-list">
                        <label>Town / City <span class="required">*</span></label>
                        <input type="text" v-model="formData.shipping_info.city" @blur="validateShipping('city')"
                               v-bind:required="formData.ship_different" placeholder="Town / City">
                        <div class="error-msg">{{ shippingError.city }}</div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="checkout-form-list">
                        <label>Full Name <span class="required">*</span></label>
                        <input type="text" v-model="formData.shipping_info.full_name"
                               @blur="validateShipping('full_name')" v-bind:required="formData.ship_different"
                               placeholder="">
                        <div class="error-msg">{{ shippingError.full_name }}</div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="checkout-form-list">
                        <label>Mobile Number <span class="required">*</span></label>
                        <input type="text" v-model="formData.shipping_info.phone" @blur="validateShipping('phone')"
                               v-bind:required="formData.ship_different" placeholder="">
                        <div class="error-msg">{{ shippingError.phone }}</div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="checkout-form-list">
                        <label>Address <span class="required">*</span></label>
                        <input type="text" v-model="formData.shipping_info.address"
                               @blur="validateShipping('address')" v-bind:required="formData.ship_different"
                               placeholder="">
                        <div class="error-msg">{{ shippingError.address }}</div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="checkout-form-list">
                        <label>Landmark (optional)</label>
                        <input type="text" v-model="formData.shipping_info.landmark"
                               v-bind:required="formData.ship_different" placeholder="">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <hr class="my-3">
              <div class="order-notes">
                <div class="checkout-form-list">
                  <label>Order Notes</label>
                  <textarea cols="30" rows="10" v-model="formData.order_note"
                            placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                </div>
              </div>
              <div class="payment-method">
                <p class="text-2xl">
                  Select Payment Method
                </p>
                <div>
                  <div class="flex flex-row gap-4 mt-2">
                    <div class="flex items-center ">
                      <input id="payment-type-1" v-model="formData.payment_method" type="radio" value="bank"
                             class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300  dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                      <label for="payment-type-1" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Bank
                        Transfer </label>
                    </div>
                    <div class="flex items-center">
                      <input id="payment-type-2" v-model="formData.payment_method" type="radio" value="cod"
                             class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                      <label for="payment-type-2" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">cash
                        on delivery</label>
                    </div>

                  </div>
                </div>
              </div>
              <div class="tptrack__btn mt-4" v-if="totalAmount > 0">
                <button class="tptrack__submition active " @click="placeOrder" type="button">Proceed to Payment <i v-if="isLoadingProceed"
                    class="icon-loader spiner"></i>
                  <i v-else
                     class="icon-arrow-right"></i>
                </button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-lg-6 col-md-12">
          <div class="your-order mb-30 ">
            <h3>Your order</h3>
            <div v-if="userCart.length > 0" class="your-order-table table-responsive">
              <table>
                <thead>
                <tr>
                  <th class="product-name">Product</th>
                  <th class="product-total text-right">Total</th>
                </tr>
                </thead>
                <tbody>
                <tr v-memo="[userCart]" :key="key" v-for="(cartItem,key) in userCart" class="cart_item">
                  <td class="product-name">
                    <div class="flex gap-2 justify-start items-center">
                      <div class="relative">
                        <img :src="cartItem.main_picture.thumbnail" class="w-[75px] rounded" :alt="cartItem.product_name">
                        <div
                            class="absolute -top-2 -right-2 border border-gray-50000 bg-gray-800/[.8] text-white px-2 rounded-full">
                          {{ cartItem.quantity }}
                        </div>
                      </div>
                      <div>{{ cartItem.product_name }} - ({{ cartItem.offer_name }} )</div>
                    </div>
                  </td>
                  <td class="product-total text-right">
                    <span class="amount">{{ formattedCurrency(itemTotalPrice(cartItem)) }}</span>
                  </td>
                </tr>
                </tbody>
                <tfoot>
                <tr v-show="formData.delivery_type == 'ship'" class="cart-subtotal">
                  <th>Shipping Charge</th>
                  <td class="text-right"><span class="amount">To be Calculated</span></td>
                </tr>

                <tr class="order-total">
                  <td>Order Total <span class="text-red" v-if="formData.delivery_type == 'ship'" >*</span></td>
                  <td class="text-right"><strong><span class="amount">{{
                      formattedCurrency(totalAmount)
                    }}</span></strong>
                  </td>
                </tr>
                <tr class="order-total">
                  <td colspan="2">
                    <p v-show="formData.delivery_type == 'ship'" class="theme-bg-1 text-white p-2 rounded">NOTE:
                      Shipping charges are calculated based on the size,
                      weight, and destination of the item. You will receive an accurate shipping estimate before
                      delivery of your products.</p>
                  </td>
                </tr>
                </tfoot>
              </table>
            </div>
            <div class="flex flex-col justify-center items-center" v-else>
              <img src="/web-site/assets/img/icon/empty-cart.svg" alt="empty cart" style="width: 75px;">
              <p class="mt-2">Order list is Empty</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- checkout-area end -->

  <Modal @close-modal="showModal=false" v-show="showModal">
    <template v-slot:header>
      Payment Info
    </template>
    <template v-slot:body>
      <div class>
        <p class="bg-red-700 text-white p-2 rounded max-w-xl">
        Please, use your order number in your bank app remark field while making Payment for Payment Verification.
        </p>
        <p class="py-2">
          <b>
            Total Amount:
          </b>
           {{ formattedCurrency(totalAmount)}}
          <br>
          <b>
            Order-No:
          </b>
          {{formData.order_number}}
        </p>
        <div class="flex justify-center mb-4">
            <img class="md:w-1/2" src="https://cdn.britannica.com/17/155017-004-7812A49F/Example-QR-code.jpg?s=1500x700&q=85" alt="bank payment QR">
        </div>
      </div>
    </template>
    <template v-slot:footer>
      <button class="btn btn-danger" @click="confirmOrderWithPayment">
        Confirm Order
        <i v-if="isLoadingConfirm" class="icon-loader spiner"></i>
        <i v-else class="icon-arrow-right"></i>
      </button>
      <button class="btn" @click="showModal=false, formData.order_number = null">Cancel</button>
    </template>
  </Modal>

  <Modal @close-modal="showConfirmModal=false" v-show="showConfirmModal">
    <template v-slot:header>
      Purchase Info
    </template>
    <template v-slot:body>
      <div class="min-h-[140px] max-w-xl mb-4">
       {{ purchaseMessage }}
      </div>
    </template>
    <template v-slot:footer>
      <NavLink class="btn btn-danger" :href="appRoute('client.dashboard.order-history')" >
        View Order History
      </NavLink>
      <NavLink class="btn" :href="appRoute('homepage')">
        Back to Home
      </NavLink>
    </template>
  </Modal>
</template>

<script setup>

import {computed, ref, reactive, watch, onMounted} from "@vue/runtime-core";

import {useInertiaPropsUtility} from "@admin/Composables/inertiaPropsUtility";
import {useNumberUtility} from "@admin/Composables/numberUtility";
import {useForm} from "@inertiajs/vue3";
import {Select} from "@element-plus/icons-vue";
import Modal from "@/Components/Modal.vue"

const {iPropsValue} = useInertiaPropsUtility();
const {formattedCurrency} = useNumberUtility();
const userInfo = reactive(iPropsValue('auth', 'user'))
const showConfirmModal = ref(false);
const showModal = ref(false);
const isLoadingProceed = ref(false);
const isLoadingConfirm = ref(false);

const purchaseMessage = computed(() => {
  let message = '';
  if(formData.delivery_type == "pick"){
    message = "Thank you for your purchase! Your order is being processed and will be ready for pickup within 24 hours. You can track its progress and receive updates on your order history page in your profile or through your email. We'll let you know as soon as it's ready!"
  }
  else
  {
    message = 'Your order is in progress! We\'re carefully preparing your items for shipment. We\'ll contact you shortly to confirm your order details and shipping costs before we send it on its way. Keep an eye out for our email or call!';
  }
  return message;
})
const confirmOrderWithPayment = ()=>{
  isLoadingConfirm.value = true
  try {
    formData.post(route("user.cart.confirm-order"), {
      preserveScroll: true,
      onSuccess: () => {
        showModal.value = false
        isLoadingConfirm.value = false
        showConfirmModal.value = true
      },
    })
  } catch (error) {
    vt.error("Request Cart Error")
    console.log(error);
  }
}
const billingError = reactive({
  state: '',
  city: '',
  full_name: '',
  phone: '',
  address: ''
})
const shippingError = reactive({
  state: '',
  city: '',
  full_name: '',
  phone: '',
  address: ''
})
const formData = useForm({
  delivery_type: 'ship',
  payment_method: 'bank',
  order_note: '',
  order_number: null,
  billing_info: {
    state: userInfo.address.billing_state,
    city: userInfo.address.billing_city,
    full_name: userInfo.name,
    phone: userInfo.address.billing_contact,
    address: userInfo.address.billing_address,
    landmark: ''
  },
  ship_different: false,
  shipping_info: {
    state: '',
    city: '',
    full_name: '',
    phone: '',
    address: '',
    landmark: ''
  }
})
const totalAmount = ref(0);
const userCart = ref(iPropsValue('auth', 'cart'));
watch(() => iPropsValue('auth', 'cart'), () => {
  console.log(iPropsValue('auth', 'cart'));
  userCart.value = iPropsValue('auth', 'cart');
  totalAmount.value = 0;
})

const itemTotalPrice = (item) => {
  let itemTotal = 0;
  if (item.last_discount != null && item.offer_name == 'Standard') {
    itemTotal = (+item.offer_price - (+item.last_discount.discount / 100) * +item.offer_price) * +item.quantity;
  } else {
    itemTotal = (+item.offer_price * +item.offer_quantity) * +item.quantity;
  }
  return itemTotal;
}
const updateTotal = ()=>{
  totalAmount.value = 0;
  userCart.value.forEach(item => {
    let itemTotal = 0;
    if (item.last_discount != null && item.offer_name == 'Standard') {
      itemTotal = (+item.offer_price - (+item.last_discount.discount / 100) * +item.offer_price) * +item.quantity;
    } else {
      itemTotal = (+item.offer_price * +item.offer_quantity) * +item.quantity;
    }
    totalAmount.value = +totalAmount.value + +itemTotal
  });
}
const validateBilling = (input) => {
  if (formData.billing_info[input] == '' || formData.billing_info[input] == null) {
    billingError[input] = 'Please fill out this field'
  } else {
    billingError[input] = ''
  }
}
const validateShipping = (input) => {
  if (formData.shipping_info[input] == '' || formData.shipping_info[input] == null) {
    shippingError[input] = 'Please fill out this field'
  } else {
    shippingError[input] = ''
  }
}
const formValid = () => {
  if (formData.billing_info.phone == '' ||formData.billing_info.phone == null
      || formData.billing_info.state == '' ||formData.billing_info.state == null
      || formData.billing_info.city == '' ||formData.billing_info.city == null
      || formData.billing_info.address == '' ||formData.billing_info.address == null
      || formData.billing_info.full_name == '' ||formData.billing_info.full_name == null
  ) {
    validateBilling('phone')
    validateBilling('state')
    validateBilling('city')
    validateBilling('address')
    validateBilling('full_name')
    return false
  }

  if (formData.ship_different == true && formData.delivery_type == 'ship') {
    if (formData.shipping_info.phone == '' || formData.shipping_info.phone == null
        || formData.shipping_info.state == '' || formData.shipping_info.state == null
        || formData.shipping_info.city == '' || formData.shipping_info.city == null
        || formData.shipping_info.address == '' || formData.shipping_info.address == null
        || formData.shipping_info.full_name == '' || formData.shipping_info.full_name == null
    ) {
      validateShipping('phone')
      validateShipping('state')
      validateShipping('city')
      validateShipping('address')
      validateShipping('full_name')
      return false
    }
  }

  return true;
}
const placeOrder = () => {
  if (formValid()) {
    isLoadingProceed.value= true
    axios.get(route("cart.order-no-request"))
        .then(response => {
          showModal.value = true
          formData.order_number =  response.data
          isLoadingProceed.value= false
        })
        .catch(error => {
          vt.error(error.response.data.message)
        })
  } else {
    window.scrollTo({
      top: 0,
      behavior: 'smooth' // You can also use 'auto' for instant scrolling
    });
    vt.info('please input all the required information before checkout')
  }

}

onMounted(()=>{
  updateTotal()
})
</script>

<style lang="scss" scoped>
.checkout-form {
  background-color: #f6f6f6;
  border-top: 3px solid rgba(150, 174, 0, 0.3);
  font-size: 14px;
  font-weight: 600;
  margin: 0 0 25px;
  padding: 1em 2em;
  position: relative;
  width: auto;
}

.checkout-form-list, .country-select {
  font-size: 16px;
  font-weight: 500;
}

.country-select select {
  background-color: white;
}

.error-msg {
  color: var(--tp-theme-1);
  font-size: 14px;
}

</style>