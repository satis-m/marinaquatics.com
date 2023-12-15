<template>
  <Head>
    <title>{{productInfo.name}}</title>
    <meta head-key="description" name="description"
          :content="productInfo.name+' | '+removeHTMLTags(productInfo.product_info)">

    <meta head-key="og:description" property="og:description"
          :content="productInfo.name+' | '+removeHTMLTags(productInfo.product_info)">

    <link head-key="canonical" rel="canonical" :href="iPropsValue('ziggy','url')">
    <meta head-key='og:url' property="og:url" :content="iPropsValue('ziggy','url')">
    <meta inertia='og:title' property="og:title" :content="productInfo.name">
    <meta head-key='og:image' property="og:image" :content="productInfo.main_picture.thumbnail">

  </Head>
  <!-- breadcrumb-area-start -->
  <div class="breadcrumb__area grey-bg py-3">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="tp-breadcrumb__content">
            <div class="tp-breadcrumb__list">
                            <span class="tp-breadcrumb__active"><NavLink
                                :href="appRoute('homepage')">Home</NavLink></span>
              <span class="dvdr">/</span>
              <span class="tp-breadcrumb__active">{{ productInfo.category.name }}</span>
              <span class="dvdr">/</span>
              <span><NavLink :href="appRoute('product.category.view',[ productInfo.category.slug ])">{{
                  productInfo.category.sub_category
                }}</NavLink></span>
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
        <div class="col-xs-12">
          <div class="tpdetails__area  pb-30">
            <div class="tpdetails__product mb-30">
              <!--              <div class="tpdetails__title-box">-->

              <!--                &lt;!&ndash;                                <SubInfo/>&ndash;&gt;-->
              <!--              </div>-->
              <div class="tpdetails__box">
                <div class="row">
                  <div class="col-lg-8">
                    <div class="tpproduct-details__nab">
                      <div class="tab-content product-image-preview" v-viewer="options" id="nav-tabContents">
                        <div class="tab-pane fade show active w-img hover:cursor-zoom-in"
                             :id="'preview-image-'+productInfo.main_picture?.id" role="tabpanel"
                             :aria-labelledby="'nav-image-'+productInfo.main_picture?.id"
                             tabindex="0">
                          <ImageWithFallback :source="productInfo.main_picture.original" :alt="productInfo.slug"/>
                          <div class="tpproduct__info bage">
                            <span v-if="productInfo.highlight != null" class="tpproduct__info-hot bage__highlight">{{ productInfo.highlight }}</span>
                            <span v-if="productInfo.current_discount != null" class="tpproduct__info-discount bage__discount">
                              {{ productInfo.current_discount.discount}}%
                            </span>
                            <span v-if="outOfStock" class="tpproduct__info-hot bage__hot">Out of Stock</span>
                            <span v-if="newStock" class="tpproduct__info-hot bage__new">New</span>
                          </div>
                        </div>
                        <div :key="key"
                             v-for="(alternativePicture , key) in productInfo.alternative_picture"
                             class="tab-pane fade w-img hover:cursor-zoom-in"
                             :id="'preview-image-'+alternativePicture?.id" role="tabpanel"
                             :aria-labelledby="'nav-image-'+alternativePicture?.id"
                             tabindex="0">
                          <ImageWithFallback :source="alternativePicture.original" :alt="productInfo.slug"/>
                          <div class="tpproduct__info bage">
                                                        <span v-if="productInfo.current_discount != null"
                                                              class="tpproduct__info-discount bage__discount">{{
                                                            productInfo.current_discount.discount
                                                          }}%</span>
                            <span v-if="outOfStock" class="tpproduct__info-hot bage__hot">Out of Stock</span>
                            <span v-if="newStock"
                                  class="tpproduct__info-hot bage__new">New</span>
                          </div>
                        </div>

                      </div>
                      <nav>
                        <div class="nav nav-tabs justify-content-left" id="nav-tab"
                             role="tablist">
                          <button v-if="hasVideo" @click="showVideo=true"
                                  class="nav-link"
                                  type="button" role="tab" aria-controls="nav-home"
                                  aria-selected="true">
                            <img :src="siteUrl('/web-site/assets/img/icon/youtube-icon.svg')"
                                 :alt="productInfo.slug+' video link'">
                          </button>
                          <button class="nav-link active"
                                  :id="'nav-image-'+productInfo.main_picture?.id"
                                  data-bs-toggle="tab"
                                  :data-bs-target="'#preview-image-'+productInfo.main_picture?.id"
                                  type="button" role="tab" aria-controls="nav-home"
                                  aria-selected="true">
                            <ImageWithFallback :source="productInfo.main_picture.thumbnail" :alt="productInfo.slug"/>
                          </button>
                          <button :key="key"
                                  v-for="(alternativePicture , key) in productInfo.alternative_picture"
                                  class="nav-link" :id="'nav-image-'+alternativePicture.id"
                                  data-bs-toggle="tab"
                                  :data-bs-target="'#preview-image-'+alternativePicture.id"
                                  type="button" role="tab"
                                  :aria-controls="'preview-image-'+alternativePicture.id"
                                  aria-selected="false">
                            <ImageWithFallback :source="alternativePicture.thumbnail"
                                               :alt="productInfo.slug"/>
                          </button>
                        </div>
                      </nav>
                    </div>
                  </div>
                  <div class="col-lg-4 mt-10 lg:mt-0">
                    <h1 class=" text-4xl font-bold uppercase mb-3">{{ productInfo.name }}</h1>
                    <ul class="combo-offer mb-3  md:justify-start justify-center">
                      <button
                          v-if="productInfo.combo_offer.name_1 !='' && productInfo.combo_offer.name_1 != null  "
                          class="navigation-tab" :class="isOfferSelected(1)"
                          :disabled="!checkStockByOffer(1)" @click="selectOffer(1)" type="button">
                        {{ productInfo.combo_offer.name_1 }}
                      </button>
                      <button
                          v-if="productInfo.combo_offer.name_2 !='' && productInfo.combo_offer.name_2 != null  "
                          class="navigation-tab" :class="isOfferSelected(2)"
                          :disabled="!checkStockByOffer(2)" @click="selectOffer(2)" type="button">
                        {{ productInfo.combo_offer.name_2 }}
                      </button>
                      <button
                          v-if="productInfo.combo_offer.name_3 !='' && productInfo.combo_offer.name_3 != null  "
                          class="navigation-tab" :class="isOfferSelected(3)"
                          :disabled="!checkStockByOffer(3)" @click="selectOffer(3)" type="button">
                        {{ productInfo.combo_offer.name_3 }}
                      </button>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                      <div class="tab-pane fade show active">
                        <div class="product__details">
                          <div class="product__details-price-box">
                            <div
                                v-if="productInfo.current_discount != null && formData.offer.key == 1"
                                class="product__details-price flex flex-col">
                                                            <span>
                                                           Rs {{ formattedPrice(discountPrice) }}
                                                            </span>
                              <del> Rs {{ formattedPrice(productPrice) }}</del>
                            </div>
                            <div v-else class="product__details-price">
                                                            <span>
                                                           Rs {{ formattedPrice(productPrice) }}
                                                            </span>
                            </div>
                            <div v-html="productInfo.product_info"
                                 class="product-info mt-3"></div>
                          </div>
                          <div class="product__details-cart">
                            <div
                                class="product__details-quantity d-flex align-items-center mb-15">
                              <b>Qty:</b>
                              <CartInput @limitReach="handleLimitReach"
                                         :max="maxCartInput" ref="refCartInput"
                                         @updateCount="updateCount"
                                         :disable="outOfStock"/>
                              <button class="tp-btn-2 px-4 ml-4 cart_button max-sm:mt-2"
                                      @click="addToCart"
                                      :disabled="outOfStock" data-bs-toggle="tooltip"
                                      data-bs-title="Default tooltip"
                                      :title="productInfo.available_quantity > 0 ? 'Add to cart': 'Out of Stock'">
                                <i class="icon-add_shopping_cart"></i> add to cart
                              </button>
                            </div>
                            <ul class="product__details-check">

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
                                <i v-if="outOfStock" class="out-of-stock">Out of
                                  stock</i>
                                <i v-else
                                   class="in-stock">{{ productInfo.available_quantity }}
                                  Instock</i>
                              </li>
                              <li>Categories: <span>{{
                                  productInfo.category.name
                                }}, {{ productInfo.category.sub_category }} </span></li>
                              <li>Tags: <span class="badge bg-[#12b3ca] ml-2 capitalize"
                                              v-for="tag in productInfo.tag"
                                              v-text="tag"> </span></li>
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
                  <div class="nav nav-tabs" role="tablist">
                    <h2 class="nav-link active m-0 py-3 text-lg px-0" id="nav-description-tab"
                        data-bs-toggle="tab" data-bs-target="#nav-description" type="button"
                        role="tab" aria-controls="nav-description" aria-selected="true">Product
                      Description
                    </h2>
                  </div>
                </nav>
              </div>
              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-description" role="tabpanel"
                     aria-labelledby="nav-description-tab" tabindex="0"
                     v-html="productInfo.description">

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- shop-details-area-end -->
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

    <Modal v-if="hasVideo" @close-modal="showVideo=false, iframeVideoKey++" :key="iframeVideoKey" v-show="showVideo">
      <template v-slot:header>
        neon tetra
      </template>
      <template v-slot:body>
        <iframe width="100%" height="315"
                :src="getFrameVideoLink()"
                :title="productInfo.name" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen></iframe>
      </template>
      <template v-slot:footer>
        <div class="flex gap-2">
        </div>
      </template>
    </Modal>
  </Teleport>
