<template>
    <div class="d-flex gap-2">
        <div class="">
            <img :src="item.main_picture.thumbnail" class="w-[75px] rounded" :alt="item.product_slug">
        </div>
        <div class="tpcart__content grow flex flex-col justify-between px-1">
             <span class="tpcart__content-title ">
                 <NavLink class="cart_close" :href="appRoute('product.view',item.product_slug)">
                       {{
                           item.product_name
                       }} - {{ item.offer_name }}
                 </NavLink>
             </span>

            <div v-if="!outOfStock" class="flex flex-row justify-between align-items-center">
                <CartInput ref="refCartInput"
                           @updateCount="updateCount" @limitReach="handleLimitReach" :size="'sm'"  :max="maxCartInput" :value="item.quantity" :disable="outOfStock" />
                <div class="tpcart__cart-price">
                    <span class="quantity">{{ itemQuantity }} x </span>
                    <span class="new-price">Rs. {{ offerPrice.toLocaleString()}}</span>
                </div>
            </div>
            <div v-else>
                <span class="bg-red-600 text-white text-xs p-1 rounded ">Out of stock</span>
            </div>
        </div>
        <div class="tpcart__action">
            <div class="tpcart__del">
                <button @click="confirmRemove(item.id)"><i class="icon-x-circle"></i></button>
            </div>
        </div>
    </div>
</template>

<script setup>

import Swal from 'sweetalert2'
import {computed,ref, onMounted} from "@vue/runtime-core";

import {useInertiaPropsUtility} from "@admin/Composables/inertiaPropsUtility";
import {useForm} from "@inertiajs/vue3";
import CartInput from "@/Components/CartInput.vue";
const {iPropsValue} = useInertiaPropsUtility();

const emit = defineEmits(['updateItem'])
const refCartInput = ref(null);
const itemPrice = ref(0);
const props = defineProps({
    item: {type: Object, required: true},
})
const itemQuantity = ref(props.item.quantity);
const maxCartInput = ref(0);
const outOfStock = computed(() => {
    return props.item.available_quantity < 1
})
const confirmRemove = (id) => {
    Swal.fire({
        title: '<strong>Cart Update</strong>',
        icon: 'info',
        html: 'Remove Product From Cart ',
        showCloseButton: false,
        showCancelButton: true,
        focusConfirm: true,
        confirmButtonColor:'#d0112b',
        confirmButtonText:
            'Remove',
        confirmButtonAriaLabel: 'Thumbs up, great!',
        cancelButtonText:
            'Cancel',
        cancelButtonAriaLabel: 'Thumbs down'
    }).then((result) => {
        if (result.isConfirmed) {
            try {
                const formData = useForm({ itemId : id});
                formData.delete(route("user.cart.remove"), {
                    preserveScroll: true,
                    onSuccess: (data) => {
                        formData.reset();
                    },
                })
            } catch (error) {
                vt.error("Request Form Error")
                console.log(error);
            }
        }
    })
}

const updateCount = (val)=>{

      const form = useForm({
          itemId : props.item.id,
          quantity: val
      });
      form.patch(route('user.cart.update'),{onSuccess: ()=>{
          itemQuantity.value =val;
          emit('updateItem')
        }});
}
const offerPrice = computed(() => {
  if(props.item.last_discount != null && props.item.offer_name == 'Standard' )
  {
    return +props.item.offer_price - ( (+props.item.last_discount.discount / 100) * +props.item.offer_price);
  }
  return props.item.offer_price;
})
const setMaxQuantity = ()=>{
    maxCartInput.value = Math.floor((props.item.available_quantity / props.item.offer_quantity));
}
const handleLimitReach = ()=>{
    vt.info("stock limit reached")
}
onMounted(()=>{
    setMaxQuantity();
  console.log('moounted')
})

</script>

<style lang="scss" scoped>

</style>
