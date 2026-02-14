<script setup>
import OrderItemRow from "./OrderItemRow.vue";

defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    order: {
        type: Object,
        default: null,
    },
});

defineEmits(["close", "pay", "cancel"]);
</script>

<template>
    <div
        v-if="show && order"
        class="fixed inset-0 z-50 flex items-center justify-center"
        @click.self="$emit('close')"
    >
        <div class="absolute inset-0 bg-black/50"></div>

        <div
            class="relative z-10 w-full max-w-3xl max-h-[90vh] overflow-y-auto rounded-lg bg-white shadow-xl"
        >
            <!-- Modal Header -->
            <div
                class="sticky top-0 bg-white border-b border-slate-200 px-8 py-6 rounded-t-lg"
            >
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">
                            Order #{{ order.id }}
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Placed on
                            {{ new Date(order.created_at).toLocaleDateString() }}
                        </p>
                    </div>
                    <button
                        type="button"
                        class="text-slate-400 hover:text-slate-600 transition"
                        @click="$emit('close')"
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

            <!-- Modal Body -->
            <div class="px-8 py-6 space-y-6">
                <div
                    class="flex items-center justify-between rounded-lg bg-slate-50 px-4 py-3"
                >
                    <span class="text-sm font-semibold text-slate-700">
                        Status:
                    </span>
                    <span
                        class="text-sm uppercase tracking-wide font-medium text-slate-900"
                    >
                        {{ order.status }}
                    </span>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">
                        Order Items
                    </h3>
                    <div
                        v-if="
                            !order.order_items || !order.order_items.length
                        "
                        class="rounded-lg border border-dashed border-slate-300 bg-white/60 p-8 text-center text-sm text-slate-600"
                    >
                        No items found for this order.
                    </div>
                    <div v-else class="space-y-3">
                        <OrderItemRow
                            v-for="item in order.order_items"
                            :key="item.id"
                            :item="item"
                            source="order"
                        />
                    </div>
                </div>

                <div
                    class="flex items-center justify-between rounded-lg border-t-2 border-slate-200 bg-slate-50 px-6 py-4"
                >
                    <span class="text-lg font-semibold text-slate-900">
                        Total
                    </span>
                    <span class="text-2xl font-bold text-emerald-600">
                        ${{ Number(order.total_price).toFixed(2) }}
                    </span>
                </div>
            </div>

            <!-- Modal Footer -->
            <div
                class="sticky bottom-0 bg-white border-t border-slate-200 px-8 py-4 rounded-b-lg"
            >
                <div
                    v-if="order.status === 'pending'"
                    class="flex gap-4"
                >
                    <button
                        type="button"
                        class="flex-1 rounded-lg border border-red-300 bg-white px-6 py-3 text-sm font-semibold text-red-700 hover:bg-red-50 transition"
                        @click="$emit('cancel')"
                    >
                        Cancel Order
                    </button>
                    <button
                        type="button"
                        class="flex-1 rounded-lg bg-emerald-600 px-6 py-3 text-sm font-semibold text-white hover:bg-emerald-700 transition"
                        @click="$emit('pay')"
                    >
                        Pay now
                    </button>
                </div>
                <button
                    v-else
                    type="button"
                    class="w-full rounded-lg bg-slate-900 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition"
                    @click="$emit('close')"
                >
                    Close
                </button>
            </div>
        </div>
    </div>
</template>