</template>

<script setup>
import Modal from "@/Components/Modal.vue"
import {watch, ref, unref, reactive, onMounted, computed} from "@vue/runtime-core";
import {useAppUtility} from "@admin/Composables/appUtility";
import {useStringUtility} from "@admin/Composables/stringUtility";
import {useObjectUtility} from "@admin/Composables/objectUtility";
import {useInertiaPropsUtility} from "@admin/Composables/inertiaPropsUtility";
import CartInput from "@/Components/CartInput.vue";
import {useForm} from "@inertiajs/vue3";
import moment from "moment";
import {Head} from '@inertiajs/vue3'
import ImageWithFallback from "@/Components/ImageWithFallback.vue";

import 'viewerjs/dist/viewer.css'
// import SubInfo from "./Components/SubInfo.vue";

const maxCartInput = ref(0);
const {mediaCheck, siteUrl} = useAppUtility();
const {removeHTMLTags} = useStringUtility();
const {iPropsValue} = useInertiaPropsUtility();
let {getObjectRow} = useObjectUtility();
const productInfo = ref(iPropsValue("productInfo"));
const discountedPrice = computed(() => {
  const {price, current_discount: {discount}} = productInfo.value;
  return +price - (+discount / 100) * +price;
})

const productPrice = ref(productInfo.value.price)
const discountPrice = ref(discountedPrice);
const formData = useForm({
  _method: "POST",
  product_slug: productInfo.value.slug,
  name: productInfo.value.name,
  offer: {
    key: '',
    name: '',
    quantity: '',
    price: '',
  },
  quantity: 1,
});
const iframeVideoKey = ref(1);
const showModal = ref(false);
const showVideo = ref(false);
const refCartInput = ref(null);
const userLoggedIn = iPropsValue('auth')
const cartItems = ref(iPropsValue('auth', 'cart'));
watch(() => iPropsValue('auth', 'cart'), (newVal) => {
  cartItems.value = newVal;
  refCartInput.value.resetCounter();
  // updateTotal();
  // updateItemCount();
})
watch(() => iPropsValue("productInfo"),
    () => {
      productInfo.value = iPropsValue("productInfo")
    }
)
const outOfStock = computed(() => {
  return productInfo.value.available_quantity < 1
})
const newStock = computed(() => {
  if (productInfo.value.last_import?.created_at != undefined) {
    const currentDate = moment()
    const oneWeekFromNow = moment().add(1, 'week')
    const dateToCheck = moment(productInfo.value.last_import.created_at);
    return dateToCheck.isBefore(oneWeekFromNow);
  }
});
const isOfferSelected = (option) => {
  return formData.offer.key == option ? 'active' : '';
}

