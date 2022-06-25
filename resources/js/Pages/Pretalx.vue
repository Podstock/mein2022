<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

import { onMounted } from 'vue';

onMounted(() => {
    let pretalx = document.createElement('script');
    pretalx.setAttribute('src', "https://fahrplan.podstock.de/podstock-2022/schedule/widget/v2.en.js");
    document.head.appendChild(pretalx);
});

</script>

<template>
    <AppLayout title="Fahrplan">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Fahrplan
            </h2>
        </template>

        <div class="py-4">
                <pretalx-schedule event-url="https://fahrplan.podstock.de/podstock-2022/" locale="de" style="--pretalx-clr-primary: #3aa57c"></pretalx-schedule>
        </div>
    </AppLayout>
</template>
