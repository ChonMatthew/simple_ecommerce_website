<script setup>
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
import Layout from "../Layouts/Layout.vue";
import ProductCard from "../Components/ProductCard.vue";

const props = defineProps({
    products: {
        type: Array,
        default: () => [],
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
});

const searchQuery = ref(props.filters?.q ?? "");

const search = () => {
    router.get("/products", { q: searchQuery.value || undefined }, {
        preserveState: true,
    });
};

watch(
    () => props.filters?.q,
    (newVal) => {
        searchQuery.value = newVal ?? "";
    },
);
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
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="text-3xl font-bold text-slate-900">
                        {{ filters?.q ? `Results for "${filters.q}"` : "All Products" }}
                    </h2>
                    <form
                        class="flex gap-2"
                        @submit.prevent="search"
                    >
                        <input
                            v-model="searchQuery"
                            type="search"
                            placeholder="Search products..."
                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500 sm:w-64"
                        />
                        <button
                            type="submit"
                            class="rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800 transition"
                        >
                            Search
                        </button>
                    </form>
                </div>

                <div
                    v-if="!products.length"
                    class="rounded-lg border border-dashed border-slate-300 bg-white/60 p-12 text-center text-sm text-slate-600"
                >
                    {{
                        filters?.q
                            ? `No products found for "${filters.q}".`
                            : "No products available yet."
                    }}
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
