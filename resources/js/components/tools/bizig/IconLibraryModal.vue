<template>
    <CModal>
        <CModalHeader>
            <CModalTitle>Iconos</CModalTitle>
        </CModalHeader>
        <CModalBody>
            <CRow class="text-center">
                <template v-for="(icon, iconName) in icons" :key="iconName">
                    <CCol class="mb-5" :xs="3">
                        <CButton @click="chooseIcon(iconName)">
                            <CIcon :content="icon" size="sm" />
                        </CButton>
                    </CCol>
                </template>
            </CRow>
        </CModalBody>
    </CModal>
</template>

<script setup>
import { iconsSet } from '../../../../icons';
import { CButton } from '@coreui/vue-pro';

const emit = defineEmits(['onChoose'])

const icon = defineModel('icon', { required: true })

const icons = iconsSet

const toKebabCase = (str) => str.replace(/([a-z])([A-Z0-9])/g, '$1-$2').toLowerCase()

const chooseIcon = (iconName) => {
    console.log(toKebabCase(iconName))
    icon.value = toKebabCase(iconName)
    emit('onChoose')
}

</script>
