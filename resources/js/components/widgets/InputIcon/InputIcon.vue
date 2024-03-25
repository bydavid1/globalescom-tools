<template>
    <CButton @click="open">
        <CIcon v-if="!iconLibraryModalVisible" v-model:icon="previewIcon" size="sm" />
    </CButton>
    <icon-library-modal
        :visible="iconLibraryModalVisible"
        @close="close"
        @onChoose="onChoose"
    />
</template>

<script setup>
import { ref } from 'vue';
import IconLibraryModal from './IconLibraryModal.vue';

const model = defineModel()
const previewIcon = ref('cil-puzzle');

const iconLibraryModalVisible = ref(false);

const open = () => {
    iconLibraryModalVisible.value = true;
}

const close = () => {
    iconLibraryModalVisible.value = false;
}

const onChoose = (choosenIcon) => {
    console.log(choosenIcon);
    iconLibraryModalVisible.value = false;
    model.value = choosenIcon;
    previewIcon.value = choosenIcon;
}
</script>
