<template>
    <RouterView />
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
</template>

<script setup>
import { computed } from "vue";
import { RouterView } from "vue-router";
import { useAlerts } from './store/alert';

const store = useAlerts()

const toasts = computed(() => store.getAlerts)
</script>

