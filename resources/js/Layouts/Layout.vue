<script setup>
import { computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

const page = usePage();
const user = computed(() => page.props.auth?.user || null);
const cartCount = computed(() => page.props.cartCount ?? 0);
</script>

<template>
    <div class="min-h-screen bg-white">
        <!--Header layout for all related Pages-->
        <header class="bg-slate-900 border-b border-slate-800">
            <nav
                class="mx-auto flex w-full max-w-7xl items-center justify-between px-6 py-4"
            >
                <div class="flex items-center gap-8">
                    <div class="text-xl font-bold text-white">
                        <Link href="/">Simple Store</Link>
                    </div>
                    <div
                        class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-300"
                    >
                        <Link
                            href="/products"
                            class="hover:text-white transition"
                        >
                            Shop
                        </Link>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <!--Cart icon in Nav Bar-->
                    <Link
                        href="/cart"
                        class="relative rounded p-2 text-slate-300 hover:text-white hover:bg-slate-800 transition"
                        aria-label="Cart"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="h-5 w-5"
                        >
                            <path d="M3 3h2l3 12h9l3-9H8" />
                            <circle cx="10" cy="19" r="1.5" />
                            <circle cx="17" cy="19" r="1.5" />
                        </svg>
                        <span
                            v-if="cartCount > 0"
                            class="absolute -top-1 -right-1 flex h-5 min-w-5 items-center justify-center rounded-full bg-emerald-500 px-1.5 text-xs font-bold text-white"
                        >
                            {{ cartCount > 99 ? "99+" : cartCount }}
                        </span>
                    </Link>

                    <!--User sign in section-->
                    <div v-if="user" class="flex items-center gap-3">
                        <Link
                            href="/account"
                            class="text-sm text-slate-300 hover:text-white transition"
                        >
                            {{ user.name }}
                        </Link>
                    </div>
                    <div v-else class="flex items-center gap-2">
                        <Link
                            href="/login"
                            class="text-sm text-slate-300 hover:text-white transition"
                        >
                            Log in
                        </Link>
                        <Link
                            href="/register"
                            class="rounded bg-white px-4 py-2 text-sm font-semibold text-slate-900 hover:bg-slate-100 transition"
                        >
                            Sign up
                        </Link>
                    </div>
                </div>
            </nav>
        </header>

        <!--Main content-->
        <main>
            <slot />
        </main>
    </div>
</template>
