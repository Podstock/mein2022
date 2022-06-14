<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Link, useForm } from '@inertiajs/inertia-vue3';
import JetButton from '@/Jetstream/Button.vue';
import JetFormSection from '@/Jetstream/FormSection.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';

const props = defineProps({
    user: Object,
});

</script>

<template>
    <JetFormSection @submitted="updateProfileInformation">
        <template #form>
            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="name" value="Name" />
                <JetInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" autocomplete="name" />
                <JetInputError :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Url -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="name" value="URL" />
                <JetInput id="name" v-model="form.url" type="text" class="mt-1 block w-full" autocomplete="url" />
                <JetInputError :message="form.errors.url" class="mt-2" />
            </div>

        </template>

        <template #actions>
            <JetActionMessage :on="form.recentlySuccessful" class="mr-3">
                Gesichert.
            </JetActionMessage>

            <JetButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Speichern
            </JetButton>
        </template>
    </JetFormSection>
</template>
