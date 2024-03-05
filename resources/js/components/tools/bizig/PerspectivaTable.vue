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
                    <CTableRow
                        v-for="(batch, batchIndex) in batches" :key="batchIndex"
                    >
                        <CTableDataCell
                            v-for="(input, inputIndex) in form.inputs" :key="inputIndex"
                        >
                            <CFormInput
                                v-if="input.type == 'text'"
                                :disabled="!batch.editing"
                                :value="getModel(batch, input.id)"
                                @input="setModel(batch, input.id, $event.target.value)"
                                placeholder="Ingrese la respuesta" type="text" size="sm" />
                            <CFormSelect
                                v-else-if="input.type == 'select'"
                                :value="getModel(batch, input.id)"
                                @input="setModel(batch, input.id, $event.target.value)"
                                :disabled="!batch.editing"
                                size="sm"
                            >
                                <option
                                    v-for="(option, optionIndex) in input.options"
                                    :key="optionIndex"
                                    :value="option.value"
                                >
                                    {{ option.label }}
                                </option>
                            </CFormSelect>
                        </CTableDataCell>
                        <CTableDataCell class="text-white">
                            <CButton v-if="batch.editing" color="primary" size="sm"
                                @click="saveAnswer(batch.id, batchIndex)">
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
import { computed, reactive, ref, watch } from 'vue';
import { updateBatch, saveBatch } from '../../../services/tools/bizig/answer-service';
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

const answersBatchShape = {
    answers: [
        {
            'input_id': 8,
            'body': ''
        },
        {
            'input_id': 9,
            'body': ''
        },
        {
            'input_id': 10,
            'body': ''
        },
        {
            'input_id': 11,
            'body': ''
        },
        {
            'input_id': 12,
            'body': ''
        },
        {
            'input_id': 13,
            'body': ''
        },
        {
            'input_id': 14,
            'body': ''
        }
    ],
    editing: true,
    unhandled: true
};

const batches = ref([]);


const globalProgress = ref(0);

const initBatches = () => {
    batches.value = props.answerBatches.map(batch => reactive({ ...batch }));
    batches.value.push(reactive({ ...answersBatchShape, id: Math.random() * 100}));
};

const progress = computed(() => batches.value.map((b) => b.answers.find(a => a.input_id == 14).body));

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

const saveAnswer = async (id, index) => {
    try {
        batches.value.find(b => b.id == id).editing = false;

        const batch = batches.value.find(b => b.id == id);

        if (batch.unhandled) {
            await saveBatch({ ...batch, section_id: props.section.id, form_id: props.form.id });
        } else {
            await updateBatch(batch);
        }

        batches.value.find(b => b.id == id).unhandled = false;

        if (index === batches.value.length - 1) {
            console.log('last batch');
            const newAnswerBatch = reactive({ ...answersBatchShape, id: Math.random() * 100});
            batches.value.push(newAnswerBatch);
        }
    } catch (error) {
        console.error('noooo', error);
    }
};

const editAnswer = (id) => {
    batches.value.find(b => b.id == id).editing = true;
};

watch(progress, (newProgress) => {
    calculateGlobalProgress();
});

const calculateGlobalProgress = () => {
    let totalProgress = 0;

    if (batches.value.length === 0) {
        globalProgress.value = 0;
        return;
    }

    for (let i = 0; i < batches.value.length; i++) {
        const avance = parseInt(batches.value[i].answers.find(a => a.input_id == 14).body);
        if (!isNaN(avance) && avance >= 0 && avance <= 100) {
            totalProgress += avance;
        }
    }

    globalProgress.value = parseInt((totalProgress / batches.value.length).toFixed(0));
};

watch(() => props.answerBatches, () => {
    initBatches();
    calculateGlobalProgress();
}, { immediate: true });

</script>
