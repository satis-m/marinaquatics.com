<template>
  <Head>
    <title>Login / Signup</title>
  </Head>
    <!-- breadcrumb-area-start -->
    <div class="breadcrumb__area py-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-breadcrumb__content">
                        <div class="tp-breadcrumb__list">
                            <span class="tp-breadcrumb__active"><NavLink :href="appRoute('homepage')">Home</NavLink></span>
                            <span class="dvdr">/</span>
                            <span>Sign in</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area-end -->

    <!-- track-area-start -->
    <section class="track-area pb-40">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-sm-12">
                    <div class="tptrack__product  mb-10">
                        <div class="tptrack__content grey-bg">
                            <div class="tptrack__item d-flex mb-10">
                                <div class="tptrack__item-icon">
                                    <i class="icon-log-in"></i>
                                </div>
                                <div class="tptrack__item-content">
                                    <h4 class="tptrack__item-title">Login Here</h4>
                                    <p>Your personal data will be used to support your experience throughout this
                                        website, to manage access to your account.</p>
                                </div>
                            </div>
                            <div class="tptrack__id mb-10">
                                <form action="#">
                                    <span><i class="icon-user1"></i></span>
                                    <input type="email" v-on:keydown.enter.prevent='loginUser' v-model="loginFormData.email" placeholder="Username / email address">
                                    <div class="error-msg">{{ loginEmailError  }}</div>
                                </form>
                            </div>
                            <div class="tptrack__email mb-10">
                                <form action="#">
                                    <span><i class="icon-key"></i></span>
                                    <input type="password"  v-on:keydown.enter.prevent='loginUser' v-model="loginFormData.password" placeholder="Password">
                                    <div class="error-msg">{{ loginPasswordError  }}</div>
                                </form>
                            </div>
                            <div class="tpsign__remember d-flex align-items-center justify-content-between mb-15">
                                <div class="form-check">
                                    <input class="form-check-input"  v-on:keydown.enter.prevent='loginUser' v-model="loginFormData.remember" type="checkbox" value="" id="flexCheckDefault2">
                                    <label class="form-check-label" for="flexCheckDefault2">Remember me</label>
                                </div>
                                <div class="tpsign__pass">
                                    <a href="#">Forget Password</a>
                                </div>
                            </div>
                            <div class="tptrack__btn">
                                <button class="tptrack__submition active" type="button" @click="loginUser" >Login Now<i class="icon-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="tptrack__product  mb-10">
                        <div class="tptrack__content grey-bg">
                            <div class="tptrack__item d-flex mb-10">
                                <div class="tptrack__item-icon">
                                    <i class="icon-lock"></i>
                                </div>
                                <div class="tptrack__item-content">
                                    <h4 class="tptrack__item-title">Sign Up</h4>
                                    <p>Your personal data will be used to support your experience throughout this
                                        website, to manage access to your account.</p>
                                </div>
                            </div>
                            <div class="tptrack__id mb-10">
                                <span><i class="icon-mail"></i></span>
                                <input type="email"  v-on:keydown.enter.prevent='verifyOtp' v-model="formData.email" @blur="validateEmail" placeholder="Email address">
                                <div class="error-msg">{{ emailError }}</div>
                            </div>
                            <div class="tptrack__email mb-10">
                                <span><i class="icon-lock"></i></span>
                                <input type="text" v-on:keydown.enter.prevent='verifyOtp' v-model="formData.otp" @blur="validateOpt" placeholder="OTP from email">
                                <button @click="sendOtp" :disabled="otpDisable" v-show="emailError ==''&& formData.email !='' ">Send OTP</button>
                                <div class="error-msg">{{ otpError }}</div>
                                <div class="info-msg">{{ otpStatus }}</div>
                            </div>
                            <div class="tpsign__account mb-15">
                               &nbsp;
                            </div>
                            <div class="tptrack__btn">
                                <button class="tptrack__submition tpsign__reg" :disabled="emailError ==''&&otpError ==''? false:true" @click="verifyOtp">Verify & Register Now
                                    <i v-if="!verifying" class="icon-arrow-right"></i>
                                    <div v-else class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <Modal @close-modal="showModal=false" v-show="showModal">
        <template v-slot:header>
            Register Account
        </template>
        <template v-slot:body>

                        <div class="tptrack__email white-bg">
                            <span><i class="icon-user"></i></span>
                            <input type="text" v-model="formData.name" class="!h-[45px]"  placeholder="Full Name">
                        </div>
                            <div class="text-red-600 text-left text-sm min-h-[24px]">{{ nameError }}</div>
                        <div class="tptrack__email white-bg">
                            <span><i class="icon-phone"></i></span>
                            <input type="tel" v-model="formData.contact" class="!h-[45px]" placeholder="Mobile Number">
                        </div>
                            <div class="text-red-600 text-left text-sm min-h-[24px]">{{ contactError }}</div>

                        <div class="tptrack__email white-bg ">
                            <span><i class="icon-key"></i></span>
                            <input type="password" v-model="formData.password"  @blur="validatePassword" class="!h-[45px]" placeholder="Password">
                        </div>
                            <div class="text-red-600 text-left text-sm min-h-[24px]">{{ passwordError }}</div>
                        <div class="tptrack__email white-bg">
                            <span><i class="icon-key"></i></span>
                            <input type="password" v-model="formData.password_confirmation" class="!h-[45px]" required @blur="validateConfirmPassword"
                                   placeholder="Verify Password">
                        </div>
                            <div class="text-red-600 text-left text-sm min-h-[24px]">{{ confirmPasswordError }}</div>
        </template>
        <template v-slot:footer>
           <button class="btn btn-danger" v-bind:disabled="!validatePassword() || !validateConfirmPassword()" @click="signupUser">Register</button>
           <button class="btn" @click="showModal=false">Cancel</button>
        </template>
    </Modal>
