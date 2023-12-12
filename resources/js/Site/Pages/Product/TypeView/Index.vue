<template>
  <Head>
    <title>{{typeName}}</title>
  </Head>
  <div class="breadcrumb__area grey-bg py-3">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="tp-breadcrumb__content">
            <div class="tp-breadcrumb__list">
                            <span class="tp-breadcrumb__active"><NavLink
                                :href="appRoute('homepage')">Home</NavLink></span>
              <span class="dvdr"> / </span>
              <span><NavLink
                  :href="appRoute('product.category.view',categoryName)">{{
                  readableWord(categoryName)
                }}</NavLink> </span>
              <span class="dvdr"> / </span>
              <span>{{ readableWord(typeName) }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <section class="shop-area-start grey-bg pb-200">
    <div class="container">
      <div class="col-xl-12 col-lg-12 col-md-12 ">

        <div class="product__filter-content mb-10">
          <div class="row align-items-center">
            <div class="col-sm-4">
              <div class="product__item-count">
                <span>Showing {{ products.from }} {{
                    products.from == products.to ? '' : ' - ' + products.to
                  }} of {{ products.total }} Products</span>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="tpproductnav tpnavbar product-filter-nav d-flex align-items-center justify-content-center">
                <nav>
                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link" :class="{'active' : viewListType == 'grid'}"
                            @click="selectedListType('grid')" id="nav-all-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-all" type="button" role="tab" aria-controls="nav-all"
                            aria-selected="true">
                      <i>
                        <svg width="22" height="16" viewBox="0 0 22 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path
                              d="M2 4C3.10457 4 4 3.10457 4 2C4 0.89543 3.10457 0 2 0C0.89543 0 0 0.89543 0 2C0 3.10457 0.89543 4 2 4Z"
                              fill="currentColor"></path>
                          <path
                              d="M2 10C3.10457 10 4 9.10457 4 8C4 6.89543 3.10457 6 2 6C0.89543 6 0 6.89543 0 8C0 9.10457 0.89543 10 2 10Z"
                              fill="currentColor"></path>
                          <path
                              d="M2 16C3.10457 16 4 15.1046 4 14C4 12.8954 3.10457 12 2 12C0.89543 12 0 12.8954 0 14C0 15.1046 0.89543 16 2 16Z"
                              fill="currentColor"></path>
                          <path
                              d="M8 4C9.10457 4 10 3.10457 10 2C10 0.89543 9.10457 0 8 0C6.89543 0 6 0.89543 6 2C6 3.10457 6.89543 4 8 4Z"
                              fill="currentColor"></path>
                          <path
                              d="M8 10C9.10457 10 10 9.10457 10 8C10 6.89543 9.10457 6 8 6C6.89543 6 6 6.89543 6 8C6 9.10457 6.89543 10 8 10Z"
                              fill="currentColor"></path>
                          <path
                              d="M8 16C9.10457 16 10 15.1046 10 14C10 12.8954 9.10457 12 8 12C6.89543 12 6 12.8954 6 14C6 15.1046 6.89543 16 8 16Z"
                              fill="currentColor"></path>
                          <path
                              d="M14 4C15.1046 4 16 3.10457 16 2C16 0.89543 15.1046 0 14 0C12.8954 0 12 0.89543 12 2C12 3.10457 12.8954 4 14 4Z"
                              fill="currentColor"></path>
                          <path
                              d="M14 10C15.1046 10 16 9.10457 16 8C16 6.89543 15.1046 6 14 6C12.8954 6 12 6.89543 12 8C12 9.10457 12.8954 10 14 10Z"
                              fill="currentColor"></path>
                          <path
                              d="M14 16C15.1046 16 16 15.1046 16 14C16 12.8954 15.1046 12 14 12C12.8954 12 12 12.8954 12 14C12 15.1046 12.8954 16 14 16Z"
                              fill="currentColor"></path>
                          <path
                              d="M20 4C21.1046 4 22 3.10457 22 2C22 0.89543 21.1046 0 20 0C18.8954 0 18 0.89543 18 2C18 3.10457 18.8954 4 20 4Z"
                              fill="currentColor"></path>
                          <path
                              d="M20 10C21.1046 10 22 9.10457 22 8C22 6.89543 21.1046 6 20 6C18.8954 6 18 6.89543 18 8C18 9.10457 18.8954 10 20 10Z"
                              fill="currentColor"></path>
                          <path
                              d="M20 16C21.1046 16 22 15.1046 22 14C22 12.8954 21.1046 12 20 12C18.8954 12 18 12.8954 18 14C18 15.1046 18.8954 16 20 16Z"
                              fill="currentColor"></path>
                        </svg>
                      </i>
                    </button>
                    <button class="nav-link" :class="{'active' : viewListType == 'list'}"
                            @click="selectedListType('list')" id="nav-product-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-product" type="button" role="tab" aria-controls="nav-product"
                            aria-selected="false" tabindex="-1">
                      <i>
                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path
                              d="M2 4C3.10457 4 4 3.10457 4 2C4 0.89543 3.10457 0 2 0C0.89543 0 0 0.89543 0 2C0 3.10457 0.89543 4 2 4Z"
                              fill="currentColor"></path>
                          <path
                              d="M2 10C3.10457 10 4 9.10457 4 8C4 6.89543 3.10457 6 2 6C0.89543 6 0 6.89543 0 8C0 9.10457 0.89543 10 2 10Z"
                              fill="currentColor"></path>
                          <path
                              d="M2 16C3.10457 16 4 15.1046 4 14C4 12.8954 3.10457 12 2 12C0.89543 12 0 12.8954 0 14C0 15.1046 0.89543 16 2 16Z"
                              fill="currentColor"></path>
                          <path
                              d="M20 2C20 2.552 19.553 3 19 3H7C6.448 3 6 2.552 6 2C6 1.448 6.448 1 7 1H19C19.553 1 20 1.447 20 2Z"
                              fill="currentColor"></path>
                          <path
                              d="M20 8C20 8.552 19.553 9 19 9H7C6.448 9 6 8.552 6 8C6 7.448 6.448 7 7 7H19C19.553 7 20 7.447 20 8Z"
                              fill="currentColor"></path>
                          <path
                              d="M20 14C20 14.552 19.553 15 19 15H7C6.448 15 6 14.552 6 14C6 13.447 6.448 13 7 13H19C19.553 13 20 13.447 20 14Z"
                              fill="currentColor"></path>
                        </svg>
                      </i>
                    </button>
                  </div>
                </nav>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="product__navtabs d-flex justify-content-end align-items-center">
                <div class="tp-shop-selector">

                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade" :class="{'active show' : viewListType == 'grid'}" id="nav-all" role="tabpanel"
               aria-labelledby="nav-all-tab">
            <div v-if="products.data.length > 0"
                 class="row row-cols-xxl-4 row-cols-xl-4 row-cols-lg-3 row-cols-md-3 row-cols-sm-2 row-cols-1 tpproduct__shop-item">

              <div class="col" style="z-index: 1;" v-for="product in products.data">
                <ProductCard :product-info="product" class="mb-6"/>
              </div>
            </div>
            <div v-else>
              <NoRecords/>
            </div>
          </div>
          <div class="tab-pane fade whight-product" :class="{'active show' : viewListType == 'list'}" id="nav-product"
               role="tabpanel" aria-labelledby="nav-product-tab">
            <div class="row">
              <div class="col-lg-12" v-if="products.data.length > 0" v-for="product in products.data">
                <ProductCardList :product-info="product"/>
              </div>
              <div v-else>
                <NoRecords/>
              </div>
            </div>
          </div>
        </div>
        <div class="basic-pagination text-center mt-35">
          <pagination class="mt-6" :links="products.links"/>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import {ref, watch, computed, onMounted} from "vue";
import {useInertiaPropsUtility} from "@admin/Composables/inertiaPropsUtility";
import {useLocalStorageUtility} from "@admin/Composables/localStorageUtility";
import {useStringUtility} from "@admin/Composables/stringUtility";

import Pagination from '@/Components/Pagination'
import ProductCard from "@/Components/ProductCard.vue"
import ProductCardList from "@/Components/ProductCardList.vue"
import NoRecords from "@/Components/NoRecords.vue";

const {iPropsValue} = useInertiaPropsUtility();
const {readableWord} = useStringUtility();
const {setWithExpiry, getWithExpiry} = useLocalStorageUtility();

// const testData = iPropsValue('app_info','title');
const products = ref(iPropsValue('products'));
const viewListType = ref('list');
const categoryName = ref('');
const typeName = ref('');
watch(
    () => iPropsValue('products'),
    () => {
      products.value = iPropsValue('products')
    }
)
const selectedListType = (type) => {
  setWithExpiry('viewListType', type, 3600000)
}
// const props = defineProps({
//     products:Object
// })
onMounted(() => {
  const parts = products.value.path.split('/');
  categoryName.value = parts[parts.length - 2];
  typeName.value = parts[parts.length - 1];
  viewListType.value = getWithExpiry('viewListType') ?? 'list'
})

</script>

<style lang="scss" scoped>

</style>