const updateCount = (value) => {
  formData.quantity = value;
}

const selectOffer = (option) => {
  const available_product = productInfo.value.available_quantity;
  formData.offer.key = option;
  formData.offer.name = productInfo.value.combo_offer['name_' + option];
  formData.offer.price = productInfo.value.combo_offer['price_' + option];
  formData.offer.quantity = productInfo.value.combo_offer['quantity_' + option];
  // productPrice.value = productInfo.value.current_discount != null && option == 1 ? productInfo.value.combo_offer['price_' + option] : productInfo.value.combo_offer['price_' + option]
  productPrice.value = productInfo.value.combo_offer['price_' + option]
  refCartInput.value.resetCounter();
  formData.quantity = 1;
  maxCartInput.value = Math.floor((available_product / productInfo.value.combo_offer['quantity_' + option]));
}
const updateMaxCartInput = () => {
  const available_product = productInfo.value.available_quantity;
  const cartItem = getObjectRow(cartItems.value, 'product_slug', productInfo.value.slug);
  if (cartItem.length > 0) {
    if (cartItem[0]['offer_name'] == formData.offer.name) {
      maxCartInput.value = Math.floor((available_product / cartItem[0]['offer_quantity']) - cartItem[0]['quantity']);
    } else {
      if (formData.offer.name == "Standard") {

      }
      if (cartItem[0]['offer_name'] == "Standard") {
        maxCartInput.value = Math.floor((available_product / cartItem[0]['offer_quantity']) - cartItem[0]['quantity']);
      } else {
        maxCartInput.value = Math.floor((available_product / cartItem[0]['offer_quantity']) - (cartItem[0]['quantity'] * cartItem[0]['offer_quantity']));
      }
      // maxCartInput.value = Math.floor((available_product / cartItem[0]['offer_quantity']) - cartItem[0]['quantity']);
    }
  } else {
    maxCartInput.value = Math.floor((available_product / formData.offer.quantity));
  }
  // console.log(maxCartInput.value);

  // maxCartInput.value =  Math.floor((available_product / productInfo.value.combo_offer['quantity_' + option]));
}
const formattedPrice = (price) => {
  if (typeof price !== 'number') {
    return price;
  }
  return price.toLocaleString();
}

