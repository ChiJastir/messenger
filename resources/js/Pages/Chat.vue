<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {router} from "@inertiajs/vue3";
import {onMounted} from "vue";

const props = defineProps({
    auth: Object,
    chat: Object
})

function createChat(auth, chat){
    router.post(route('createChat'), {
        first_user_id: auth.id,
        second_user_id: chat.id,
    })
}

onMounted(() => {
    // console.log(props.auth.user.id)
    router.post(route('checkChat'), {
        first_user_id: props.auth.user.id,
        second_user_id: props.chat.id,
    })
});

</script>

<template>
    <AppLayout>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="flex">
                    <img class="rounded-full" width="100" height="100" :src="chat.profile_photo_url" :alt="chat.name">
                    <h1>{{ chat.name }}</h1>
                </div>
                <PrimaryButton @click="createChat(auth.user, chat)">Let`s to talk</PrimaryButton>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
