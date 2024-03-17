<template>
    <div class="wrapper d-flex flex-column bg-light">
        <AppHeader />
        <router-view />
        <AppFooter />
    </div>
</template>

<script setup>
import { onMounted } from "vue";
import { fetchToken, onMessageListener } from "../services/firebase";
import AppFooter from '../components/layout/AppFooter.vue'
import AppHeader from '../components/layout/AppHeader.vue'
import { useRouter } from "vue-router";
import { useAlerts } from '../store/alert';
import { me } from "../services/api/auth-service";
import { updateDeviceId } from "../services/api/user-service";

const router = useRouter()
const alert = useAlerts()

onMounted(async () => {
    const user = localStorage.getItem("user")
    if (!user) {
        router.push({ name: "login" })
    } else {
        await getMyInfo();
        const deviceId = await fetchToken();
        await updateDeviceId(deviceId);
        await onMessageListener().then(payload => {
            console.log("payload", payload)
            alert.add({
                title: payload.notification.title,
                content: payload.notification.body
            })
        })
    }
})

const getMyInfo = async () => {
    try {
        return await me()
    } catch (error) {
        localStorage.removeItem("user");
        router.push({ name: "login" })
    }
}

</script>
