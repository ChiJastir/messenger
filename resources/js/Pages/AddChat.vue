<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import {router} from "@inertiajs/vue3";
import {ref} from "vue";

defineProps({
    users: Array,
    auth: Object
})

const search = ref('')

function searchUser(name) {
    if(name != null){
        router.get(route('addChat'), {
            name: name
        }, { preserveState: true })
    }
}

function goToNewChat(auth, user) {
    if (confirm('Do you want open chat with ' + user.name + '?')){
        router.get(route('chat'), {
            first: auth.user.id,
            second: user.id
        })
    }
}

</script>

<template>
    <AppLayout>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <TextInput v-on:input="searchUser(search)" v-model="search"/>
                <div v-for="user in users">
                    <div @click="goToNewChat(auth, user)" v-if="user.id !== auth.user.id" class="flex cursor-pointer mt-2 bg-white shadow-xl">
                        <img :src="user.profile_photo_url" :alt="user.name" width="50" height="50">
                        <h1>{{ user.name }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
