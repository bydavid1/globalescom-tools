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
        <CContainer class="mt-4">
            <CLoadingButton type="submit" color="primary" :loading="isLoading">
                Guardar
            </CLoadingButton>
        </CContainer>
    </CForm>
</template>

<script setup>
import { reactive, ref, watch } from 'vue';
import { useAlerts } from '../../../store/alert';
import { createPerspective } from '../../../services/api/tools/bizig/perspectives-service';

const emit = defineEmits(['onSave']);

const alert = useAlerts();

const isLoading = ref(false);

const formState = reactive({
    name: '',
    accentColor: '',
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
