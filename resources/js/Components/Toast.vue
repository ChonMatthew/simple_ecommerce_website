<script setup>
import { watch, ref } from "vue";

const props = defineProps({
    message: {
        type: String,
        default: "",
    },
    show: {
        type: Boolean,
        default: false,
    },
    duration: {
        type: Number,
        default: 3000,
    },
});

const emit = defineEmits(["close"]);

const visible = ref(props.show);

watch(
    () => props.show,
    (isShow) => {
        visible.value = isShow;
        if (isShow && props.duration > 0) {
            const timer = setTimeout(() => {
                visible.value = false;
                emit("close");
                clearTimeout(timer);
            }, props.duration);
        }
    },
    { immediate: true },
);
</script>

<template>
    <Transition
        enter-active-class="transition ease-out duration-200"
        enter-from-class="opacity-0 translate-y-2"
        enter-to-class="opacity-100 translate-y-0"
        leave-active-class="transition ease-in duration-150"
        leave-from-class="opacity-100 translate-y-0"
        leave-to-class="opacity-0 translate-y-2"
    >
        <div
            v-if="visible && message"
            class="fixed bottom-6 right-6 z-[100] rounded-lg bg-slate-900 px-4 py-3 text-sm font-medium text-white shadow-lg"
            role="alert"
        >
            {{ message }}
        </div>
    </Transition>
</template>
