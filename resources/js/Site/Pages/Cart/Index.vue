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
                            <span>Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area-end -->

    <!-- cart area -->
    <section class="cart-area pb-80">
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
                                    <th class="product-remove">Remove</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="product-thumbnail">
                                        <a href="shop-details.html">
                                            <img src="assets/img/product/products19-min.jpg" alt="">
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
                                    <td class="product-remove">
                                        <a href="#"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="product-thumbnail">
                                        <a href="shop-details.html">
                                            <img src="assets/img/product/products20-min.jpg"  alt="">
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
                                    <td class="product-remove">
                                        <a href="#"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="coupon-all">
                                    <div class="coupon">
                                        <input id="coupon_code" class="input-text" name="coupon_code" value=""
                                               placeholder="Coupon code" type="text">
                                        <button class="tp-btn tp-color-btn banner-animation" name="apply_coupon" type="submit">Apply
                                            Coupon</button>
                                    </div>
                                    <div class="coupon2">
                                        <button class="tp-btn tp-color-btn banner-animation" name="update_cart" type="submit">Update cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-md-5 ">
                                <div class="cart-page-total">
                                    <h2>Cart totals</h2>
                                    <ul class="mb-20">
                                        <li>Subtotal <span>Rs 250.00</span></li>
                                        <li>Total <span>Rs 250.00</span></li>
                                    </ul>
                                    <a href="checkout.html" class="tp-btn tp-color-btn banner-animation">Proceed to Checkout</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- cart area end-->
</template>

<script setup>

</script>

<style lang="scss" scoped>

</style>
