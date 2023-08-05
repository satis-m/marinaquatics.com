<template>
    <div class="tplist__product d-flex align-items-center justify-content-between mb-20">
        <div class="tplist__product-img grow-0 ">

                <NavLink class="tplist__product-img-one" :href="appRoute('product.view',productInfo.slug)">
                    <img :src="getImageLink(productInfo.main_picture , 'thumbnail')"  alt="">
                </NavLink>

            <div class="tpproduct__info bage">
                <span class="tpproduct__info-discount bage__discount">-50%</span>
                <span class="tpproduct__info-hot bage__hot">HOT</span>
            </div>
        </div>
        <div class="tplist__content grow">
            <span>500 gram</span>
            <h4 class="tplist__content-title"><a href="#">Fresh Mangosteen 100% Organic From VietNamese</a></h4>
            <div class="tplist__rating mb-5">
                <a href="#"><i class="icon-star_outline1"></i></a>
                <a href="#"><i class="icon-star_outline1"></i></a>
                <a href="#"><i class="icon-star_outline1"></i></a>
                <a href="#"><i class="icon-star_outline1"></i></a>
                <a href="#"><i class="icon-star_outline1"></i></a>
            </div>
            <ul class="tplist__content-info">
                <li>Delicous Non-Dairy cheese sauce</li>
                <li>Vegan &amp; Allergy Friendly</li>
                <li>Smooth, velvety Dairy free cheese sauce</li>
            </ul>
        </div>
        <div class="tplist__price grow-0 justify-content-end">
            <h4 class="tplist__instock">Availability: <span>92 in stock</span> </h4>
            <h3 class="tplist__count mb-15">$56.00</h3>
            <button class="tp-btn-2 mb-10"><i class="icon-add_shopping_cart"></i> add to cart</button>
            <div class="tplist__shopping">
                <a href="#"><i class="icon-heart icons"></i> wishlist</a>
            </div>
        </div>
    </div>
</template>

<script setup>
import {useAppUtility} from "@admin/Composables/appUtility";
import {computed} from "@vue/runtime-core";

const {getImageLink} = useAppUtility();

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
const formattedPrice = computed(() => {
    if (typeof props.productInfo.price !== 'number') {
        return props.productInfo.price;
    }
    return props.productInfo.price.toLocaleString();
})
</script>

<style lang="scss" scoped>
.tplist__product-img
{
    img{
        width:250px;
        height:250px;
        object-fit: contain;
    }
}
.tplist__product
{
    column-gap: 24px;
}
</style>
