<script setup>
import { Head } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <Head>
        <link rel="icon" href="/favicon.ico" />
    </Head>
    <div>
        <div class="bg-primary">
            <Link href="/">
                <ApplicationLogo class="h-20 w-20 fill-current" />
            </Link>
        </div>

        <div class="flex items-center justify-center bg-secondary min-h-screen">
            <slot />
        </div>
    </div>
</template>
