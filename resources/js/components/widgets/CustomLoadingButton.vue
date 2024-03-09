<template>
    <button>
        <span v-if="loading" class="spinner-border spinner-border-sm" role="status"
            aria-hidden="true"></span>
        <span><slot /></span>
    </button>
</template>

<script setup>
defineProps({
    loading: Boolean
})
</script>