</template>

<script setup>
import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";
import Modal from "@/Components/Modal.vue"
import Swal from 'sweetalert2'
import { useInertiaPropsUtility } from "@admin/Composables/inertiaPropsUtility";
const { iPropsValue } = useInertiaPropsUtility();

const loginEmailError  = ref('');
const loginPasswordError  = ref('');
const emailError = ref('');
const contactError = ref('');
const nameError = ref('');
const passwordError = ref('');
const confirmPasswordError = ref('');
const otpError = ref('');
const otpStatus = ref('');
const showModal = ref(false);
const verifying = ref(false);
const otpDisable = ref(false);
const loginFormData = useForm({
    _method: "POST",
    email: "",
    password: '',
    remember: ''
});
const formData = useForm({
    _method: "POST",
    name:"",
    contact:"",
    email: "",
    password: '',
    password_confirmation: '',
    otp:''

});

const loadServerValidationError = () => {
    emailError.value = formData.errors.email
    passwordError.value = formData.errors.password
    confirmPasswordError.value = formData.errors.confirm_password
    otpError.value = formData.errors.otp

};

const clearServerValidationError = () => {
    emailError.value ='';
    passwordError.value = '';
    confirmPasswordError.value = '';
    otpError.value = '';
};
const isSignUpValidate = ()=>{
    validateEmail()
    // validatePassword()
    // validateConfirmPassword()
    validateOpt()
}
const validateEmail = ()=>{
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(formData.email)) {
        emailError.value = 'Please enter a valid email address';
        return false
    }
    emailError.value = '';
    return true;
}
const validateLoginEmail = ()=>{
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(loginFormData.email)) {
        loginEmailError.value = 'Please enter a valid email address';
        return false
    }
    loginEmailError.value = '';
    return true;
}
const validateLoginPassword = ()=> {
    if (loginFormData.password.length < 8) {
        loginPasswordError.value = 'Invalid Password';
        return false;
    }
    loginPasswordError.value = '';
    return true;
}
const validatePassword = ()=>{
    if (formData.password.length < 8) {
        passwordError.value = 'Password must be at least 8 characters long';
        return false;
    }
    else
    {
        const containsNumber = /\d/.test(formData.password);
        const containsLowerCase = /[a-z]/.test(formData.password);
        const containsUpperCase = /[A-Z]/.test(formData.password);

        if (!containsNumber || !containsLowerCase || !containsUpperCase) {
            passwordError.value = 'Password must contain at least one number, one lowercase letter, and one uppercase letter';
            return false;
        } else {
            passwordError.value = '';
            return true;
        }
    }

}
const validateConfirmPassword = ()=>{
    if (!validatePassword() || formData.password_confirmation !== formData.password) {
        confirmPasswordError.value = 'Passwords do not match';
        return false;
    }
        confirmPasswordError.value = '';
    return true;
}
const validateOpt = ()=>{
    if (formData.otp.length !== 6) {
        otpError.value = 'Invalid OTP';
        return false;
    }
    otpError.value = '';
    return true;
}
const verifyOtp = ()=>{
    if(  validateEmail() &&validateOpt())
    {
    verifying.value=true;
    axios.post(route("register.optVerify"), {email:formData.email ,otp:formData.otp})
        .then(response => {
            verifying.value=false;
            if(response.data == 'otp-verified')
            {
                showModal.value = true
                return true;
            }
            otpDisable.value=false;
            otpError.value = 'Invalid OTP';
        })
        .catch(error => {
        })

    }
}
const signupUser = () => {
    if(validatePassword() && validateConfirmPassword())
    {
        clearServerValidationError();
        formData.post(route("registered.store"), {
            preserveScroll: true,
            onSuccess: () => {

            },
            onError: (errors) => {
                nameError.value = formData.errors.signUp.name
                confirmPasswordError.value = formData.errors.signUp.password
            },
        });
    }
}

