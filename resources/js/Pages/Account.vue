<script setup>
import Layout from "../Layouts/Layout.vue";
import { router } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    orders: {
        type: Array,
        default: () => [],
    },
});

const logout = () => {
    router.post("/logout");
};

const selectedOrder = ref(null);
const showOrderModal = ref(false);

const openOrderModal = (order) => {
    selectedOrder.value = order;
    showOrderModal.value = true;
};

const closeOrderModal = () => {
    showOrderModal.value = false;
    selectedOrder.value = null;
};

const payOrder = () => {
    if (!selectedOrder.value) return;

    router.patch(`/orders/${selectedOrder.value.id}`, {
        status: "paid",
    }, {
        onSuccess: () => {
            closeOrderModal();
        },
    });
};

const cancelOrder = () => {
    if (!selectedOrder.value) return;

    if (!confirm("Are you sure you want to cancel this order? This action cannot be undone.")) {
        return;
    }

    router.delete(`/orders/${selectedOrder.value.id}`, {
        onSuccess: () => {
            closeOrderModal();
        },
    });
};
</script>

<template>
    <Layout>
        <!-- Account Section - matching Home/Shop/Cart page styling -->
        <section class="mx-auto max-w-7xl px-6 py-16">
            <div class="space-y-8">
                <!-- Header -->
                <header class="space-y-2">
                    <h1 class="text-3xl font-bold text-slate-900">
                        My Account
                    </h1>
                    <p class="text-slate-600">
                        View your profile details and manage your orders.
                    </p>
                </header>

                <!-- Account Details Card with Logout Button -->
                <div class="space-y-6">
                    <div
                        class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm"
                    >
                        <div class="flex items-start justify-between">
                            <div class="flex-1 space-y-6">
                                <div>
                                    <p
                                        class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400 mb-2"
                                    >
                                        Name
                                    </p>
                                    <p class="text-lg font-semibold text-slate-900">
                                        {{ props.user.name }}
                                    </p>
                                </div>

                                <div>
                                    <p
                                        class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400 mb-2"
                                    >
                                        Email
                                    </p>
                                    <p class="text-lg font-semibold text-slate-900">
                                        {{ props.user.email }}
                                    </p>
                                </div>
                            </div>

                            <!-- Logout Button - positioned near account details -->
                            <div class="ml-6">
                                <button
                                    type="button"
                                    class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800 transition"
                                    @click="logout"
                                >
                                    Log out
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders Section -->
                <div class="space-y-4">
                    <h2 class="text-2xl font-bold text-slate-900">
                        Your Orders
                    </h2>

                    <div
                        v-if="!props.orders.length"
                        class="rounded-lg border border-dashed border-slate-300 bg-white/60 p-12 text-center text-sm text-slate-600"
                    >
                        You haven't placed any orders yet.
                    </div>

                    <ul v-else class="space-y-3">
                        <li
                            v-for="order in props.orders"
                            :key="order.id"
                            class="group rounded-lg border border-slate-200 bg-white p-4 shadow-sm hover:shadow-md transition cursor-pointer"
                            @click="openOrderModal(order)"
                        >
                            <div class="flex items-center justify-between">
                                <div class="space-y-1">
                                    <p class="text-lg font-semibold text-slate-900">
                                        Order #{{ order.id }}
                                    </p>
                                    <p class="text-sm text-slate-500">
                                        Placed
                                        {{
                                            new Date(
                                                order.created_at,
                                            ).toLocaleDateString()
                                        }}
                                    </p>
                                </div>
                                <div class="text-right space-y-1">
                                    <p
                                        class="text-lg font-bold text-emerald-600"
                                    >
                                        ${{ Number(order.total_price).toFixed(2) }}
                                    </p>
                                    <p
                                        class="text-xs uppercase tracking-wide font-medium text-slate-500"
                                    >
                                        {{ order.status }}
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Order Details Modal -->
        <div
            v-if="showOrderModal && selectedOrder"
            class="fixed inset-0 z-50 flex items-center justify-center"
            @click.self="closeOrderModal"
        >
            <!--Backdrop-->
            <div class="absolute inset-0 bg-black/50"></div>

            <!--Modal Content-->
            <div class="relative z-10 w-full max-w-3xl max-h-[90vh] overflow-y-auto rounded-lg bg-white shadow-xl">
                <!--Modal Header-->
                <div class="sticky top-0 bg-white border-b border-slate-200 px-8 py-6 rounded-t-lg">
                    <div class="flex items-start justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900">
                                Order #{{ selectedOrder.id }}
                            </h2>
                            <p class="text-sm text-slate-500 mt-1">
                                Placed on {{ new Date(selectedOrder.created_at).toLocaleDateString() }}
                            </p>
                        </div>
                        <button
                            type="button"
                            class="text-slate-400 hover:text-slate-600 transition"
                            @click="closeOrderModal"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="h-6 w-6"
                            >
                                <path d="M18 6L6 18M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!--Modal Body-->
                <div class="px-8 py-6 space-y-6">
                    <!--Order Status-->
                    <div class="flex items-center justify-between rounded-lg bg-slate-50 px-4 py-3">
                        <span class="text-sm font-semibold text-slate-700">
                            Status:
                        </span>
                        <span class="text-sm uppercase tracking-wide font-medium text-slate-900">
                            {{ selectedOrder.status }}
                        </span>
                    </div>

                    <!--Order Items-->
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">
                            Order Items
                        </h3>
                        <div
                            v-if="!selectedOrder.order_items || !selectedOrder.order_items.length"
                            class="rounded-lg border border-dashed border-slate-300 bg-white/60 p-8 text-center text-sm text-slate-600"
                        >
                            No items found for this order.
                        </div>
                        <div v-else class="space-y-3">
                            <div
                                v-for="item in selectedOrder.order_items"
                                :key="item.id"
                                class="flex items-start gap-4 rounded-lg border border-slate-200 bg-white p-4 shadow-sm"
                            >
                                <!--Product Image-->
                                <div
                                    class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-lg bg-slate-100 flex items-center justify-center"
                                >
                                    <img
                                        v-if="item.product && item.product.image"
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
                                <div class="flex-1 space-y-1">
                                    <h4 class="text-base font-semibold text-slate-900">
                                        {{ item.product ? item.product.name : 'Deleted product' }}
                                    </h4>
                                    <p class="text-sm text-slate-500">
                                        ${{ Number(item.price).toFixed(2) }} each
                                    </p>
                                    <p class="text-sm text-slate-600">
                                        Quantity: {{ item.quantity }}
                                    </p>
                                </div>

                                <!--Line Total-->
                                <div class="text-right">
                                    <p class="text-lg font-bold text-slate-900">
                                        ${{ (Number(item.price) * item.quantity).toFixed(2) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Order Total-->
                    <div class="flex items-center justify-between rounded-lg border-t-2 border-slate-200 bg-slate-50 px-6 py-4">
                        <span class="text-lg font-semibold text-slate-900">
                            Total
                        </span>
                        <span class="text-2xl font-bold text-emerald-600">
                            ${{ Number(selectedOrder.total_price).toFixed(2) }}
                        </span>
                    </div>
                </div>

                <!--Modal Footer-->
                <div class="sticky bottom-0 bg-white border-t border-slate-200 px-8 py-4 rounded-b-lg">
                    <div v-if="selectedOrder.status === 'pending'" class="flex gap-4">
                        <button
                            type="button"
                            class="flex-1 rounded-lg border border-red-300 bg-white px-6 py-3 text-sm font-semibold text-red-700 hover:bg-red-50 transition"
                            @click="cancelOrder"
                        >
                            Cancel Order
                        </button>
                        <button
                            type="button"
                            class="flex-1 rounded-lg bg-emerald-600 px-6 py-3 text-sm font-semibold text-white hover:bg-emerald-700 transition"
                            @click="payOrder"
                        >
                            Pay now
                        </button>
                    </div>
                    <button
                        v-else
                        type="button"
                        class="w-full rounded-lg bg-slate-900 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition"
                        @click="closeOrderModal"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </Layout>
</template>