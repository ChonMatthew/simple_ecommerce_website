<script setup>
import Layout from "../../Layouts/Layout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post("/register", {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <Layout>
        <Head title="Create account" />

        <section class="mx-auto max-w-md space-y-6">
            <header class="space-y-1 text-center">
                <h1 class="text-2xl font-semibold tracking-tight text-slate-900">
                    Create your account
                </h1>
                <p class="text-sm text-slate-600">
                    Save your details for a smoother shopping experience.
                </p>
            </header>

            <form class="space-y-4 rounded-lg border border-slate-200 bg-white p-6 shadow-sm" @submit.prevent="submit">
                <div class="space-y-1">
                    <label for="name" class="block text-sm font-medium text-slate-700">
                        Name
                    </label>
                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="block w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500"
                        autocomplete="name"
                        required
                    />
                    <p v-if="form.errors.name" class="text-xs text-red-600">
                        {{ form.errors.name }}
                    </p>
                </div>

                <div class="space-y-1">
                    <label for="email" class="block text-sm font-medium text-slate-700">
                        Email
                    </label>
                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="block w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500"
                        autocomplete="email"
                        required
                    />
                    <p v-if="form.errors.email" class="text-xs text-red-600">
                        {{ form.errors.email }}
                    </p>
                </div>

                <div class="space-y-1">
                    <label for="password" class="block text-sm font-medium text-slate-700">
                        Password
                    </label>
                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        class="block w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500"
                        autocomplete="new-password"
                        required
                    />
                    <p v-if="form.errors.password" class="text-xs text-red-600">
                        {{ form.errors.password }}
                    </p>
                </div>

                <div class="space-y-1">
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700">
                        Confirm password
                    </label>
                    <input
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        class="block w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500"
                        autocomplete="new-password"
                        required
                    />
                </div>

                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800 disabled:opacity-60"
                    :disabled="form.processing"
                >
                    {{ form.processing ? "Creating account..." : "Create account" }}
                </button>

                <p class="mt-2 text-center text-xs text-slate-500">
                    Already have an account?
                    <Link href="/login" class="font-medium text-slate-900 hover:underline">
                        Sign in
                    </Link>
                </p>
            </form>
        </section>
    </Layout>
</template>

