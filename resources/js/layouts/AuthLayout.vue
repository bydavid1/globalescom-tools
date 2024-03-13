<template>
    <div>
        <div class="wrapper d-flex flex-column min-vh-100 bg-light">
            <AppHeader />
            <div class="body flex-grow-1 px-3">
                <CContainer lg>
                    <router-view />
                </CContainer>
            </div>
            <AppFooter />
        </div>
    </div>
</template>

<script setup>
import { onMounted } from "vue";
import { fetchToken, onMessageListener } from "../services/firebase";
import { CContainer } from '@coreui/vue'
import AppFooter from '../components/layout/AppFooter.vue'
import AppHeader from '../components/layout/AppHeader.vue'
import { useRouter } from "vue-router";
import { useAlerts } from '../store/alert';
import { me } from "../services/api/auth-service";

const router = useRouter()
const alert = useAlerts()

onMounted(async () => {
    const user = localStorage.getItem("user")
    if (!user) {
        router.push({ name: "login" })
    } else {
        await getMyInfo();
        await fetchToken()
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
