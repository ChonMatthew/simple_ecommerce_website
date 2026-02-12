<script setup>
import Layout from "../Layouts/Layout.vue";

const props = defineProps({
    featuredProducts: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <Layout>
        <section class="space-y-6">
            <header class="space-y-1">
                <p
                    class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400"
                >
                    Welcome
                </p>
                <h1
                    class="text-3xl font-semibold tracking-tight text-slate-900"
                >
                    Simple E-Commerce Store
                </h1>
                <p class="text-slate-600">Your one-stop shop</p>
            </header>

            <section class="space-y-3">
                <div class="flex items-center justify-between">
                    <h2
                        class="text-lg font-semibold tracking-tight text-slate-900"
                    >
                        Featured products
                    </h2>
                </div>

                <div
                    v-if="!props.featuredProducts.length"
                    class="rounded-lg border border-dashed border-slate-300 bg-white/60 p-6 text-sm text-slate-600"
                >
                    No featured products yet.
                </div>

                <div v-else class="grid gap-4 sm:grid-cols-2 md:grid-cols-4">
                    <article
                        v-for="product in props.featuredProducts"
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
                            <h3 class="text-sm font-semibold text-slate-900">
                                {{ product.name }}
                            </h3>
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
        </section>
    </Layout>
</template>
