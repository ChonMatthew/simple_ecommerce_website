<script setup>
import { Link } from "@inertiajs/vue3";
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

                <div class="flex gap-4 text-sm font-medium">
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
            </nav>
        </header>

        <main class="mx-auto max-w-5xl px-4 py-8">
            <slot />
        </main>
    </div>
</template>