const checkStockByOffer = (option) => {
  const available_product = productInfo.value.available_quantity;
  if (available_product > productInfo.value.combo_offer['quantity_' + option])
    return true
  return false;
}
const handleLimitReach = () => {
  vt.info("stock limit reached")
}
const addToCart = () => {

  // const userLoggedIn = iPropsValue('auth')
  if (userLoggedIn) {
    try {
      formData.post(route("user.cart.add"), {
        preserveScroll: true,
        onSuccess: () => {
          refCartInput.value.resetCounter();
          formData.quantity = 1;
          //formData.reset();
        },
      })
    } catch (error) {
      vt.error("Request Cart Error")
      console.log(error);
    }
  } else {
    showModal.value = true;
  }

}

const getFrameVideoLink = () => {
  const link = productInfo.value.video_link;
  if (link != '' && link != null) {
    // Extract the video ID from the YouTube link
    const match = link.match(/(?:youtube\.com\/watch\?v=|youtu.be\/)([\w-]+)/i);
    if (match) {
      const videoId = match[1];
      // Create the embedded iframe URL
      const frameLink = `https://www.youtube.com/embed/${videoId}`;
      return frameLink + '?playsinline=1&autoplay=0&showinfo=0&rel=0&iv_load_policy=3&enablejsapi=1&widgetid=7';

    } else {
      return null; // Invalid YouTube link
    }

  }

}
const hasVideo = getFrameVideoLink() != null;

const options = {
  movable: true,
  toolbar: {
    prev: 1, // Keep previous button
    zoomIn: 1, // Remove zoom in button
    zoomOut: 1, // Remove zoom out button
    reset: 1, // Remove reset button
    next: 1, // Keep next button
    oneToOne: 0, // Remove original size button
    play: 0, // Keep play button
    rotateLeft: 0, // Keep rotate left button
    rotateRight: 0, // Keep rotate right button
    flipHorizontal: 0, // Keep flip horizontal button
    flipVertical: 0, // Keep flip vertical button
  }
};
onMounted(() => {
  if (outOfStock.value === false)
    selectOffer(1);
})
</script>

<style lang="scss">
@media (width >= 600px) {
  .product-image-preview {
    display: flex;
    justify-content: center;
    align-items: center;

    .w-img {
      height: 600px;

      img {
        height: 100%;
        width: 100%;
        object-fit: contain;
      }
    }
  }
}

#nav-description {
  h2, h2 {
    color: var(--tp-heading-primary);
    font-family: var(--tp-ff-jost);
    font-weight: 600;

  }
}

.add-to-cart-btn {
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

  i {
    font-size: 16px;
  }
}

.combo-offer {
  display: flex;
  justify-content: left;
  align-items: center;
  height: 50px;
  column-gap: 24px;

  button {
    height: 100%;
    padding: 0 16px;
    border-radius: 6px;
  }
}

.product-info {
  ul {
    li {
      font-family: var(--tp-ff-jost);
      list-style: none;
      font-weight: 400;
      line-height: 22px;
      color: var(--tp-text-body);
      position: relative;
      padding-left: 18px;

      &::after {
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

.combo-offer {
  button.navigation-tab {
    text-transform: capitalize;

    &.active {
      background-color: #ffdcdc !important;
      color: var(--tp-heading-secondary) !important;
      border-color: var(--tp-heading-secondary) !important;
    }

    &[disabled] {
      cursor: not-allowed;
      background-color: #f3f3f3 !important;
    }
  }
}

.cart_button {
  &[disabled] {
    color: var(--tp-common-white);
    background-color: #dc7984;
    cursor: not-allowed;
  }
}
</style>
