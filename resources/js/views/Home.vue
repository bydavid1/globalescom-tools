<template>
    <div class="min-vh-100">
        <CContainer class="py-5">
            <h3>Bienvenido, {{ user?.user_name }}</h3>
            <div class="mt-5">
                <h5>Herramientas</h5>
                <div class="mt-3">
                    <ToolList />
                </div>
            </div>
        </CContainer>
    </div>
</template>

<script setup>
import useUser from '../composables/useUserComposable';
import ToolList from '../components/tool/ToolList.vue';

const { user } = useUser();
</script>
