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
        <CToaster placement="top-end">
            <CToast v-for="(toast, index) in toasts" :key="index" visible>
                <CToastHeader closeButton>
                    <span class="me-auto fw-bold">{{ toast.title }}</span>
                </CToastHeader>
                <CToastBody>
                    {{ toast.content }}
                </CToastBody>
            </CToast>
        </CToaster>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { fetchToken, onMessageListener } from "../services/firebase";
import { CContainer } from '@coreui/vue'
import AppFooter from '../components/layout/AppFooter.vue'
import AppHeader from '../components/layout/AppHeader.vue'
import AppSidebar from '../components/layout/AppSidebar.vue'

const toasts = ref([])

onMounted(async () => {
    console.log(await fetchToken())

    toasts.value.push({
        title: "Welcome",
        content: "You are now logged in"
    })

    await onMessageListener().then(payload => {
        console.log("payload", payload)
        toasts.value.push({
            title: payload.notification.title,
            content: payload.notification.body
        })
    })

})
</script>
