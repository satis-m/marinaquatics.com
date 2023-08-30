<template>
    <div class="tpproduct p-relative">
        <div class="tpproduct__thumb p-relative text-center">
                <NavLink :href="appRoute('product.view',productInfo.slug)">
                    <img :src="getImageLink(productInfo.main_picture , 'thumbnail')"  alt="">
                </NavLink>

            <div class="tpproduct__info bage">
                <span v-if="productInfo.current_discount != null" class="tpproduct__info-discount bage__discount">{{ productInfo.current_discount.discount }}%</span>
                <span v-if="outOfStock" class="tpproduct__info-hot bage__hot">Out of Stock</span>
            </div>
            <div class="tpproduct__shopping">
                <button type="button" class="tpproduct__shopping-wishlist" href="wishlist.html"><i class="icon-heart icons"></i></button>
<!--                <a class="tpproduct__shopping-wishlist" href="#"><i class="icon-layers"></i></a>-->
<!--                <a class="tpproduct__shopping-cart" href="#"><i class="icon-eye"></i></a>-->
            </div>
        </div>
        <div class="tpproduct__content">
             <span class="tpproduct__content_category capitalize">
             <a href="shop-details-4.html">{{ productInfo.category.name }}</a>,
             <a href="shop-details-4.html">{{ productInfo.category.sub_category }}</a>
             </span>
            <h4 class="tpproduct__title capitalize">
                <NavLink :href="appRoute('product.view',productInfo.slug)">{{ productInfo.name }}</NavLink>
            </h4>
<!--            <div class="tpproduct__rating mb-5">-->
<!--                <a href="#"><i class="icon-star_outline1"></i></a>-->
<!--                <a href="#"><i class="icon-star_outline1"></i></a>-->
<!--                <a href="#"><i class="icon-star_outline1"></i></a>-->
<!--                <a href="#"><i class="icon-star_outline1"></i></a>-->
<!--                <a href="#"><i class="icon-star_outline1"></i></a>-->
<!--            </div>-->
            <div class="d-flex justify-content-between align-items-center">
                <div class="tpproduct__price" v-if="productInfo.current_discount === null" >
                    <span>Rs {{ productInfo.price }}</span>
                </div>
                    <div class="tpproduct__price" v-else >
                    <span>Rs {{ discountedPrice }}</span>
                    <del>Rs {{ formattedPrice }}</del>
                </div>

                <div class="tpproduct__hover-btn d-flex justify-content-center" >
                    <button type="button" @click="addToCart" :disabled="outOfStock" class="cart_button rounded-pill" data-bs-toggle="tooltip" data-bs-title="Default tooltip" :title="productInfo.available_quantity > 0 ? 'Add to cart': 'Out of Stock'"><i class="icon-add_shopping_cart"></i></button>
                </div>
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
import {useAppUtility} from "@admin/Composables/appUtility";
import {computed} from "@vue/runtime-core";
import { useInertiaPropsUtility } from "@admin/Composables/inertiaPropsUtility";
import Modal from "@/Components/Modal.vue"
import {ref} from "vue";

const { iPropsValue } = useInertiaPropsUtility();
const {getImageLink} = useAppUtility();
const props = defineProps({
    productInfo: {
        type: Object,
        required: true
    }
})
const showModal = ref(false);
const discountedPrice = computed(() => {
    const { price, current_discount: { discount } } = props.productInfo;
    return +price - (+discount / 100) * +price;
})
const outOfStock = computed(() => {
    return props.productInfo.available_quantity < 1
});
const formattedPrice = computed(() => {
    if (typeof props.productInfo.price !== 'number') {
        return props.productInfo.price;
    }
    return props.productInfo.price.toLocaleString();
})
const addToCart = ()=>{
    const userLoggedIn = iPropsValue('auth')
    if(userLoggedIn)
    {
        console.log('logged')
    }
    else
    {
        showModal.value = true;
    }

}
</script>

<style lang="scss" scoped>

.tpproduct__thumb {
    a:not(.tpproduct__thumb-img){
        img{
            height: 295px;
            object-fit: contain;
        }
    }
    .tpproduct__thumb-img
    {
        img
        {
            height: 350px;
            object-fit: contain;
        }
    }
}
.cart_button
{
    background-color: var(--tp-heading-secondary);
    text-align: center;
    color: var(--tp-common-white);
    -webkit-transition: all 0.2s ease-out 0s;
    -moz-transition: all 0.2s ease-out 0s;
    -ms-transition: all 0.2s ease-out 0s;
    -o-transition: all 0.2s ease-out 0s;
    transition: all 0.2s ease-out 0s;
    width: 60px;
    padding: 2px ;
    font-size: 22px;
    &:hover
    {
        color: var(--tp-common-white);
        background-color: #859A00;
    }
    &[disabled]
    {
        color: var(--tp-common-white);
        background-color: #dc7984;
        cursor: not-allowed;
    }
}
.tpproduct
{
    height: 470px;
    .tpproduct__thumb
    {
        height: 335px;
    }
    .tpproduct__content{
        height: calc( 470px - 335px );
        display: flex;
        flex-flow: column;
        .tpproduct__content_category
        {
            font-size: 13px;
            color: var(--tp-text-3);
            display: block;
            width: 100%;
            height: 20px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .tpproduct__title
        {
            height: 42px;
        }
    }
}
</style>
