<script setup>
import { Head } from "@inertiajs/vue3";
import Layout from "../Layouts/Layout.vue";
import OrderListItem from "../Components/OrderListItem.vue";
import OrderDetailsModal from "../Components/OrderDetailsModal.vue";
import { router } from "@inertiajs/vue3";
import { ref } from "vue";

const { user, orders } = defineProps({
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
        <Head title="My Account" />
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
                                        {{ user.name }}
                                    </p>
                                </div>

                                <div>
                                    <p
                                        class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400 mb-2"
                                    >
                                        Email
                                    </p>
                                    <p class="text-lg font-semibold text-slate-900">
                                        {{ user.email }}
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
                        v-if="!orders.length"
                        class="rounded-lg border border-dashed border-slate-300 bg-white/60 p-12 text-center text-sm text-slate-600"
                    >
                        You haven't placed any orders yet.
                    </div>

                    <ul v-else class="space-y-3">
                        <OrderListItem
                            v-for="order in orders"
                            :key="order.id"
                            :order="order"
                            @click="openOrderModal"
                        />
                    </ul>
                </div>
            </div>
        </section>

        <OrderDetailsModal
            :show="showOrderModal"
            :order="selectedOrder"
            @close="closeOrderModal"
            @pay="payOrder"
            @cancel="cancelOrder"
        />
    </Layout>
</template>