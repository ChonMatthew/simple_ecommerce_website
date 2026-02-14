<script setup>
import { computed } from "vue";

const props = defineProps({
    item: {
        type: Object,
        required: true,
    },
    source: {
        type: String,
        default: "order",
        validator: (v) => ["cart", "order"].includes(v),
    },
    showQuantityControls: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["updateQuantity", "remove"]);

const price = computed(() =>
    props.source === "order"
        ? props.item.price
        : props.item.product?.price ?? 0,
);

const name = computed(() =>
    props.source === "order"
        ? (props.item.product?.name ?? "Deleted product")
        : props.item.product?.name ?? "",
);

const image = computed(() =>
    props.source === "order"
        ? props.item.product?.image
        : props.item.product?.image,
);

const lineTotal = computed(
    () => (Number(price.value) * (props.item.quantity ?? 1)).toFixed(2),
);

const onQuantityChange = (event) => {
    const q = Number(event.target.value);
    if (!Number.isNaN(q) && q >= 1) {
        emit("updateQuantity", props.item, q);
    }
};

const onRemove = () => emit("remove", props.item);
</script>

<template>
    <div
        :class="[
            'flex items-start gap-4 rounded-lg border border-slate-200 bg-white shadow-sm',
            source === 'cart' ? 'p-6 hover:shadow-md transition' : 'p-4',
        ]"
    >
        <!-- Product Image -->
        <div
            :class="[
                'flex-shrink-0 overflow-hidden rounded-lg bg-slate-100 flex items-center justify-center',
                source === 'cart' ? 'h-24 w-24' : 'h-20 w-20',
            ]"
        >
            <img
                v-if="image"
                :src="image"
                :alt="name"
                class="h-full w-full object-cover"
            />
            <div
                v-else
                class="flex h-full w-full items-center justify-center text-xs font-medium text-slate-400 px-2"
            >
                No image
            </div>
        </div>

        <!-- Product Details -->
        <div class="flex-1 space-y-2">
            <div>
                <h3
                    :class="[
                        'font-semibold text-slate-900',
                        source === 'cart' ? 'text-lg' : 'text-base',
                    ]"
                >
                    {{ name }}
                </h3>
                <p class="text-sm text-slate-500">
                    ${{ Number(price).toFixed(2) }} each
                </p>
            </div>

            <div v-if="showQuantityControls" class="flex items-center gap-3">
                <label class="text-sm font-medium text-slate-700">
                    Quantity:
                </label>
                <input
                    type="number"
                    min="1"
                    :value="item.quantity"
                    class="h-10 w-20 rounded-lg border border-slate-300 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent"
                    @change="onQuantityChange"
                />
                <button
                    type="button"
                    class="ml-2 text-sm font-medium text-red-600 hover:text-red-700 transition"
                    @click="onRemove"
                >
                    Remove
                </button>
            </div>
            <p
                v-else-if="source === 'order'"
                class="text-sm text-slate-600"
            >
                Quantity: {{ item.quantity }}
            </p>
        </div>

        <!-- Line Total -->
        <div class="text-right">
            <p class="text-lg font-bold text-slate-900">
                ${{ lineTotal }}
            </p>
        </div>
    </div>
</template>