const loginUser = () => {
    if(validateLoginEmail() && validateLoginPassword())
    {
        loginEmailError.value = ''
        loginFormData.post(route("client.login"), {
            preserveScroll: true,
            onSuccess: () => {

            },
            onError: (errors) => {
                loginEmailError.value = errors.login?.email
                // loadServerValidationError();
            },
        });
    }
}
const sendOtp = ()=>{
    otpDisable.value=true;
    otpError.value='';
    otpStatus.value='Sending..';
    axios.post(route("register.optSend"), {email:formData.email })
        .then(response => {
            if(response.data == 'otp-sent')
            {
                updateOTPTimer()
                return true;
            }
            emailError.value ='Email already registered';
            otpDisable.value=false;
            otpStatus.value = '';
        })
        .catch(error => {
        })
}
let timeRemaining = 180;
function updateOTPTimer() {
  if (timeRemaining > 0) {
    // Calculate minutes and seconds
    const minutes = Math.floor(timeRemaining / 60);
    const seconds = timeRemaining % 60;

    // Display the remaining time in the "X min Y sec" format
    otpStatus.value = `Resend OTP in `;
    if(minutes >0){
    otpStatus.value += `${minutes} min `;
    }
    otpStatus.value += `${seconds} sec`;

    // Subtract one second
    timeRemaining--;

    // Call this function again after 1 second
    setTimeout(updateOTPTimer, 1000);
  } else {
    // Countdown has reached zero
    otpDisable.value=false;
    otpStatus.value = '';
  }
}
</script>

<style lang="scss" scoped>
.tptrack__submition[disabled]
{
    background-color: #d17380;
}

element.style {
}
.tptrack__email button[disabled]
{
    background-color: #b3bb80;
    cursor:not-allowed;
}
tptrack__id.white-bg input, .tptrack__email.white-bg input {

    background-color: var(--tp-grey-1);

}
.lds-ellipsis {
    display: inline-block;
    position: relative;
    height: 12px;
}
.lds-ellipsis div {
    position: absolute;
    top: 0px;
    width: 13px;
    height: 13px;
    border-radius: 50%;
    background: #fff;
    animation-timing-function: cubic-bezier(0, 1, 1, 0);
}
.lds-ellipsis div:nth-child(1) {
    left: 8px;
    animation: lds-ellipsis1 0.6s infinite;
}
.lds-ellipsis div:nth-child(2) {
    left: 8px;
    animation: lds-ellipsis2 0.6s infinite;
}
.lds-ellipsis div:nth-child(3) {
    left: 32px;
    animation: lds-ellipsis2 0.6s infinite;
}
.lds-ellipsis div:nth-child(4) {
    left: 56px;
    animation: lds-ellipsis3 0.6s infinite;
}
@keyframes lds-ellipsis1 {
    0% {
        transform: scale(0);
    }
    100% {
        transform: scale(1);
    }
}
@keyframes lds-ellipsis3 {
    0% {
        transform: scale(1);
    }
    100% {
        transform: scale(0);
    }
}
@keyframes lds-ellipsis2 {
    0% {
        transform: translate(0, 0);
    }
    100% {
        transform: translate(24px, 0);
    }
}

</style>

