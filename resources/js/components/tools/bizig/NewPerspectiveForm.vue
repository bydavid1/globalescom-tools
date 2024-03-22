<template>
    <CForm @submit.prevent="savePerspective" class="row gy-3 align-items-center">
        <CCol xs="12">
            <CFormLabel for="name">Nombre</CFormLabel>
            <CFormInput v-model="formState.name" type="text" id="name" placeholder="Ingrese el nombre de la perspectiva" />
        </CCol>
        <CCol xs="12">
            <CFormLabel for="color">Color primario</CFormLabel><br>
            <input v-model="formState.accentColor" type="color" id="color" value="#e66465"/>
        </CCol>
        <CCol xs="12">
            <CFormLabel for="icon">Icono</CFormLabel><br>
            <CButton @click="iconLibraryModalVisible = true">
                <CIcon :icon="formState.icon" size="sm" />
            </CButton>
        </CCol>
        <CContainer class="mt-4">
            <CLoadingButton type="submit" color="primary" :loading="isLoading">
                Guardar
            </CLoadingButton>
        </CContainer>
    </CForm>
    <icon-library-modal
        v-model:icon="formState.icon"
        :visible="iconLibraryModalVisible"
        @close="() => { iconLibraryModalVisible = false }"
        @onChoose="() => { iconLibraryModalVisible = false }"
    />
</template>

<script setup>
import { reactive, ref, watch } from 'vue';
import { useAlerts } from '../../../store/alert';
import { createPerspective } from '../../../services/api/tools/bizig/perspectives-service';
import IconLibraryModal from './IconLibraryModal.vue';

const emit = defineEmits(['onSave']);

const alert = useAlerts();

const isLoading = ref(false);
const iconLibraryModalVisible = ref(false);

const formState = reactive({
    name: '',
    accentColor: '',
    icon: 'cil-puzzle',
});

const savePerspective = async () => {
    isLoading.value = true;
    try {
        //validate form
        if (!formState.name || !formState.accentColor) {
            alert.add({ title: 'Error', content: 'Por favor, complete todos los campos' });
            return;
        }

        //save perspective
        await createPerspective({
            name: formState.name,
            accent_color: formState.accentColor,
            icon: formState.icon,
        });

        alert.add({ title: 'Perspectiva guardada', content: 'Se ha guardado la perspectiva' });
        emit('onSave');
    } catch (error) {
        alert.error('Error al guardar la perspectiva');
    } finally {
        isLoading.value = false;
    }
}
</script>
