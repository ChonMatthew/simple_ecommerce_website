<script setup>
import Layout from "../Layouts/Layout.vue";
import { computed, ref } from "vue";
import { router, usePage } from "@inertiajs/vue3";

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

const page = usePage();
const user = computed(() => page.props.auth?.user || null);
const showPaymentModal = ref(false);

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

const checkout = () => {
    showPaymentModal.value = true;
};

const processPayment = () => {
    showPaymentModal.value = false;
    router.post("/checkout", {
        status: "paid"
    });
};

const closeModal = () => {
    showPaymentModal.value = false;
    router.post("/checkout", {
        status: "pending"
    });
};
</script>

<template>
    <Layout>
        <!--Cart Section-->
        <section class="mx-auto max-w-7xl px-6 py-16">
            <div class="space-y-8">
                <!--Header-->
                <header class="space-y-2">
                    <h1 class="text-3xl font-bold text-slate-900">Your Cart</h1>
                    <p class="text-slate-600">
                        Review the items you plan to purchase.
                    </p>
                </header>

                <!--Empty Cart-->
                <div
                    v-if="!props.items.length"
                    class="rounded-lg border border-dashed border-slate-300 bg-white/60 p-12 text-center text-sm text-slate-600"
                >
                    Your cart is empty for now.
                </div>

                <!--Cart Items-->
                <div v-else class="space-y-4">
                    <div
                        v-for="item in props.items"
                        :key="item.id"
                        class="flex items-start gap-4 rounded-lg border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition"
                    >
                        <!--Product Image-->
                        <div
                            class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-lg bg-slate-100 flex items-center justify-center"
                        >
                            <img
                                v-if="item.product.image"
                                :src="item.product.image"
                                :alt="item.product.name"
                                class="h-full w-full object-cover"
                            />
                            <div
                                v-else
                                class="flex h-full w-full items-center justify-center text-xs font-medium text-slate-400 px-2"
                            >
                                No image
                            </div>
                        </div>

                        <!--Product Details-->
                        <div class="flex-1 space-y-2">
                            <div>
                                <h3
                                    class="text-lg font-semibold text-slate-900"
                                >
                                    {{ item.product.name }}
                                </h3>
                                <p class="text-sm text-slate-500">
                                    ${{ Number(item.product.price).toFixed(2) }}
                                    each
                                </p>
                            </div>

                            <!--Quantity Controls-->
                            <div class="flex items-center gap-3">
                                <label
                                    class="text-sm font-medium text-slate-700"
                                >
                                    Quantity:
                                </label>
                                <input
                                    type="number"
                                    min="1"
                                    :value="item.quantity"
                                    class="h-10 w-20 rounded-lg border border-slate-300 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent"
                                    @change="
                                        updateQuantity(
                                            item,
                                            $event.target.value,
                                        )
                                    "
                                />
                                <button
                                    type="button"
                                    class="ml-2 text-sm font-medium text-red-600 hover:text-red-700 transition"
                                    @click="removeItem(item)"
                                >
                                    Remove
                                </button>
                            </div>
                        </div>

                        <!--Line Total-->
                        <div class="text-right">
                            <p class="text-lg font-bold text-slate-900">
                                ${{
                                    (
                                        Number(item.product.price) *
                                        item.quantity
                                    ).toFixed(2)
                                }}
                            </p>
                        </div>
                    </div>

                    <!--Cart Summary-->
                    <div
                        class="flex items-center justify-between rounded-lg border-t-2 border-slate-200 bg-slate-50 px-6 py-4"
                    >
                        <span class="text-lg font-semibold text-slate-900">
                            Total
                        </span>
                        <span class="text-2xl font-bold text-emerald-600">
                            ${{ Number(props.total).toFixed(2) }}
                        </span>
                    </div>

                    <!--Checkout Button-->
                    <div
                        v-if="props.items.length && user"
                        class="flex justify-end pt-4"
                    >
                        <button
                            type="button"
                            class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition"
                            @click="checkout"
                        >
                            Place Order
                        </button>
                    </div>
                    <div
                        v-else-if="props.items.length && !user"
                        class="rounded-lg border border-slate-200 bg-slate-50 px-6 py-4 text-center"
                    >
                        <p class="text-sm text-slate-600">
                            Please
                            <Link
                                href="/login"
                                class="font-semibold text-slate-900 hover:text-slate-700 underline"
                            >
                                log in
                            </Link>
                            to place your order.
                        </p>
                    </div>
                </div>
            </div>

            <!--Payment Modal-->
            <div
                v-if="showPaymentModal"
                class="fixed inset-0 z-50 flex items-center justify-center"
                @click.self="closeModal"
            >
                <div class="absolute inset-0 bg-black/50"></div>

                <!--Content-->
                <div
                    class="relative z-10 w-full max-w-md rounded-lg bg-white p-8 shadow-xl"
                >
                    <h2 class="mb-6 text-2xl font-bold text-slate-900">
                        Pay now
                    </h2>

                    <div class="mb-8 space-y-4">
                        <div
                            class="flex items-center justify-between rounded-lg bg-slate-50 px-4 py-3"
                        >
                            <span class="text-lg font-semibold text-slate-700">
                                Total Price:
                            </span>
                            <span class="text-2xl font-bold text-emerald-600">
                                ${{ Number(props.total).toFixed(2) }}
                            </span>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <button
                            type="button"
                            class="flex-1 rounded-lg border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition"
                            @click="closeModal"
                        >
                            Cancel
                        </button>
                        <button
                            type="button"
                            class="flex-1 rounded-lg bg-emerald-600 px-6 py-3 text-sm font-semibold text-white hover:bg-emerald-700 transition"
                            @click="processPayment"
                        >
                            Pay now
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </Layout>
</template>
