<template>
    <CBreadcrumb class="d-md-down-none me-auto mb-0">
        <CBreadcrumbItem style="cursor: pointer;">
            <CIcon icon="cil-home" @click="router.push('/')"/>
        </CBreadcrumbItem>
        <CBreadcrumbItem v-for="item in breadcrumbs" :key="item" :href="item.active ? '' : item.path"
            :active="item.active">
            {{ item.name }}
        </CBreadcrumbItem>
    </CBreadcrumb>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const breadcrumbs = ref()

const getBreadcrumbs = () => {
    return router.currentRoute.value.matched.filter(route => route.path != '/').map((route) => {
        return {
            active: route.path === router.currentRoute.value.fullPath,
            name: route.name,
            path: `${router.options.history.base}${route.path}`,
        }
    })
}

router.afterEach(() => {
    breadcrumbs.value = getBreadcrumbs()
})

onMounted(() => {
    breadcrumbs.value = getBreadcrumbs()
})

</script>
