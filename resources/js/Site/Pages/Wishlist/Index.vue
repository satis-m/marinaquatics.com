<template>
    <!-- breadcrumb-area-start -->
    <div class="breadcrumb__area pt-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-breadcrumb__content">
                        <div class="tp-breadcrumb__list">
                            <span class="tp-breadcrumb__active"><NavLink :href="appRoute('homepage')">Home</NavLink></span>
                            <span class="dvdr">/</span>
                            <span>Wishlist</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area-end -->

    <!-- wishlist-area-start -->
    <div class="cart-area pb-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form action="#">
                        <div class="table-content table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="product-thumbnail">Images</th>
                                    <th class="cart-product-name">Courses</th>
                                    <th class="product-price">Unit Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-subtotal">Total</th>
                                    <th class="product-add-to-cart">Add To Cart</th>
                                    <th class="product-remove">Remove</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="product-thumbnail">
                                        <a href="shop-details.html">
                                            <img src="/web-site/assets/img/product/product-details-1.png" alt="">
                                        </a>
                                    </td>
                                    <td class="product-name">
                                        <a href="shop-details.html">Summer Breakfast For Healthy Morning</a>
                                    </td>
                                    <td class="product-price">
                                        <span class="amount">Rs 130.00</span>
                                    </td>
                                    <td class="product-quantity">
                                        <span class="cart-minus">-</span>
                                        <input class="cart-input" type="text" value="1">
                                        <span class="cart-plus">+</span>
                                    </td>
                                    <td class="product-subtotal">
                                        <span class="amount">Rs 130.00</span>
                                    </td>
                                    <td class="product-add-to-cart">
                                        <button class="tp-btn tp-color-btn  tp-wish-cart banner-animation">Add To Cart</button>
                                    </td>
                                    <td class="product-remove">
                                        <a href="#"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="product-thumbnail">
                                        <a href="shop-details.html">
                                            <img src="/web-site/assets/img/product/product-details-2.png"  alt="">
                                        </a>
                                    </td>
                                    <td class="product-name">
                                        <a href="shop-details.html">The Best Great Benefits Of Fresh Beef</a>
                                    </td>
                                    <td class="product-price">
                                        <span class="amount">Rs 120.50</span>
                                    </td>
                                    <td class="product-quantity">
                                        <span class="cart-minus">-</span>
                                        <input class="cart-input" type="text" value="1">
                                        <span class="cart-plus">+</span>
                                    </td>
                                    <td class="product-subtotal">
                                        <span class="amount">Rs 120.50</span>
                                    </td>
                                    <td class="product-add-to-cart">
                                        <button class="tp-btn tp-color-btn tp-wish-cart banner-animation">Add To Cart</button>
                                    </td>
                                    <td class="product-remove">
                                        <a href="#"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- wishlist-area-end-->

</template>

<script setup>

</script>

<style lang="scss" scoped>

</style>
