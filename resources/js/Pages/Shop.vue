<script setup>
import Layout from "../Layouts/Layout.vue";
import ProductCard from "../Components/ProductCard.vue";

defineProps({
    products: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <Layout>
        <!--Hero section-->
        <section
            class="w-full bg-cover bg-center bg-no-repeat py-16 md:py-24 relative"
        >
            <div class="absolute inset-0 bg-slate-900/40"></div>
            <div class="mx-auto max-w-7xl px-6 relative z-10">
                <div class="space-y-8">
                    <h1
                        class="text-5xl md:text-7xl font-bold text-white tracking-tight"
                    >
                        Shop Products
                    </h1>
                </div>
            </div>
        </section>

        <!--Products Grid-->
        <section class="mx-auto max-w-7xl px-6 py-16">
            <div class="space-y-8">
                <h2 class="text-3xl font-bold text-slate-900">All Products</h2>

                <div
                    v-if="!products.length"
                    class="rounded-lg border border-dashed border-slate-300 bg-white/60 p-12 text-center text-sm text-slate-600"
                >
                    No products available yet.
                </div>

                <div v-else class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <ProductCard
                        v-for="product in products"
                        :key="product.id"
                        :product="product"
                    />
                </div>
            </div>
        </section>
    </Layout>
</template>
