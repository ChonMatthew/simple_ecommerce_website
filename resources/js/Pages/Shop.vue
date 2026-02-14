<script setup>
import { ref, watch, computed } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import Layout from "../Layouts/Layout.vue";
import ProductCard from "../Components/ProductCard.vue";

const props = defineProps({
    products: {
        type: Object,
        default: () => ({ data: [], links: [] }),
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
});

const productList = computed(() => props.products?.data ?? props.products ?? []);
const paginationLinks = computed(() => props.products?.links ?? []);

const searchQuery = ref(props.filters?.q ?? "");

const search = () => {
    router.get("/products", { q: searchQuery.value || undefined }, {
        preserveState: true,
    });
};

const clearSearch = () => {
    searchQuery.value = "";
    router.get("/products");
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
        <Head title="Shop" />
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
                    <div class="flex flex-wrap items-center gap-2">
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
                        <Link
                            v-if="filters?.q"
                            href="/products"
                            class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition"
                        >
                            Clear
                        </Link>
                    </div>
                </div>

                <div
                    v-if="!productList.length"
                    class="rounded-lg border border-dashed border-slate-300 bg-white/60 p-12 text-center text-sm text-slate-600"
                >
                    {{
                        filters?.q
                            ? `No products found for "${filters.q}".`
                            : "No products available yet."
                    }}
                </div>

                <div v-else class="space-y-8">
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        <ProductCard
                            v-for="product in productList"
                            :key="product.id"
                            :product="product"
                        />
                    </div>
                    <nav
                        v-if="paginationLinks.length > 3"
                        class="flex items-center justify-center gap-2"
                        aria-label="Pagination"
                    >
                        <template
                            v-for="(link, index) in paginationLinks"
                            :key="index"
                        >
                            <Link
                                v-if="link.url"
                                :href="link.url"
                                :class="[
                                    'rounded-lg px-4 py-2 text-sm font-medium transition',
                                    link.active
                                        ? 'bg-slate-900 text-white'
                                        : 'border border-slate-300 text-slate-700 hover:bg-slate-50',
                                ]"
                                preserve-state
                            >
                                <span v-html="link.label"></span>
                            </Link>
                            <span
                                v-else
                                :class="[
                                    'rounded-lg px-4 py-2 text-sm font-medium cursor-not-allowed opacity-50',
                                    link.active ? 'bg-slate-900 text-white' : 'border border-slate-300 text-slate-700',
                                ]"
                                v-html="link.label"
                            />
                        </template>
                    </nav>
                </div>
            </div>
        </section>
    </Layout>
</template>
