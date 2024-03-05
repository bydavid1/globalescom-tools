<template>
    <CCard>
        <CCardHeader>
            <CRow class="align-items-center">
                <CCol xl="10">
                    {{ section.name }}
                </CCol>
                <CCol xl="2" class="text-end">
                    <CProgress>
                        <CProgressBar :value="globalProgress">{{ globalProgress }}%</CProgressBar>
                    </CProgress>
                </CCol>
            </CRow>
        </CCardHeader>
        <CCardBody>
            <CTable bordered>
                <CTableHead>
                    <CTableRow>
                        <CTableHeaderCell v-for="(input, index) in form.inputs" :key="index">{{ input.label }}
                        </CTableHeaderCell>
                        <CTableHeaderCell>Acción</CTableHeaderCell>
                    </CTableRow>
                </CTableHead>
                <CTableBody>
                    <CTableRow v-for="(batch, batchIndex) in answerBatches" :key="batchIndex">
                        <CTableDataCell v-for="(input, inputIndex) in form.inputs" :key="inputIndex">
                            <CFormInput
                                :disabled="!batch.editing"
                                :value="getModel(batch, input.id)"
                                @input="setModel(batch, input.id, $event.target.value)"
                                placeholder="Ingrese la respuesta"
                                type="text" size="sm"
                            />
                        </CTableDataCell>
                        <CTableDataCell class="text-white">
                            <CButton v-if="batch.editing" color="primary" size="sm" @click="saveAnswer(batch.id, batchIndex)">
                                Guardar
                            </CButton>
                            <CButton v-else color="success" size="sm" @click="editAnswer(batch.id)">
                                Editar
                            </CButton>
                        </CTableDataCell>
                    </CTableRow>
                </CTableBody>
            </CTable>

        </CCardBody>
    </CCard>
</template>

<script setup>
import { CTableHeaderCell } from '@coreui/vue';
import { computed, reactive, ref, watch } from 'vue';

const props = defineProps({
    section: {
        type: Object
    },
    form: {
        type: Object
    },
    answerBatches: {
        type: Array
    }
});

const globalProgress = ref(0);

const progress = computed(() => props.answerBatches.map((b) => b.answers.find(a => a.input_id == 14).body));

const getModel = (batch, inputId) => {
    const answer = batch.answers.find(a => a.input_id === inputId);
    return answer ? answer.body : '';
};

const setModel = (batch, inputId, value) => {
    const answer = batch.answers.find(a => a.input_id === inputId);
    if (answer) {
        answer.body = value;
    }
};
const saveAnswer = (id, index) => {
    props.answerBatches.find(b => b.id == id).editing = false;

    if (index === props.answerBatches.length - 1) {
        // const newAnswer = { ...answerShape, editing: true, avance: 0 }; // Avoid editing issues
        // answers.push(newAnswer);

        console.log('Last answer');
    }
};

const editAnswer = (id) => {
    props.answerBatches.find(b => b.id == id).editing = true;
};

watch(progress, (newProgress) => {
    calculateGlobalProgress();
});

const calculateGlobalProgress = () => {
    let totalProgress = 0;

    for (let i = 0; i < answerBatches.length; i++) {
        const avance = parseInt(props.answerBatches[i].find(a => a.input_id == 14).body);
        if (!isNaN(avance) && avance >= 0 && avance <= 100) {
            totalProgress += avance;
        }
    }

    globalProgress.value = (totalProgress / answers.length).toFixed(0);
};
</script>
