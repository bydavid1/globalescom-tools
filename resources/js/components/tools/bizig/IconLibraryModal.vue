<template>
    <CModal>
        <CModalHeader>
            <CModalTitle>Iconos</CModalTitle>
        </CModalHeader>
        <CModalBody>
            <CRow class="text-center">
                <template v-for="(icon, iconName) in icons" :key="iconName">
                    <CCol class="mb-5" :xs="3" :sm="2" @click="chooseIcon">
                        <CIcon :content="icon" size="xxl" />
                    </CCol>
                </template>
            </CRow>
        </CModalBody>
    </CModal>
</template>

<script setup>
import { freeSet } from '@coreui/icons'

const emit = defineEmits(['update:show', 'update:modelValue'])

const icons = freeSet

const toKebabCase = (str) => str.replace(/([a-z])([A-Z0-9])/g, '$1-$2').toLowerCase()

const chooseIcon = (icon) => {
    const iconName = toKebabCase(icon)

    emit('update:modelValue', iconName)
    emit('update:show', false)
}

</script>
