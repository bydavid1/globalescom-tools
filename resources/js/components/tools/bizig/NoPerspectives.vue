<template>
    <h2>
        No tienes perspectivas creadas
    </h2>
    <p>
        Para crear una perspectiva, haz clic en el botón "Nueva perspectiva"
    </p>
    <p>
        <CButton @click="addPerspective" color="primary">
            Nueva perspectiva
        </CButton>
    </p>
</template>

<script setup>
const emit = defineEmits(['onAddClick']);

const addPerspective = () => {
    console.log('add perspective');
    emit('onAddClick');
}
</script>
