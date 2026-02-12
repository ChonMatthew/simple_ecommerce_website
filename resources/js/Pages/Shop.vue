<script setup>
import Layout from "../Layouts/Layout.vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    products: {
        type: Array,
        default: () => [],
    },
});

const addToCart = (productId) => {
    router.post(
        "/cart",
        {
            product_id: productId,
            quantity: 1,
        },
        {
            preserveScroll: true,
        },
    );
};
</script>

<template>
    <Layout>
        <section class="space-y-4">
            <header class="space-y-1">
                <h1
                    class="text-2xl font-semibold tracking-tight text-slate-900"
                >
                    Shop products
                </h1>
                <p class="text-slate-600">Browse all available products.</p>
            </header>

            <div
                v-if="!props.products.length"
                class="mt-4 rounded-lg border border-dashed border-slate-300 bg-white/60 p-6 text-center text-sm text-slate-500"
            >
                No products available yet.
            </div>

            <div v-else class="mt-4 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <article
                    v-for="product in props.products"
                    :key="product.id"
                    class="flex flex-col justify-between rounded-lg border border-slate-200 bg-white p-4 shadow-sm"
                >
                    <div
                        class="aspect-square w-full overflow-hidden rounded-md bg-slate-100 mb-3 flex items-center justify-center"
                    >
                        <img
                            v-if="product.image"
                            :src="product.image"
                            :alt="product.name"
                            class="h-full w-full object-cover"
                        />
                        <div
                            v-else
                            class="flex h-full w-full items-center justify-center text-xs font-medium text-slate-400"
                        >
                            No image
                        </div>
                    </div>
                    <div class="space-y-1">
                        <h2 class="text-sm font-semibold text-slate-900">
                            {{ product.name }}
                        </h2>
                        <p
                            class="text-sm font-mono font-semibold text-emerald-600"
                        >
                            ${{ Number(product.price).toFixed(2) }}
                        </p>
                    </div>
                    <button
                        type="button"
                        class="mt-3 inline-flex items-center justify-center rounded bg-slate-900 px-3 py-1.5 text-sm font-medium text-white hover:bg-slate-800"
                        @click="addToCart(product.id)"
                    >
                        Add to cart
                    </button>
                </article>
            </div>
        </section>
    </Layout>
</template>
