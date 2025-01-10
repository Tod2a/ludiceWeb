<script setup>
import { Head } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Footer from '../Components/Footer.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <Head>
        <link rel="icon" href="/favicon.ico" />
    </Head>
    <div class="bg-green-200 min-h-screen flex flex-col">
        <!-- Header -->
        <div class="bg-primary flex items-center">
            <Link href="/">
                <ApplicationLogo class="h-20 w-20 fill-current transform scale-75" />
            </Link>
            <div class="flex-grow">

            </div>
            <div>
                <nav>
                    <Link v-if="$page.props.auth.user" :href="route('dashboard')" >
                        <PrimaryButton>Dashboard</PrimaryButton>
                    </Link>

                    <div v-else class="flex justify-center items-center">
                        <Link :href="route('login')" >
                            <PrimaryButton>Log In</PrimaryButton>
                        </Link>>

                        <Link :href="route('register')" >
                            <PrimaryButton>Register</PrimaryButton>
                        </Link>
                    </div>
                </nav>
            </div>

        </div>

        <header v-if="$slots.header">
            <div class="bg-secondary flex justify-center items-center mx-auto max-w-7xl
                my-2 py-4 text-lg h-16 border border-black
                sm:my-1 sm:py-2 sm:text-base sm:h-12
                lg:my-3 lg:py-6 lg:text-xl lg:h-20 rounded">
                <slot name="header" />
            </div>
        </header>

        <div class="flex-grow flex flex-col">
            <main class="flex-grow flex items-center justify-center">
                <slot />
            </main>

            <footer class="bg-primary py-2 text-center">
                <div class="text-secondary">
                    <Footer />
                </div>
            </footer>
        </div>
    </div>
</template>
