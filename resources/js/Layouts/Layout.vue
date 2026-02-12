<script setup>
import { computed } from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";

const page = usePage();
const user = computed(() => page.props.auth?.user || null);

const logout = () => {
    router.post("/logout");
};
</script>

<template>
    <div class="min-h-screen bg-slate-50 text-slate-900">
        <header class="border-b border-slate-200 bg-white">
            <nav
                class="mx-auto flex max-w-5xl items-center justify-between px-4 py-3"
            >
                <div class="text-lg font-semibold tracking-tight">
                    <Link href="/">Simple Store</Link>
                </div>

                <div class="flex items-center gap-6 text-sm font-medium">
                    <div class="flex gap-4">
                        <Link
                            href="/products"
                            class="rounded px-3 py-1.5 text-slate-700 hover:bg-slate-100 hover:text-slate-900"
                        >
                            Shop
                        </Link>
                        <Link
                            href="/cart"
                            class="rounded px-3 py-1.5 text-slate-700 hover:bg-slate-100 hover:text-slate-900"
                        >
                            Cart
                        </Link>
                    </div>

                    <div v-if="user" class="flex items-center gap-3">
                        <span class="text-xs font-medium text-slate-500">
                            Hi, {{ user.name }}
                        </span>
                        <button
                            type="button"
                            class="rounded bg-slate-900 px-3 py-1.5 text-xs font-semibold text-white hover:bg-slate-800"
                            @click="logout"
                        >
                            Log out
                        </button>
                    </div>

                    <div v-else class="flex items-center gap-2">
                        <Link
                            href="/login"
                            class="rounded px-3 py-1.5 text-slate-700 hover:bg-slate-100 hover:text-slate-900"
                        >
                            Log in
                        </Link>
                        <Link
                            href="/register"
                            class="rounded bg-slate-900 px-3 py-1.5 text-xs font-semibold text-white hover:bg-slate-800"
                        >
                            Sign up
                        </Link>
                    </div>
                </div>
            </nav>
        </header>

        <main class="mx-auto max-w-5xl px-4 py-8">
            <slot />
        </main>
    </div>
</template>
