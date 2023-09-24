<template>
  <Head title="Manage Product"/>
  <section class="product-select-container rounded border-solid border border-gray-300 ">
    <h3 class="p-2  border-b border-gray-300 font-bold text-xl text-lightBlue-600">Select Products
      <el-button type="success" @click="addProduct" :icon="Plus" circle/>
    </h3>
    <div class="product-list p-2 h-[60vh] overflow-y-auto ">
      <el-row :gutter="10">
        <el-col :span="5">
          Name
        </el-col>
        <el-col :span="5">
          Combo
        </el-col>
        <el-col :span="3">
          Rate
        </el-col>
        <el-col :span="3">
          Quantity
        </el-col>
        <el-col :span="3">
          Price
        </el-col>
        <el-col :span="3">
        </el-col>
      </el-row>
      <div v-for="(product, index) in products" :key="index">
        <ProductSelect
            v-model:product="products[index].product"
            v-model:productName="products[index].productName"
            v-model:quantity="products[index].quantity"
            v-model:price="products[index].price"
            v-model:combo="products[index].combo"
            v-model:rate="products[index].rate"
            v-model:comboQuantity="products[index].comboQuantity"
            @remove="removeProduct(index)"
            @addProduct="addProduct"
            @updateCalculation="updateCalculation"
        />
      </div>
    </div>
  </section>
  <section class="mt-3">
    <el-row :gutter="10">
      <el-col :span="16">

      </el-col>
      <el-col :span="8">
        <el-button type="primary" @click="proceedPayment" :icon="Check">Proceed</el-button>
        <el-button type="success" @click="showBillingForm" v-show="!needProcessing" :icon="Money">Billng</el-button>
      </el-col>
    </el-row>
    <el-row :gutter="10" class="mt-2">
      <el-col :span="16">
        Total Price-
      </el-col>
      <el-col :span="8">
        Rs. {{ subtotalAmount }}
      </el-col>
    </el-row>
    <el-row :gutter="10" class="mt-2">
      <el-col :span="16">
        Discount -
      </el-col>
      <el-col :span="8">
        <input type="number" @input="checkDiscount" maxlength="2" max="80" @focus="selectAll"
               class="border border-gray-300 px-2 rounded w-10 text-right" placeholder="%" v-model="discount"/> %
      </el-col>
    </el-row>
    <el-row :gutter="10" class="mt-2 text-2xl">
      <el-col :span="16">
        Final Price -
      </el-col>
      <el-col :span="8" class="text-2xl">
        Rs. {{ totalAmount }}
      </el-col>
    </el-row>
  </section>

  <PaymentBilling ref="refBillingForm"/>
</template>

<script setup>
import {
  Plus, Check, Money
} from '@element-plus/icons-vue'

defineOptions({layout: "admin"});
import {Head} from "@inertiajs/vue3";
import ProductSelect from "./Components/ProcuctSelect.vue";
import PaymentBilling from "./Components/PaymentBilling.vue";
import {ref} from "vue";

const refBillingForm = ref(null);
const needProcessing = ref(true);
const showPaymentBilling = ref(false);
const products = ref([
  {
    product: "",
    productName: "",
    combo: "",
    rate: "",
    quantity: 0,
    price: 0,
    comboQuantity: ''
  }
]);
const addProduct = () => {
  needProcessing.value = true
  products.value.push({
    product: "",
    productName: "",
    combo: "",
    rate: "",
    quantity: 0,
    price: 0,
    comboQuantity: ''
  });
};
const updateCalculation = () => {
  needProcessing.value = true;
}
const subtotalAmount = ref(0);
const discount = ref(0);
const totalAmount = ref(0);
const removeProduct = (index) => {
  needProcessing.value = true
  products.value.splice(index, 1);
};
const selectAll = (event) => {

  event.target.select();
}
const showBillingForm = () => {
  refBillingForm.value.showForm(products, subtotalAmount, discount, totalAmount);
}
const checkDiscount = () => {
  needProcessing.value = true
  if (discount.value > 80) {
    discount.value = 80;
  }
}
const proceedPayment = () => {
  subtotalAmount.value = 0;
  products.value.forEach(function (product) {
    subtotalAmount.value = subtotalAmount.value + product.price
  })
  discount.value
  totalAmount.value = discount.value > 0 ? subtotalAmount.value - (discount.value / 100) * subtotalAmount.value : subtotalAmount.value;
  needProcessing.value = false
}

</script>

<style lang="scss" scoped>
.product-select-container {
  h3 {

  }

  .product-list {

  }
}
</style>
