<script setup>
defineProps({
    order: {
        type: Object,
        required: true,
    },
});

defineEmits(["click"]);
</script>

<template>
    <li
        class="group rounded-lg border border-slate-200 bg-white p-4 shadow-sm hover:shadow-md transition cursor-pointer"
        @click="$emit('click', order)"
    >
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-lg font-semibold text-slate-900">
                    Order #{{ order.id }}
                </p>
                <p class="text-sm text-slate-500">
                    Placed {{ new Date(order.created_at).toLocaleDateString() }}
                </p>
            </div>
            <div class="text-right space-y-1">
                <p class="text-lg font-bold text-emerald-600">
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
</template>
