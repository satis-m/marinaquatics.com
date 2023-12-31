<template>
    <div class="tpproduct p-relative mb-6">
        <div class="tpproduct__thumb p-relative text-center">
            <NavLink :href="appRoute('product.view',productInfo.slug)">
                <ImageWithFallback v-if="mediaCheck('xl')" :source="productInfo.main_picture.thumbnail" :alt="productInfo.slug" />
                <ImageWithFallback v-else :source="productInfo.main_picture.preview" :alt="productInfo.slug" />
            </NavLink>

            <div class="tpproduct__info bage">
              <span v-if="productInfo.highlight != null" class="tpproduct__info-hot bage__highlight">{{ productInfo.highlight }}</span>
                <span v-if="productInfo.current_discount != null" class="tpproduct__info-discount bage__discount">{{
                        productInfo.current_discount.discount
                    }}%</span>
                <span v-if="outOfStock" class="tpproduct__info-hot bage__hot">Out of Stock</span>
                <span v-if="newStock" class="tpproduct__info-hot bage__new">New</span>
            </div>
        </div>
        <div class="tpproduct__content">
             <span class="tpproduct__content_category capitalize">
             <span>{{ productInfo.category.name }}</span>,
             <span>{{ productInfo.category.sub_category }}</span>
             </span>
            <h4 class="tpproduct__title capitalize">
                <NavLink :href="appRoute('product.view',productInfo.slug)">{{ productInfo.name }}</NavLink>
            </h4>
            <div class="d-flex justify-content-between align-items-center">
                <div class="tpproduct__price" v-if="productInfo.current_discount === null">
                    <span>Rs {{ productInfo.price }}</span>
                </div>
                <div class="tpproduct__price flex flex-col" v-else>
                    <span>Rs {{ discountedPrice }}</span>
                    <del>Rs {{ formattedPrice }}</del>
                </div>

                <div class="tpproduct__hover-btn d-flex justify-content-center">
                    <button type="button" @click="addToCart" :disabled="outOfStock" class="cart_button rounded-pill"
                            data-bs-toggle="tooltip" data-bs-title="Default tooltip"
                            :title="productInfo.available_quantity > 0 ? 'Add to cart': 'Out of Stock'"><i
                        class="icon-add_shopping_cart"></i></button>
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
                    <NavLink :href="appRoute('client.intended-login')" class="action-btn btn-sm btn-red">login</NavLink>
                </div>
            </template>
        </Modal>
    </Teleport>
</template>

<script setup>
import Modal from "@/Components/Modal.vue"
import {useAppUtility} from "@admin/Composables/appUtility";
import {ref, computed, onMounted, onRenderTracked} from "@vue/runtime-core";
import {useInertiaPropsUtility} from "@admin/Composables/inertiaPropsUtility";
import moment from "moment";
import {useForm} from "@inertiajs/vue3";
import ImageWithFallback from "@/Components/ImageWithFallback.vue";

const {iPropsValue} = useInertiaPropsUtility();
const {mediaCheck} = useAppUtility();
const userLoggedIn = iPropsValue('auth')
const props = defineProps({
    productInfo: {
        type: Object,
        required: true
    }
})

const showModal = ref(false);
const discountedPrice = computed(() => {
    const {price, current_discount: {discount}} = props.productInfo;
    return +price - (+discount / 100) * +price;
})
const outOfStock = computed(() => {
    return props.productInfo.available_quantity < 1
});

const newStock = computed(() => {
    if (props.productInfo.last_import?.created_at != undefined) {
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
const addToCart = () => {

    if (userLoggedIn) {
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
    } else {
        showModal.value = true;
    }

}
onRenderTracked(()=>{
    // console.log('cart rendered');
})
</script>

<style lang="scss" scoped>

.tpproduct__thumb {
    a:not(.tpproduct__thumb-img) {
        img {
            //height: 257px;
            object-fit: contain;
            border-radius: 5px;
        }
    }

}

.cart_button {
    background-color: var(--tp-heading-secondary);
    text-align: center;
    color: var(--tp-common-white);
    -webkit-transition: all 0.2s ease-out 0s;
    -moz-transition: all 0.2s ease-out 0s;
    -ms-transition: all 0.2s ease-out 0s;
    -o-transition: all 0.2s ease-out 0s;
    transition: all 0.2s ease-out 0s;
    width: 60px;
    padding: 2px;
    font-size: 22px;

    &:hover {
        color: var(--tp-common-white);
        background-color: #859A00;
    }

    &[disabled] {
        color: var(--tp-common-white);
        background-color: #dc7984;
        cursor: not-allowed;
    }
}

.tpproduct {
    //height: 437px;
    .tpproduct__thumb {
        //height: 300px;
    }

    .tpproduct__content {
        height: 145px;
        display: flex;
        flex-flow: column;

        .tpproduct__content_category {
            font-size: 13px;
            color: var(--tp-text-3);
            display: block;
            width: 100%;
            height: 22px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .tpproduct__title {
            height: 42px;
        }
    }
}
</style>
