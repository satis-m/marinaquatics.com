<template>
    <!-- breadcrumb-area-start -->
    <div class="breadcrumb__area grey-bg pt-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-breadcrumb__content">
                        <div class="tp-breadcrumb__list">
                            <span class="tp-breadcrumb__active"><a href="index.html">Home</a></span>
                            <span class="dvdr">/</span>
                            <span class="tp-breadcrumb__active"><a href="index.html">{{ productInfo.category.name }}</a></span>
                            <span class="dvdr">/</span>
                            <span>{{ productInfo.category.sub_category }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area-end -->
    <!-- shop-details-area-start -->
    <section class="shopdetails-area grey-bg pb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12">
                    <div class="tpdetails__area  pb-30">
                        <div class="tpdetails__product mb-30">
                            <div class="tpdetails__title-box">
                                <h3 class="tpdetails__title">{{ productInfo.name }}</h3>
                                <ul class="tpdetails__brand">
<!--                                    <li> Brands: {{ productInfo.brand }} </li>-->
<!--                                    <li>-->
<!--                                        <i class="icon-star_outline1"></i>-->
<!--                                        <i class="icon-star_outline1"></i>-->
<!--                                        <i class="icon-star_outline1"></i>-->
<!--                                        <i class="icon-star_outline1"></i>-->
<!--                                        <i class="icon-star_outline1"></i>-->
<!--                                        <b>02 Reviews</b>-->
<!--                                    </li>-->
<!--                                    <li>-->
<!--                                        SKU: <span>ORFARMVE005</span>-->
<!--                                    </li>-->
                                </ul>
                            </div>
                            <div class="tpdetails__box">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="tpproduct-details__nab">
                                            <div class="tab-content product-image-preview" id="nav-tabContents">
                                                <div class="tab-pane fade show active w-img" :id="'preview-image-'+productInfo.main_picture?.id" role="tabpanel" :aria-labelledby="'nav-image-'+productInfo.main_picture?.id" tabindex="0">
                                                    <img v-if="mediaCheck('sm')"  :src="getImageLink(productInfo.main_picture , 'thumbnail')" :alt="productInfo.main_picture">
                                                    <img v-else :src="getImageLink(productInfo.main_picture , 'preview')" :alt="productInfo.main_picture?.name">
                                                    <div class="tpproduct__info bage">
                                                        <span class="tpproduct__info-hot bage__hot">HOT</span>
                                                    </div>
                                                </div>
                                                <div :key="key" v-for="(alternativePicture , key) in productInfo.alternative_picture" class="tab-pane fade w-img" :id="'preview-image-'+alternativePicture?.id" role="tabpanel" :aria-labelledby="'nav-image-'+alternativePicture?.id" tabindex="0">
                                                    <img v-if="mediaCheck('sm')"  :src="alternativePicture.thumbnail" :alt="alternativePicture.name">
                                                    <img v-else :src="alternativePicture.preview" :alt="alternativePicture.name">
                                                    <div class="tpproduct__info bage">
                                                        <span class="tpproduct__info-discount bage__discount">-90%</span>
                                                        <span class="tpproduct__info-hot bage__hot">HOT</span>
                                                    </div>
                                                </div>

                                            </div>
                                            <nav>
                                                <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
                                                    <button class="nav-link active" :id="'nav-image-'+productInfo.main_picture?.id" data-bs-toggle="tab" :data-bs-target="'#preview-image-'+productInfo.main_picture?.id" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                                                        <img :src="getImageLink(productInfo.main_picture , 'thumbnail')" :alt="productInfo.main_picture">
                                                    </button>
                                                    <button :key="key" v-for="(alternativePicture , key) in productInfo.alternative_picture" class="nav-link" :id="'nav-image-'+alternativePicture.id" data-bs-toggle="tab" :data-bs-target="'#preview-image-'+alternativePicture.id" type="button" role="tab" :aria-controls="'preview-image-'+alternativePicture.id" aria-selected="false">
                                                        <img :src="alternativePicture.thumbnail" alt="">
                                                    </button>
                                                </div>
                                            </nav>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mt-10 lg:mt-0">
                                        <ul class="combo-offer mb-3  md:justify-start justify-center" >
                                            <button v-if="productInfo.combo_offer.name_1 !='' && productInfo.combo_offer.name_1 != null  " class="navigation-tab" :class="isOfferSelected(1)" :disabled="!checkStockByOffer(1)" @click="selectOffer(1)"  type="button" >{{ productInfo.combo_offer.name_1 }}</button>
                                            <button v-if="productInfo.combo_offer.name_2 !='' && productInfo.combo_offer.name_2 != null  " class="navigation-tab" :class="isOfferSelected(2)" :disabled="!checkStockByOffer(2)" @click="selectOffer(2)" type="button" >{{ productInfo.combo_offer.name_2 }}</button>
                                            <button v-if="productInfo.combo_offer.name_3 !='' && productInfo.combo_offer.name_3 != null  " class="navigation-tab" :class="isOfferSelected(3)" :disabled="!checkStockByOffer(3)" @click="selectOffer(3)" type="button" >{{ productInfo.combo_offer.name_3 }}</button>
                                        </ul>
                                        <div class="tab-content" id="pills-tabContent">
                                            <div class="tab-pane fade show active" >
                                                <div class="product__details">
                                                <div class="product__details-price-box">
                                                    <h5 class="product__details-price">Rs {{ formattedPrice(productPrice)}} </h5>
                                                    <div v-html="productInfo.product_info" class="product-info"></div>
                                                </div>
                                                <div class="product__details-cart">
                                                <div class="product__details-quantity d-flex align-items-center mb-15">
                                                        <b>Qty:</b>
                                                        <CartInput @limitReach="handleLimitReach" :max="maxCartInput" ref="refCartInput" @updateCount="updateCount" :disable="outOfStock"/>
                                                        <div class="ml-6 add-to-cart-btn">
                                                            <a href="cart.html"><i class="icon-add_shopping_cart"></i> add to cart</a>
                                                        </div>
                                                    </div>
                                                    <ul class="product__details-check">
                                                        <li>
                                                            <a href="#"><i class="icon-heart icons"></i> add to wishlist</a>
                                                        </li>
<!--                                                        <li>-->
<!--                                                            <a href="#"><i class="icon-layers"></i> Add to Compare</a>-->
<!--                                                        </li>-->
<!--                                                        <li>-->
<!--                                                            <a href="#"><i class="icon-share-2"></i> Share</a>-->
<!--                                                        </li>-->
                                                    </ul>
                                                </div>
                                                <div class="product__details-stock mb-25">
                                                    <ul>
                                                        <li>Availability:
                                                            <i v-if="outOfStock" class="out-of-stock">Out of stock</i>
                                                            <i v-else class="in-stock">{{productInfo.available_quantity}} Instock</i>
                                                        </li>
                                                        <li>Categories: <span>{{ productInfo.category.name }}, {{ productInfo.category.sub_category }} </span></li>
                                                        <li>Tags: <span class="badge bg-[#12b3ca] ml-2 capitalize" v-for="tag in productInfo.tag" v-text="tag"> </span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tpdescription__box">
                            <div class="tpdescription__box-center d-flex align-items-center justify-content-start">
                                <nav>
                                    <div class="nav nav-tabs"  role="tablist">
                                        <button class="nav-link active m-0 py-2 px-0" id="nav-description-tab" data-bs-toggle="tab" data-bs-target="#nav-description" type="button" role="tab" aria-controls="nav-description" aria-selected="true">Product Description</button>
                                    </div>
                                </nav>
                            </div>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-description" role="tabpanel" aria-labelledby="nav-description-tab" tabindex="0" v-html="productInfo.description">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- shop-details-area-end -->

</template>

<script setup>
import {watch, ref,unref,reactive,onMounted, computed} from "@vue/runtime-core";
import {useAppUtility} from "@admin/Composables/appUtility";
import {useInertiaPropsUtility} from "@admin/Composables/inertiaPropsUtility";
import CartInput from "@/Components/CartInput.vue";
import {useForm} from "@inertiajs/vue3";

const maxCartInput = ref(0);
const {getImageLink, mediaCheck} = useAppUtility();
const {iPropsValue} = useInertiaPropsUtility();
const productInfo = ref(iPropsValue("productInfo"));
const productPrice = ref(productInfo.value.price)
const formData = useForm({
    _method: "POST",
    slug: productInfo.value.slug,
    name: productInfo.value.name,
    offer: {
        key:'',
        name:'',
        quantity:'',
        price:'',
    },
    cart_quantity:'',
    total_quantity:''
});

const refCartInput = ref(null);

watch( ()=> iPropsValue("productInfo") ,
    ()=>{
        productInfo.value = iPropsValue("productInfo")
    })
const outOfStock =computed(() => {
    return productInfo.value.available_quantity < 1
})
const isOfferSelected = (option) => {
    return formData.offer.key == option ? 'active' : '';
}

const updateCount = (value)=>{
    console.log( value)
}

const selectOffer = (option)=>{
    const available_product = productInfo.value.available_quantity;
    formData.offer.key = option;
    formData.offer.name = productInfo.value.combo_offer['name_'+option];
    formData.offer.price = productInfo.value.combo_offer['price_'+option];
    formData.offer.quantity = productInfo.value.combo_offer['quantity_'+option];
    productPrice.value = formData.offer.price
    refCartInput.value.resetCounter();
    maxCartInput.value = Math.floor((available_product / productInfo.value.combo_offer['quantity_'+option]));
}

const formattedPrice = (price) => {
    if (typeof price !== 'number') {
        return price;
    }
    return price.toLocaleString();
}


const checkStockByOffer = (option)=>{
    const available_product = productInfo.value.available_quantity;
    if(available_product > productInfo.value.combo_offer['quantity_'+option])
        return true
    return false;
}
const handleLimitReach = ()=>{
   vt.info("stock limit reached")
}

onMounted(()=>{
    if(outOfStock.value === false)
        selectOffer(1);
})
</script>

<style lang="scss">
@media (width >= 600px) {
    .product-image-preview
    {
        display: flex;
        justify-content: center;
        align-items: center;
        .w-img
        {
            height: 500px;
            width: 500px;
            img{
                height: 100%;
                width: 100%;
                object-fit: contain;
            }
        }
    }
}
#nav-description
{
    h2,h2{
        color: var(--tp-heading-primary);
        font-family: var(--tp-ff-jost);
        font-weight: 600;

    }
}
.w-img
{
    background: #efefef;
    border-radius: 8px;
}
.add-to-cart-btn
{
    font-family: var(--tp-ff-jost);
    font-weight: 600;
    font-size: 13px;
    text-transform: uppercase;
    color: var(--tp-common-white);
    background-color: var(--tp-heading-secondary);
    border-radius: 30px;
    width: 120px;
    height: 36px;
    display: flex;
    justify-content: center;
    align-items: center;
    i{
        font-size: 16px;
    }
}

.combo-offer
{
    display: flex;
    justify-content: left;
    align-items: center;
    height: 50px;
    column-gap: 24px;
    button{
        height: 100%;
        padding: 0 16px;
        border-radius: 6px;
    }
}
.product-info{
    ul
    {
        li
        {
            font-family: var(--tp-ff-jost);
            list-style: none;
            font-weight: 400;
            font-size: 14px;
            line-height: 22px;
            color: var(--tp-text-body);
            position: relative;
            padding-left: 18px;
        &::after
        {
            position: absolute;
            content: "";
            height: 5px;
            width: 5px;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            background-color: var(--tp-text-body);
            border-radius: 50%;
        }
        }
    }

}
.combo-offer
{
    button.navigation-tab
    {
        text-transform: capitalize;
        &.active{
            background-color: #ffdcdc !important;
            color:  var(--tp-heading-secondary) !important;
            border-color:  var(--tp-heading-secondary) !important;
        }
        &[disabled]
        {
            cursor: not-allowed;
            background-color: #f3f3f3 !important;
        }
    }
}
</style>
