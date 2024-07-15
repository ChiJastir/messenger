<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {router} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import {ref} from "vue";

defineProps({
    auth: Object,
    interlocutor: Object,
    chat: Object,
    messages: Object
})

const messageInput = ref('')

function createChat(auth, interlocutor, message){
    router.post(route('createChat'), {
        first_user: auth,
        second_user: interlocutor,
        message: message
    })
}

function send(chat, auth, message){
    router.post(route('sendMessage'), {
        chat: chat[0],
        user: auth,
        message
    })
}

function sendMessage(auth, interlocutor, chat, messageInput){
    const message = messageInput.trim()

    if (message != ''){
        if (chat.length !== 0) {
            send(chat, auth, message)
        }
        else {
            createChat(auth, interlocutor, message)
        }
    }
}

</script>

<template>
    <AppLayout>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="flex">
                    <img class="rounded-full" width="100" height="100" :src="interlocutor.profile_photo_url" :alt="interlocutor.name">
                    <h1>{{ interlocutor.name }}</h1>
                </div>
                <PrimaryButton @click="createChat(auth.user, interlocutor)">Let`s to talk</PrimaryButton>

                <div class="mt-2" :class="auth.user.id === message.sender_id ? 'text-right bg-blue-400' : 'text-left bg-gray-400'" v-for="message in messages">
                    <p>{{ message.message }}</p>
                    <span>{{ (message.created_at).match(/\d{2}:\d{2}:\d{2}/)[0] }}</span>
                </div>

                <TextInput @keyup.enter="sendMessage(auth.user, interlocutor, chat, messageInput)" v-model="messageInput"/>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
