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
                    <div class="tpdetails__area mr-60 pb-30">
                        <div class="tpdetails__product mb-30">
                            <div class="tpdetails__title-box">
                                <h3 class="tpdetails__title">{{ productInfo.name }}</h3>
                                <ul class="tpdetails__brand">
                                    <li> Brands: <a href="#">Tetra</a> </li>
                                    <li>
                                        <i class="icon-star_outline1"></i>
                                        <i class="icon-star_outline1"></i>
                                        <i class="icon-star_outline1"></i>
                                        <i class="icon-star_outline1"></i>
                                        <i class="icon-star_outline1"></i>
                                        <b>02 Reviews</b>
                                    </li>
                                    <li>
                                        SKU: <span>ORFARMVE005</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="tpdetails__box">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="tpproduct-details__nab">
                                            <div class="tab-content" id="nav-tabContents">
                                                <div class="tab-pane fade show active w-img" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                                                    <img src="/web-site/assets/img/product/snack.jpg" alt="">
                                                    <div class="tpproduct__info bage">
                                                        <span class="tpproduct__info-hot bage__hot">HOT</span>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade w-img" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                                                    <img src="/web-site/assets/img/product/snack1.jpg" alt="">
                                                    <div class="tpproduct__info bage">
                                                        <span class="tpproduct__info-discount bage__discount">-90%</span>
                                                        <span class="tpproduct__info-hot bage__hot">HOT</span>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade w-img" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
                                                    <img src="/web-site/assets/img/product/snack2.jpg" alt="">
                                                    <div class="tpproduct__info bage">
                                                        <span class="tpproduct__info-hot bage__hot">HOT</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <nav>
                                                <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
                                                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                                                        <img src="/web-site/assets/img/product/snack.jpg" alt="">
                                                    </button>
                                                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                                                        <img src="/web-site/assets/img/product/snack1.jpg" alt="">
                                                    </button>
                                                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">
                                                        <img src="/web-site/assets/img/product/snack2.jpg" alt="">
                                                    </button>
                                                </div>
                                            </nav>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <ul class="nav nav-pills nav-fill mb-3" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="navigation-tab nav-link active" id="pills-one-tab" data-bs-toggle="pill" data-bs-target="#pills-one" type="button" role="tab" aria-controls="pills-one" aria-selected="true">One Piece</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="navigation-tab nav-link" id="pills-two-tab" data-bs-toggle="pill" data-bs-target="#pills-two" type="button" role="tab" aria-controls="pills-two" aria-selected="false">Pair of 2</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="navigation-tab nav-link" id="pills-three-tab" data-bs-toggle="pill" data-bs-target="#pills-three" type="button" role="tab" aria-controls="pills-three" aria-selected="false">Pack of 3</button>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="pills-tabContent">
                                            <div class="tab-pane fade show active" id="pills-one" role="tabpanel" aria-labelledby="pills-one-tab" tabindex="0"><div class="product__details">
                                                <div class="product__details-price-box">
                                                    <h5 class="product__details-price">Rs 56.00</h5>
                                                    <ul class="product__details-info-list">
                                                        <li><b>Brand</b> : Tetra</li>
                                                        <li><b>Flavor</b> : Seafood</li>
                                                        <li><b>Age Range (Description)</b> :  All Life Stages</li>
                                                        <li><b>Target Species</b> :  Fish</li>
                                                        <li><b>Item Form</b> : Stick</li>
                                                    </ul>
                                                </div>
                                                <div class="product__details-cart">
                                                    <div class="product__details-quantity d-flex align-items-center mb-15">
                                                        <b>Qty:</b>
                                                        <div class="product__details-count mr-10">
                                                            <span class="cart-minus"><i class="far fa-minus"></i></span>
                                                            <input class="tp-cart-input" type="text" value="1">
                                                            <span class="cart-plus"><i class="far fa-plus"></i></span>
                                                        </div>
                                                        <div class="product__details-btn">
                                                            <a href="cart.html">add to cart</a>
                                                        </div>
                                                    </div>
                                                    <ul class="product__details-check">
                                                        <li>
                                                            <a href="#"><i class="icon-heart icons"></i> add to wishlist</a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><i class="icon-layers"></i> Add to Compare</a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><i class="icon-share-2"></i> Share</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="product__details-stock mb-25">
                                                    <ul>
                                                        <li>Availability: <i>54 Instock</i></li>
                                                        <li>Categories: <span>Vegetables, Meat & Eggs, Fruit Drink </span></li>
                                                        <li>Tags: <span>Chicken, Natural, Organic</span></li>
                                                    </ul>
                                                </div>
                                                <div class="product__details-payment text-center">
                                                    <img src="/web-site/assets/img/shape/payment-2.png" alt="">
                                                    <span>Guarantee safe & Secure checkout</span>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="tab-pane fade" id="pills-two" role="tabpanel" aria-labelledby="pills-two-tab" tabindex="0"><div class="product__details">
                                                <div class="product__details-price-box">
                                                    <h5 class="product__details-price">Rs 100.00</h5>
                                                    <ul class="product__details-info-list">
                                                        <li><b>Brand</b> : Tetra</li>
                                                        <li><b>Flavor</b> : Seafood</li>
                                                        <li><b>Age Range (Description)</b> :  All Life Stages</li>
                                                        <li><b>Target Species</b> :  Fish</li>
                                                        <li><b>Item Form</b> : Stick</li>
                                                    </ul>
                                                </div>
                                                <div class="product__details-cart">
                                                    <div class="product__details-quantity d-flex align-items-center mb-15">
                                                        <b>Qty:</b>
                                                        <div class="product__details-count mr-10">
                                                            <span class="cart-minus"><i class="far fa-minus"></i></span>
                                                            <input class="tp-cart-input" type="text" value="1">
                                                            <span class="cart-plus"><i class="far fa-plus"></i></span>
                                                        </div>
                                                        <div class="product__details-btn">
                                                            <a href="cart.html">add to cart</a>
                                                        </div>
                                                    </div>
                                                    <ul class="product__details-check">
                                                        <li>
                                                            <a href="#"><i class="icon-heart icons"></i> add to wishlist</a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><i class="icon-layers"></i> Add to Compare</a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><i class="icon-share-2"></i> Share</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="product__details-stock mb-25">
                                                    <ul>
                                                        <li>Availability: <i>54 Instock</i></li>
                                                        <li>Categories: <span>Vegetables, Meat & Eggs, Fruit Drink </span></li>
                                                        <li>Tags: <span>Chicken, Natural, Organic</span></li>
                                                    </ul>
                                                </div>
                                                <div class="product__details-payment text-center">
                                                    <img src="/web-site/assets/img/shape/payment-2.png" alt="">
                                                    <span>Guarantee safe & Secure checkout</span>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="tab-pane fade" id="pills-three" role="tabpanel" aria-labelledby="pills-three-tab" tabindex="0"><div class="product__details">
                                                <div class="product__details-price-box">
                                                    <h5 class="product__details-price">Rs 150.00</h5>
                                                    <ul class="product__details-info-list">
                                                        <li><b>Brand</b> : Tetra</li>
                                                        <li><b>Flavor</b> : Seafood</li>
                                                        <li><b>Age Range (Description)</b> :  All Life Stages</li>
                                                        <li><b>Target Species</b> :  Fish</li>
                                                        <li><b>Item Form</b> : Stick</li>
                                                    </ul>
                                                </div>
                                                <div class="product__details-cart">
                                                    <div class="product__details-quantity d-flex align-items-center mb-15">
                                                        <b>Qty:</b>
                                                        <div class="product__details-count mr-10">
                                                            <span class="cart-minus"><i class="far fa-minus"></i></span>
                                                            <input class="tp-cart-input" type="text" value="1">
                                                            <span class="cart-plus"><i class="far fa-plus"></i></span>
                                                        </div>
                                                        <div class="product__details-btn">
                                                            <a href="cart.html">add to cart</a>
                                                        </div>
                                                    </div>
                                                    <ul class="product__details-check">
                                                        <li>
                                                            <a href="#"><i class="icon-heart icons"></i> add to wishlist</a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><i class="icon-layers"></i> Add to Compare</a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><i class="icon-share-2"></i> Share</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="product__details-stock mb-25">
                                                    <ul>
                                                        <li>Availability: <i>54 Instock</i></li>
                                                        <li>Categories: <span>Vegetables, Meat & Eggs, Fruit Drink </span></li>
                                                        <li>Tags: <span>Chicken, Natural, Organic</span></li>
                                                    </ul>
                                                </div>
                                                <div class="product__details-payment text-center">
                                                    <img src="/web-site/assets/img/shape/payment-2.png" alt="">
                                                    <span>Guarantee safe & Secure checkout</span>
                                                </div>
                                            </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tpdescription__box">
                            <div class="tpdescription__box-center d-flex align-items-center justify-content-center">
                                <nav>
                                    <div class="nav nav-tabs"  role="tablist">
                                        <button class="nav-link active" id="nav-description-tab" data-bs-toggle="tab" data-bs-target="#nav-description" type="button" role="tab" aria-controls="nav-description" aria-selected="true">Product Description</button>
                                        <button class="nav-link" id="nav-info-tab" data-bs-toggle="tab" data-bs-target="#nav-information" type="button" role="tab" aria-controls="nav-information" aria-selected="false">ADDITIONAL INFORMATION</button>
                                        <button class="nav-link" id="nav-review-tab" data-bs-toggle="tab" data-bs-target="#nav-review" type="button" role="tab" aria-controls="nav-review" aria-selected="false">Reviews (1)</button>
                                    </div>
                                </nav>
                            </div>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-description" role="tabpanel" aria-labelledby="nav-description-tab" tabindex="0">
                                    <div class="tpdescription__content">
                                        <p>Designed by Puik in 1949 as one of the first models created especially for Carl Hansen & Son, and produced since 1950. The last of a series of chairs wegner designed based on inspiration from antique chinese armchairs. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia eserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, aque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. </p>
                                    </div>
                                    <div class="tpdescription__product-wrapper mt-30 mb-30 d-flex justify-content-between align-items-center">
                                        <div class="tpdescription__product-info">
                                            <h5 class="tpdescription__product-title">PRODUCT DETAILS</h5>
                                            <ul class="tpdescription__product-info">
                                                <li>Material: Plastic, Wood</li>
                                                <li>Legs: Lacquered oak and black painted oak</li>
                                                <li>Dimensions and Weight: Height: 80 cm, Weight: 5.3 kg</li>
                                                <li>Length: 48cm</li>
                                                <li>Depth: 52 cm</li>
                                            </ul>
                                            <p>Lemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut <br> fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem <br> sequi nesciunt.</p>
                                        </div>
                                        <div class="tpdescription__product-thumb">
                                            <img src="/web-site/assets/img/product/product-single-1.png" alt="">
                                        </div>
                                    </div>
                                    <div class="tpdescription__video">
                                        <h5 class="tpdescription__product-title">PRODUCT DETAILS</h5>
                                        <p>Form is an armless modern chair with a minimalistic expression. With a simple and contemporary design Form Chair has a soft and welcoming ilhouette and a distinctly residential look. The legs appear almost as if they are growing out of the shell. This gives the design flexibility and makes it possible to vary the frame. Unika is a mouth blown series of small, glass pendant lamps, originally designed for the Restaurant Gronbech. Est eum itaque maiores qui blanditiis architecto. Eligendi saepe rem ut. Cumque quia earum eligendi. </p>
                                        <div class="tpdescription__video-wrapper p-relative mt-30 mb-35 w-img">
                                            <img src="/web-site/assets/img/product/product-video1.jpg" alt="">
                                            <div class="tpvideo__video-btn">
                                                <a class="tpvideo__video-icon popup-video" href="https://www.youtube.com/watch?v=rLrV5Tel7zw">
                                                    <i>
                                                        <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M15.6499 6.58886L15.651 6.58953C17.8499 7.85553 18.7829 9.42511 18.7829 10.8432C18.7829 12.2613 17.8499 13.8308 15.651 15.0968L15.6499 15.0975L12.0218 17.195L8.3948 19.2919C8.3946 19.292 8.3944 19.2921 8.3942 19.2922C6.19546 20.558 4.36817 20.5794 3.13833 19.8697C1.9087 19.1602 1.01562 17.5694 1.01562 15.0382V10.8432V6.64818C1.01562 4.10132 1.90954 2.51221 3.13721 1.80666C4.36609 1.1004 6.1936 1.12735 8.3942 2.39416C8.3944 2.39428 8.3946 2.3944 8.3948 2.39451L12.0218 4.49135L15.6499 6.58886Z" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                    </i>
                                                </a>
                                            </div>
                                        </div>
                                        <h5 class="tpdescription__product-title">Product supreme quality</h5>
                                        <p>Form is an armless modern chair with a minimalistic expression. With a simple and contemporary design Form Chair has a soft and welcoming ilhouette and a distinctly residential look. The legs appear almost as if they are growing out of the shell. This gives the design flexibility and makes it possible to vary the frame. Unika is a mouth blown series of small, glass pendant lamps, originally designed for the Restaurant Gronbech. Est eum itaque maiores qui blanditiis architecto. Eligendi saepe rem ut. Cumque quia earum eligendi. </p>
                                        <p>Duis semper erat mauris, sed egestas purus commodo. Cras imperdiet est in nunc tristique lacinia. Nullam aliquam mauris eu accumsan tincidunt. Suspendisse velit ex, aliquet vel ornare vel, dignissim a tortor. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate.</p>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-information" role="tabpanel" aria-labelledby="nav-info-tab" tabindex="0">
                                    <div class="tpdescription__content">
                                        <p>Designed by Puik in 1949 as one of the first models created especially for Carl Hansen & Son, and produced since 1950. The last of a series of chairs wegner designed based on inspiration from antique chinese armchairs. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia eserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, aque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. </p>
                                    </div>
                                    <div class="tpdescription__product-wrapper mt-30 mb-30 d-flex justify-content-between align-items-center">
                                        <div class="tpdescription__product-info">
                                            <h5 class="tpdescription__product-title">PRODUCT DETAILS</h5>
                                            <ul class="tpdescription__product-info">
                                                <li>Material: Plastic, Wood</li>
                                                <li>Legs: Lacquered oak and black painted oak</li>
                                                <li>Dimensions and Weight: Height: 80 cm, Weight: 5.3 kg</li>
                                                <li>Length: 48cm</li>
                                                <li>Depth: 52 cm</li>
                                            </ul>
                                            <p>Lemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut <br> fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem <br> sequi nesciunt.</p>
                                        </div>
                                        <div class="tpdescription__product-thumb">
                                            <img src="/web-site/assets/img/product/product-single-1.png" alt="">
                                        </div>
                                    </div>
                                    <div class="tpdescription__video">
                                        <h5 class="tpdescription__product-title">PRODUCT DETAILS</h5>
                                        <p>Form is an armless modern chair with a minimalistic expression. With a simple and contemporary design Form Chair has a soft and welcoming ilhouette and a distinctly residential look. The legs appear almost as if they are growing out of the shell. This gives the design flexibility and makes it possible to vary the frame. Unika is a mouth blown series of small, glass pendant lamps, originally designed for the Restaurant Gronbech. Est eum itaque maiores qui blanditiis architecto. Eligendi saepe rem ut. Cumque quia earum eligendi. </p>
                                    </div>
                                </div>




                                <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab" tabindex="0">
                                    <div class="tpreview__wrapper">
                                        <h4 class="tpreview__wrapper-title">1 review for Cheap and delicious fresh chicken</h4>
                                        <div class="tpreview__comment">
                                            <div class="tpreview__comment-img mr-20">
                                                <img src="/web-site/assets/img/testimonial/test-avata-1.png" alt="">
                                            </div>
                                            <div class="tpreview__comment-text">
                                                <div class="tpreview__comment-autor-info d-flex align-items-center justify-content-between">
                                                    <div class="tpreview__comment-author">
                                                        <span>admin</span>
                                                    </div>
                                                    <div class="tpreview__comment-star">
                                                        <i class="icon-star_outline1"></i>
                                                        <i class="icon-star_outline1"></i>
                                                        <i class="icon-star_outline1"></i>
                                                        <i class="icon-star_outline1"></i>
                                                        <i class="icon-star_outline1"></i>
                                                    </div>
                                                </div>
                                                <span class="date mb-20">--April 9, 2022: </span>
                                                <p>very good</p>
                                            </div>
                                        </div>
                                        <div class="tpreview__form">
                                            <h4 class="tpreview__form-title mb-25">Add a review </h4>
                                            <form action="#">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="tpreview__input mb-30">
                                                            <input type="text" placeholder="Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="tpreview__input mb-30">
                                                            <input type="email" placeholder="Email">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="tpreview__star mb-20">
                                                            <h4 class="title">Your Rating</h4>
                                                            <div class="tpreview__star-icon">
                                                                <a href="#"><i class="icon-star_outline1"></i></a>
                                                                <a href="#"><i class="icon-star_outline1"></i></a>
                                                                <a href="#"><i class="icon-star_outline1"></i></a>
                                                                <a href="#"><i class="icon-star_outline1"></i></a>
                                                                <a href="#"><i class="icon-star_outline1"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="tpreview__input mb-30">
                                                            <textarea name="text" placeholder="Message"></textarea>
                                                            <div class="tpreview__submit mt-30">
                                                                <button class="tp-btn">Submit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- shop-details-area-end -->

    <!-- product-area-start -->
    <section class="product-area whight-product pt-75 pb-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h5 class="tpdescription__product-title mb-20">Related Products</h5>
                </div>
            </div>
            <div class="tpproduct__arrow double-product p-relative">
                <div class="swiper-container tpproduct-active tpslider-bottom p-relative">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="tpproduct p-relative">
                                <div class="tpproduct__thumb p-relative text-center">
                                    <a href="shop-details-4.html"><img src="/web-site/assets/img/product/koi min.png" alt=""></a>
                                    <a class="tpproduct__thumb-img" href="shop-details-4.html"><img src="/web-site/assets/img/product/koi.png" alt=""></a>
                                    <div class="tpproduct__info bage">
                                        <span class="tpproduct__info-discount bage__discount">-50%</span>
                                        <span class="tpproduct__info-hot bage__hot">HOT</span>
                                    </div>
                                    <div class="tpproduct__shopping">
                                        <a class="tpproduct__shopping-wishlist" href="wishlist.html"><i class="icon-heart icons"></i></a>
                                        <a class="tpproduct__shopping-wishlist" href="#"><i class="icon-layers"></i></a>
                                        <a class="tpproduct__shopping-cart" href="#"><i class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="tpproduct__content">
                                 <span class="tpproduct__content-weight">
                                    <a href="shop-details-4.html">Fish</a>,
                                    <a href="shop-details-4.html">Japanese</a>
                                 </span>
                                    <h4 class="tpproduct__title">
                                        <a href="shop-details-4.html">Japanese Koi</a>
                                    </h4>
                                    <div class="tpproduct__rating mb-5">
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                    </div>
                                    <div class="tpproduct__price">
                                        <span>Rs 56.00</span>
                                        <del>Rs 19.00</del>
                                    </div>
                                </div>
                                <div class="tpproduct__hover-text">
                                    <div class="tpproduct__hover-btn d-flex justify-content-center mb-10">
                                        <a class="tp-btn-2" href="shop-details-4.html">Add to cart</a>
                                    </div>
                                    <div class="tpproduct__descrip">
                                        <ul>
                                            <li>Type: Japanese</li>
                                            <li>Care Level: Easy</li>
                                            <li>LIFE: 600 days</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tpproduct p-relative">
                                <div class="tpproduct__thumb p-relative text-center">
                                    <a href="shop-details-4.html"><img src="/web-site/assets/img/product/hi.png" alt=""></a>
                                    <a class="tpproduct__thumb-img" href="shop-details-4.html"><img src="/web-site/assets/img/product/hi min.jpg" alt=""></a>
                                    <div class="tpproduct__info bage">
                                        <span class="tpproduct__info-discount bage__discount">-40%</span>
                                    </div>
                                    <div class="tpproduct__shopping">
                                        <a class="tpproduct__shopping-wishlist" href="wishlist.html"><i class="icon-heart icons"></i></a>
                                        <a class="tpproduct__shopping-wishlist" href="#"><i class="icon-layers"></i></a>
                                        <a class="tpproduct__shopping-cart" href="#"><i class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="tpproduct__content">
                                 <span class="tpproduct__content-weight">
                                    <a href="shop-details-4.html">Fish</a>
                                 </span>
                                    <h4 class="tpproduct__title">
                                        <a href="shop-details-4.html">Hi Utsuri Kai</a>
                                    </h4>
                                    <div class="tpproduct__rating mb-5">
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                    </div>
                                    <div class="tpproduct__price">
                                        <span>Rs 56.00</span>
                                        <del>Rs 19.00</del>
                                    </div>
                                </div>
                                <div class="tpproduct__hover-text">
                                    <div class="tpproduct__hover-btn d-flex justify-content-center mb-10">
                                        <a class="tp-btn-2" href="shop-details-4.html">Add to cart</a>
                                    </div>
                                    <div class="tpproduct__descrip">
                                        <ul>
                                            <li>Type: Japanese</li>
                                            <li>Care Level: Moderate</li>
                                            <li>LIFE: 600 days</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tpproduct p-relative">
                                <div class="tpproduct__thumb p-relative text-center">
                                    <a href="shop-details-4.html"><img src="/web-site/assets/img/product/decor.png" alt=""></a>
                                    <a class="tpproduct__thumb-img" href="shop-details-4.html"><img src="/web-site/assets/img/product/decor min.png" alt=""></a>
                                    <div class="tpproduct__info bage">
                                        <span class="tpproduct__info-discount bage__discount">-10%</span>
                                    </div>
                                    <div class="tpproduct__shopping">
                                        <a class="tpproduct__shopping-wishlist" href="wishlist.html"><i class="icon-heart icons"></i></a>
                                        <a class="tpproduct__shopping-wishlist" href="#"><i class="icon-layers"></i></a>
                                        <a class="tpproduct__shopping-cart" href="#"><i class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="tpproduct__content">
                                 <span class="tpproduct__content-weight">
                                    <a href="shop-details-3.html">Decors</a>
                                 </span>
                                    <h4 class="tpproduct__title">
                                        <a href="shop-details-4.html">Decoration Item</a>
                                    </h4>
                                    <div class="tpproduct__rating mb-5">
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                    </div>
                                    <div class="tpproduct__price">
                                        <span>Rs 56.00</span>
                                        <del>Rs 19.00</del>
                                    </div>
                                </div>
                                <div class="tpproduct__hover-text">
                                    <div class="tpproduct__hover-btn d-flex justify-content-center mb-10">
                                        <a class="tp-btn-2" href="shop-details-4.html">Add to cart</a>
                                    </div>
                                    <div class="tpproduct__descrip">
                                        <ul>
                                            <li>Type: Aquatic</li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tpproduct p-relative">
                                <div class="tpproduct__thumb p-relative text-center">
                                    <a href="#"><img src="/web-site/assets/img/product/feed.png" alt=""></a>
                                    <a class="tpproduct__thumb-img" href="shop-details.html"><img src="/web-site/assets/img/product/food min.jpg" alt=""></a>
                                    <div class="tpproduct__info bage">
                                        <span class="tpproduct__info-discount bage__discount">-90%</span>
                                        <span class="tpproduct__info-hot bage__hot">HOT</span>
                                    </div>
                                    <div class="tpproduct__shopping">
                                        <a class="tpproduct__shopping-wishlist" href="wishlist.html"><i class="icon-heart icons"></i></a>
                                        <a class="tpproduct__shopping-wishlist" href="#"><i class="icon-layers"></i></a>
                                        <a class="tpproduct__shopping-cart" href="#"><i class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="tpproduct__content">
                                 <span class="tpproduct__content-weight">
                                     <a href="shop-details-4.html">Fish Food</a>
                                 </span>
                                    <h4 class="tpproduct__title">
                                        <a href="shop-details-4.html">Kai Food</a>
                                    </h4>
                                    <div class="tpproduct__rating mb-5">
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                    </div>
                                    <div class="tpproduct__price">
                                        <span>Rs 56.00</span>
                                        <del>Rs 19.00</del>
                                    </div>
                                </div>
                                <div class="tpproduct__hover-text">
                                    <div class="tpproduct__hover-btn d-flex justify-content-center mb-10">
                                        <a class="tp-btn-2" href="shop-details-4.html">Add to cart</a>
                                    </div>
                                    <div class="tpproduct__descrip">
                                        <ul>
                                            <li>Type: Organic</li>
                                            <li>MFG: August 4.2021</li>
                                            <li>LIFE: 60 days</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tpproduct p-relative">
                                <div class="tpproduct__thumb p-relative text-center">
                                    <a href="#"><img src="/web-site/assets/img/product/light.webp" alt=""></a>
                                    <a class="tpproduct__thumb-img" href="shop-details-grid.html"><img src="/web-site/assets/img/product/lighting.jpg" alt=""></a>
                                    <div class="tpproduct__info bage">
                                        <span class="tpproduct__info-discount bage__discount">-50%</span>
                                    </div>
                                    <div class="tpproduct__shopping">
                                        <a class="tpproduct__shopping-wishlist" href="wishlist.html"><i class="icon-heart icons"></i></a>
                                        <a class="tpproduct__shopping-wishlist" href="#"><i class="icon-layers"></i></a>
                                        <a class="tpproduct__shopping-cart" href="#"><i class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="tpproduct__content">
                                 <span class="tpproduct__content-weight">
                                    <a href="shop-details-4.html">Aquariums</a>,
                                    <a href="shop-details-3.html">Lightings</a>
                                 </span>
                                    <h4 class="tpproduct__title">
                                        <a href="shop-details-4.html">AMZBD Led Aquarium Light,Full Spectrum</a>
                                    </h4>
                                    <div class="tpproduct__rating mb-5">
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                    </div>
                                    <div class="tpproduct__price">
                                        <span>Rs 56.00</span>
                                        <del>Rs 19.00</del>
                                    </div>
                                </div>
                                <div class="tpproduct__hover-text">
                                    <div class="tpproduct__hover-btn d-flex justify-content-center mb-10">
                                        <a class="tp-btn-2" href="shop-details-4.html">Add to cart</a>
                                    </div>
                                    <div class="tpproduct__descrip">
                                        <ul>
                                            <li>Type: LED</li>
                                            <li>MFG: August 4.2021</li>
                                            <li>LIFE: 6000 Hours</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tpproduct p-relative">
                                <div class="tpproduct__thumb p-relative text-center">
                                    <a href="#"><img src="/web-site/assets/img/product/pumps.jpg" alt=""></a>
                                    <a class="tpproduct__thumb-img" href="shop-details-grid.html"><img src="/web-site/assets/img/product/pump.jpg" alt=""></a>
                                    <div class="tpproduct__info bage">
                                        <span class="tpproduct__info-discount bage__discount">-40%</span>
                                        <span class="tpproduct__info-hot bage__hot">HOT</span>
                                    </div>
                                    <div class="tpproduct__shopping">
                                        <a class="tpproduct__shopping-wishlist" href="wishlist.html"><i class="icon-heart icons"></i></a>
                                        <a class="tpproduct__shopping-wishlist" href="#"><i class="icon-layers"></i></a>
                                        <a class="tpproduct__shopping-cart" href="#"><i class="icon-eye"></i></a>
                                    </div>
                                </div>
                                <div class="tpproduct__content">
                                 <span class="tpproduct__content-weight">
                                    <a href="shop-details-4.html">Pumps</a>
                                 </span>
                                    <h4 class="tpproduct__title">
                                        <a href="shop-details-4.html">hygger 1060GPH Quiet Submersible and External 24V Water Pump</a>
                                    </h4>
                                    <div class="tpproduct__rating mb-5">
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                        <a href="#"><i class="icon-star_outline1"></i></a>
                                    </div>
                                    <div class="tpproduct__price">
                                        <span>Rs 56.00</span>
                                        <del>Rs 19.00</del>
                                    </div>
                                </div>
                                <div class="tpproduct__hover-text">
                                    <div class="tpproduct__hover-btn d-flex justify-content-center mb-10">
                                        <a class="tp-btn-2" href="shop-details-4.html">Add to cart</a>
                                    </div>
                                    <div class="tpproduct__descrip">
                                        <ul>
                                            <li>Type: Water Pump</li>
                                            <li>MFG: August 4.2022</li>
                                            <li>LIFE: 60 days</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tpproduct-btn">
                    <div class="tpprduct-arrow tpproduct-btn__prv"><a href="#"><i class="icon-chevron-left"></i></a></div>
                    <div class="tpprduct-arrow tpproduct-btn__nxt"><a href="#"><i class="icon-chevron-right"></i></a></div>
                </div>
            </div>
        </div>
    </section>
    <!-- product-area-end -->
</template>

<script setup>
import {watch, ref} from "@vue/runtime-core";
import {useInertiaPropsUtility} from "@admin/Composables/inertiaPropsUtility";
const {iPropsValue} = useInertiaPropsUtility();
const productInfo = ref(iPropsValue("productInfo"));
watch( ()=> iPropsValue("productInfo") ,
    ()=>{
        productInfo.value = iPropsValue("productInfo")
    })
console.log(productInfo.value);
</script>

<style lang="scss" scoped>

</style>
