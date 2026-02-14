<script setup>
import { Link, router } from "@inertiajs/vue3";
import { useAuth } from "../Composables/useAuth.js";

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});

const { user } = useAuth();

const addToCart = () => {
    if (!user.value) {
        router.visit("/login");
        return;
    }

    router.post(
        "/cart",
        { product_id: props.product.id, quantity: 1 },
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
    <article
        class="group flex flex-col rounded-lg border border-slate-200 bg-white p-6 shadow-sm hover:shadow-lg transition"
    >
        <Link :href="`/products/${product.id}`" class="flex flex-col flex-1">
            <div
                class="aspect-square w-full overflow-hidden rounded-lg bg-slate-100 mb-4 flex items-center justify-center"
            >
                <img
                    v-if="product.image"
                    :src="product.image"
                    :alt="product.name"
                    class="h-full w-full object-cover group-hover:scale-105 transition-transform"
                />
                <div
                    v-else
                    class="flex h-full w-full items-center justify-center text-xs font-medium text-slate-400"
                >
                    No image
                </div>
            </div>
            <div class="space-y-2">
                <h3 class="text-lg font-semibold text-slate-900">
                    {{ product.name }}
                </h3>
                <p class="text-lg font-bold text-emerald-600">
                    ${{ Number(product.price).toFixed(2) }}
                </p>
            </div>
        </Link>
        <button
            v-if="user"
            type="button"
            class="mt-4 inline-flex items-center justify-center rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800 transition"
            @click="addToCart"
        >
            Add to cart
        </button>
        <Link
            v-else
            href="/login"
            class="mt-4 inline-flex items-center justify-center rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800 transition"
        >
            Log in to add to cart
        </Link>
    </article>
</template>
