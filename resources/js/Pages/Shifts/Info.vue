<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import JetButton from '@/Jetstream/Button.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Link } from '@inertiajs/inertia-vue3'


let props = defineProps({
    roles: Object,
});

</script>


<template>
    <AppLayout title="Helfen - Info">
        <template #header>
            <div class="sm:flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Helfen
                </h2>
                <ul class="list-reset flex flex-wrap mt-2 text-right">
                    <li class="mr-3">
                        <Link href="/myshifts">Meine Schichten</Link>
                    </li>
                    <li class="mr-3">
                        <Link href="/shifts/day1">Offene Schichten</Link>
                    </li>
                    <li class="mr-3">
                        <Link href="/shiftroles" class="font-bold">Info</Link>
                    </li>
                </ul>
            </div>
        </template>
        <div class="max-w-7xl mx-auto pt-4 px-1 sm:px-4 lg:px-8">
            <div v-for="role in roles.data">
                <h3 class="pt-5 pb-1 font-bold">{{ role.name }}</h3>
                {{ role.description }}
            </div>
        </div>
    </AppLayout>
</template>
