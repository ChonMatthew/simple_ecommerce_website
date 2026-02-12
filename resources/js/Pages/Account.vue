<script setup>
import Layout from "../Layouts/Layout.vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    user: {
        type: Object,
        required: true,
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

