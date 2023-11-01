<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="admin-login min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div>
            <a :href="appRoute('homepage')">
                <ApplicationLogo class="w-[250px] fill-current text-gray-500" />
            </a>
        </div>

        <div
            class="w-full sm:max-w-md mt-8 p-8 bg-gray-100 dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
<style scoped>
.admin-login
{
  background-image: url(/admin-site/login-bg.jpg);
  background-repeat: no-repeat;
  background-size: cover;
}
</style>
