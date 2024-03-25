<template>
    <CModal>
        <CModalHeader>
            <CModalTitle>Iconos</CModalTitle>
        </CModalHeader>
        <CModalBody>
            <CRow class="text-center">
                <p class="text-start mb-3">Seleccione un icono: </p>
                <template v-for="(icon, iconName) in icons" :key="iconName">
                    <CCol class="mb-5" :xs="3" :lg="2">
                        <CButton @click="chooseIcon(iconName)">
                            <CIcon :content="icon" style="font-size: 18px;" />
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

const icons = iconsSet

const toKebabCase = (str) => str.replace(/([a-z])([A-Z0-9])/g, '$1-$2').toLowerCase()

const chooseIcon = (iconName) => {
    emit('onChoose', toKebabCase(iconName))
}

</script>
