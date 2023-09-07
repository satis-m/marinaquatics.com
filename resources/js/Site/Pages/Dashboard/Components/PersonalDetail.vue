<template>

        <div class="col-md-6 col-12 px-2">
            <div class="tptrack__email white-bg mb-10">
                <span><i class="icon-user"></i></span>
                <input type="text" v-model="formData.name" placeholder="Full Name">
                <div class="error-msg"></div>
            </div>
        </div>
        <div class="col-md-6 col-12 px-2">
            <div class="tptrack__email white-bg mb-10">
                <span><i class="icon-phone"></i></span>
                <input type="text"  v-model="formData.contact"  placeholder="Contact">
                <div class="error-msg"></div>
            </div>
        </div>
        <div class="col-md-6 col-12 px-2">
            <div class="tptrack__email white-bg mb-10">
                <span><i class="icon-calendar"></i></span>
                <input type="text" onfocus="(this.type='date')"  onblur="(this.value == '' ? this.type='text' :'')" :min="min_dob" :max="max_dob"  v-model="formData.dob" placeholder="Birth Date">
                <div class="error-msg"></div>
            </div>
        </div>
        <div class="col-md-6 col-12 px-2">
            <p class="mb-2">Gender</p>
            <label class="mr-2">
                <input type="radio" name="gender" value="female" placeholder="Full Name"> Female
            </label>
            <label  class="mr-2">
                <input type="radio" name="gender" value="male" placeholder="Full Name"> Male
            </label>
            <label  class="mr-2">
                <input type="radio" name="gender" value="other" placeholder="Full Name"> Others
            </label>

        </div>
        <div class="col-12 px-2">
            <div class="d-flex justify-content-end gap-3">
                <div class="tptrack__btn">
                    <button class="action-btn btn-white " type="button" @click="loginUser" >Reset
                    </button>
                </div>
                <div class="tptrack__btn">
                    <button class="action-btn btn-red" type="button" @click="loginUser" >Update
                    </button>
                </div>
            </div>
        </div>

</template>

<script setup>
import {ref,onMounted} from "vue"
import {useForm} from "@inertiajs/vue3";

import { useInertiaPropsUtility } from "@admin/Composables/inertiaPropsUtility";
const { iPropsValue } = useInertiaPropsUtility();

const getDateBeforeYear = (yr)=>{
    const currentDate = new Date();

    // Subtract 4 years
    currentDate.setFullYear(currentDate.getFullYear() - yr);

    // Format the date as needed (e.g., to display it)
    const year = currentDate.getFullYear();
    const month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Add 1 because months are 0-indexed
    const day = String(currentDate.getDate()).padStart(2, '0');

    return `${year}-${month}-${day}`;
}

const min_dob = getDateBeforeYear(100)
const max_dob= getDateBeforeYear(6)
const formData = useForm({
    name: iPropsValue('auth','user.name'),
    contact: iPropsValue('auth','user.contact'),
    dob: iPropsValue('auth','user.dob'),
    gender: iPropsValue('auth','user.gender')
})


</script>
