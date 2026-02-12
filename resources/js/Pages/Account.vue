<script setup>
import Layout from "../Layouts/Layout.vue";
import { router } from "@inertiajs/vue3";

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
</script>

<template>
    <Layout>
        <section class="space-y-6 max-w-md">
            <header class="space-y-1">
                <h1
                    class="text-2xl font-semibold tracking-tight text-slate-900"
                >
                    My account
                </h1>
                <p class="text-sm text-slate-600">
                    View your profile details and sign out.
                </p>
            </header>

            <div
                class="space-y-4 rounded-lg border border-slate-200 bg-white p-4 shadow-sm"
            >
                <div>
                    <p
                        class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400"
                    >
                        Name
                    </p>
                    <p class="text-sm font-medium text-slate-900">
                        {{ props.user.name }}
                    </p>
                </div>

                <div>
                    <p
                        class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400"
                    >
                        Email
                    </p>
                    <p class="text-sm font-medium text-slate-900">
                        {{ props.user.email }}
                    </p>
                </div>
            </div>

            <div class="space-y-3">
                <h2 class="text-sm font-semibold text-slate-900">
                    Your orders
                </h2>

                <p
                    v-if="!props.orders.length"
                    class="text-sm text-slate-500"
                >
                    You haven’t placed any orders yet.
                </p>

                <ul
                    v-else
                    class="space-y-2 text-sm"
                >
                    <li
                        v-for="order in props.orders"
                        :key="order.id"
                        class="flex items-center justify-between rounded border border-slate-200 bg-white px-3 py-2"
                    >
                        <div class="space-y-0.5">
                            <p class="font-medium text-slate-900">
                                Order #{{ order.id }}
                            </p>
                            <p class="text-xs text-slate-500">
                                Placed
                                {{
                                    new Date(order.created_at).toLocaleDateString()
                                }}
                            </p>
                        </div>
                        <div class="text-right space-y-0.5">
                            <p class="text-sm font-semibold text-emerald-600">
                                ${{ Number(order.total_price).toFixed(2) }}
                            </p>
                            <p class="text-xs uppercase tracking-wide text-slate-500">
                                {{ order.status }}
                            </p>
                        </div>
                    </li>
                </ul>
            </div>

            <button
                type="button"
                class="inline-flex items-center justify-center rounded bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800"
                @click="logout"
            >
                Log out
            </button>
        </section>
    </Layout>
</template>

