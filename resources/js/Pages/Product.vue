<script setup>
import Layout from "../Layouts/Layout.vue";
import { router, Link, usePage } from "@inertiajs/vue3";
import { ref, computed } from "vue";

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});

const page = usePage();
const user = computed(() => page.props.auth?.user || null);
const selectedQuantity = ref(1);

const addToCart = () => {
    if (!user.value) {
        router.visit("/login");
        return;
    }

    router.post(
        "/cart",
        {
            product_id: props.product.id,
            quantity: selectedQuantity.value,
        },
        {
            preserveScroll: true,
            onSuccess: () => {
                router.reload({ only: ["cartCount"] });
            },
        },
    );
};
</script>

<template>
    <Layout>
        <!--Product Detail-->
        <section class="mx-auto max-w-7xl px-6 py-16">
            <div class="grid gap-8 lg:grid-cols-2">
                <!--Product Image-->
                <div class="space-y-4">
                    <div
                        class="aspect-square w-full overflow-hidden rounded-lg bg-slate-100 flex items-center justify-center"
                    >
                        <img
                            v-if="props.product.image"
                            :src="props.product.image"
                            :alt="props.product.name"
                            class="h-full w-full object-cover"
                        />
                        <div
                            v-else
                            class="flex h-full w-full items-center justify-center text-sm font-medium text-slate-400"
                        >
                            No image available
                        </div>
                    </div>
                </div>

                <!--Product Details-->
                <div class="space-y-6">
                    <!--Title-->
                    <div>
                        <h1 class="text-4xl font-bold text-slate-900">
                            {{ props.product.name }}
                        </h1>
                    </div>

                    <!--Price-->
                    <div>
                        <p class="text-3xl font-bold text-emerald-600">
                            ${{ Number(props.product.price).toFixed(2) }}
                        </p>
                    </div>

                    <!--Quantity Selection-->
                    <div class="space-y-2">
                        <label
                            class="block text-sm font-semibold text-slate-900"
                        >
                            Quantity
                        </label>
                        <div class="flex items-center gap-4">
                            <input
                                v-model.number="selectedQuantity"
                                type="number"
                                min="1"
                                class="h-12 w-24 rounded-lg border border-slate-300 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent"
                            />
                        </div>
                    </div>

                    <!--Add to Cart-->
                    <button
                        v-if="user"
                        type="button"
                        class="w-full inline-flex items-center justify-center rounded-lg bg-slate-900 px-6 py-4 text-base font-semibold text-white hover:bg-slate-800 transition"
                        @click="addToCart"
                    >
                        Add to Cart
                    </button>
                    <Link
                        v-else
                        href="/login"
                        class="w-full inline-flex items-center justify-center rounded-lg bg-slate-900 px-6 py-4 text-base font-semibold text-white hover:bg-slate-800 transition"
                    >
                        Log in to add to cart
                    </Link>

                    <!-- Product Description -->
                    <div class="space-y-4 border-t border-slate-200 pt-6">
                        <h2 class="text-xl font-bold text-slate-900">
                            Product Description
                        </h2>
                        <div class="prose prose-slate max-w-none">
                            <p
                                v-if="props.product.description"
                                class="text-slate-600 leading-relaxed"
                            >
                                {{ props.product.description }}
                            </p>
                            <p v-else class="text-slate-500 italic">
                                No description available for this product.
                            </p>
                        </div>
                    </div>

                    <!-- Product ID -->
                    <div class="text-xs text-slate-500">
                        ID: {{ props.product.id }}
                    </div>
                </div>
            </div>
        </section>
    </Layout>
</template>
