<script setup>
import Layout from "../Layouts/Layout.vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    items: {
        type: Array,
        default: () => [],
    },
    total: {
        type: Number,
        default: 0,
    },
});

const updateQuantity = (item, quantity) => {
    const q = Number(quantity);
    if (Number.isNaN(q) || q < 1) return;

    router.patch(
        `/cart/${item.id}`,
        { quantity: q },
        {
            preserveScroll: true,
        },
    );
};

const removeItem = (item) => {
    router.delete(`/cart/${item.id}`, {
        preserveScroll: true,
    });
};
</script>

<template>
    <Layout>
        <section class="space-y-4">
            <header class="space-y-1">
                <h1
                    class="text-2xl font-semibold tracking-tight text-slate-900"
                >
                    Your cart
                </h1>
                <p class="text-slate-600">
                    Review the items you plan to purchase.
                </p>
            </header>

            <div
                v-if="!props.items.length"
                class="mt-4 rounded-lg border border-dashed border-slate-300 bg-white/60 p-6 text-center text-sm text-slate-500"
            >
                Your cart is empty for now.
            </div>

            <div v-else class="space-y-3">
                <div
                    v-for="item in props.items"
                    :key="item.id"
                    class="flex items-start justify-between rounded-lg border border-slate-200 bg-white p-4 shadow-sm"
                >
                    <div
                        class="h-16 w-16 flex-shrink-0 overflow-hidden rounded bg-slate-100 flex items-center justify-center"
                    >
                        <img
                            v-if="item.product.image"
                            :src="item.product.image"
                            :alt="item.product.name"
                            class="h-full w-full object-cover"
                        />
                        <div
                            v-else
                            class="text-[10px] font-medium text-slate-400 text-center px-1"
                        >
                            No image
                        </div>
                    </div>

                    <div class="flex-1 space-y-1">
                        <p class="text-sm font-semibold text-slate-900">
                            {{ item.product.name }}
                        </p>
                        <p class="text-xs text-slate-500">
                            Price: ${{ Number(item.product.price).toFixed(2) }}
                        </p>

                        <div class="mt-2 flex items-center gap-2">
                            <label class="text-xs text-slate-500"> Qty: </label>
                            <input
                                type="number"
                                min="1"
                                :value="item.quantity"
                                class="h-8 w-16 rounded border border-slate-300 px-2 text-sm"
                                @change="
                                    updateQuantity(item, $event.target.value)
                                "
                            />
                            <button
                                type="button"
                                class="ml-3 text-xs font-medium text-red-600 hover:text-red-700"
                                @click="removeItem(item)"
                            >
                                Remove
                            </button>
                        </div>
                    </div>

                    <p class="text-sm font-semibold text-slate-900">
                        ${{
                            (
                                Number(item.product.price) * item.quantity
                            ).toFixed(2)
                        }}
                    </p>
                </div>

                <div
                    class="flex items-center justify-between border-t border-slate-200 pt-4"
                >
                    <span class="text-sm font-medium text-slate-700">
                        Total
                    </span>
                    <span class="text-base font-semibold text-emerald-600">
                        ${{ Number(props.total).toFixed(2) }}
                    </span>
                </div>
            </div>
        </section>
    </Layout>
</template>
