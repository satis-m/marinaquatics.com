<template>
    <div class="tplist__product d-flex align-items-center justify-content-between mb-6">
        <div class="tplist__product-img grow-0 ">

                <NavLink class="tplist__product-img-one" :href="appRoute('product.view',productInfo.slug)">
                  <ImageWithFallback :source="productInfo.main_picture.thumbnail" :alt="productInfo.slug" />
                </NavLink>

            <div class="tpproduct__info bage">
                <span v-if="productInfo.current_discount != null" class="tpproduct__info-discount bage__discount">{{ productInfo.current_discount.discount }}%</span>
                <span v-if="outOfStock" class="tpproduct__info-hot bage__hot">Out of Stock</span>
                <span v-if="newStock" class="tpproduct__info-hot bage__new">New</span>
            </div>
        </div>
        <div class="tplist__content grow h-52">
            <span>{{ productInfo.category.name }}, {{ productInfo.category.sub_category }}</span>
            <h4 class="tplist__content-title mb-4">   <NavLink :href="appRoute('product.view',productInfo.slug)">{{ productInfo.name }}</NavLink></h4>
            <div  class="tplist__content-info" v-html="productInfo.product_info">
            </div>
        </div>
        <div class="tplist__price grow-0 justify-content-end">
            <h4 class="tplist__instock">Availability: <span>{{ productInfo.available_quantity }} in stock</span> </h4>
            <div class="tpproduct__price mb-15" v-if="productInfo.current_discount === null" >
                <span>Rs {{ productInfo.price }}</span>
            </div>
            <div class="tpproduct__price mb-15" v-else >
                <span>Rs {{ discountedPrice }}</span>
                <del>Rs {{ formattedPrice }}</del>
            </div>

            <button class="tp-btn-2 mb-10 cart_button" @click="addToCart" :disabled="outOfStock" data-bs-toggle="tooltip" data-bs-title="Default tooltip"  :title="productInfo.available_quantity > 0 ? 'Add to cart': 'Out of Stock'" ><i class="icon-add_shopping_cart"></i> add to cart</button>

            <div class="tplist__shopping " v-if="userLoggedIn">
                <a href="#" class="flex h-6"><i class="icon-heart icons"></i> <span>Add to wishlist</span></a>
            </div>
        </div>
    </div>
    <Teleport to="body">
        <Modal @close-modal="showModal=false" v-show="showModal">
            <template v-slot:header>
                Login / sign-Up
            </template>
            <template v-slot:body>
                <p class="mb-4 text-left">Please Login/Sign-Up before continue shopping.</p>
            </template>
            <template v-slot:footer>
                <div class="flex gap-2">
                    <button class="action-btn btn-sm btn-grey" @click="showModal=false">Cancel</button>
                    <NavLink :href="appRoute('client.intended-login')" class="action-btn btn-sm btn-red" >login</NavLink>
                </div>
            </template>
        </Modal>
    </Teleport>
</template>

<script setup>
import Modal from "@/Components/Modal.vue"
import {useAppUtility} from "@admin/Composables/appUtility";
import {ref, computed} from "@vue/runtime-core";
import { useInertiaPropsUtility } from "@admin/Composables/inertiaPropsUtility";
import moment from "moment";
import {useForm} from "@inertiajs/vue3";
import ImageWithFallback from "@/Components/ImageWithFallback.vue";
const { iPropsValue } = useInertiaPropsUtility();
const showModal = ref(false);
const userLoggedIn = iPropsValue('auth')
const props = defineProps({
    productInfo: {
        type: Object,
        required: true
    }
})

const discountedPrice = computed(() => {
    const { price, current_discount: { discount } } = props.productInfo;
    return +price - (+discount / 100) * +price;
})
const outOfStock = computed(() => {
    return props.productInfo.available_quantity < 1
});
const newStock = computed(() => {
    if(props.productInfo.last_import?.created_at != undefined) {
        const currentDate = moment()
        const oneWeekFromNow = moment().add(1, 'week')
        const dateToCheck = moment(props.productInfo.last_import.created_at);
        return dateToCheck.isBefore(oneWeekFromNow);
    }
});
const formattedPrice = computed(() => {
    if (typeof props.productInfo.price !== 'number') {
        return props.productInfo.price;
    }
    return props.productInfo.price.toLocaleString();
})
const addToCart = ()=>{
    // const userLoggedIn = iPropsValue('auth')
    if(userLoggedIn)
    {
        const formData = useForm({
            product_slug: props.productInfo.slug,
            name: props.productInfo.name,
            offer: {
                key: 1,
                name: 'Standard',
                quantity: '1',
                price: props.productInfo.price,
            },
            quantity: 1,
        });
        try {
            formData.post(route("user.cart.add"), {
                preserveScroll: true,
                onSuccess: () => {
                    formData.reset();
                },
            })
        } catch (error) {
            vt.error("Request Form Error")
            console.log(error);
        }
    }
    else
    {
        showModal.value = true;
    }

}
</script>

<style lang="scss" scoped>
.tplist__product-img
{
    border-radius: 5px;
    img{
        width:250px;
        height:250px;
        object-fit: contain;
        border-radius: 5px;
    }
}
.tplist__product
{
    column-gap: 24px;
}
.cart_button {
    &[disabled] {
        color: var(--tp-common-white);
        background-color: #dc7984;
        cursor: not-allowed;
    }
}
</style>
