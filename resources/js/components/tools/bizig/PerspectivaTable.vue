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
            <div v-if="loading" class="d-flex justify-content-center">
                <CSpinner color="primary" />
            </div>
            <CTable v-else bordered>
                <CTableHead>
                    <CTableRow>
                        <CTableHeaderCell v-for="(input, index) in form.inputs" :key="index">{{ input.label }}
                        </CTableHeaderCell>
                        <CTableHeaderCell v-if="!showAsAdmin">Acción</CTableHeaderCell>
                    </CTableRow>
                </CTableHead>
                <CTableBody>
                    <CTableRow v-for="(batch, batchIndex) in batches" :key="batchIndex">
                        <template v-if="batch.editing">
                            <CTableDataCell v-for="(input, inputIndex) in form.inputs" :key="inputIndex">
                                <CFormInput v-if="input.type == 'text'"
                                    :value="getModel(batch, input.id)"
                                    @input="setModel(batch, input.id, $event.target.value)"
                                    placeholder="Ingrese la respuesta" type="text" size="sm" />
                                <select2
                                    v-else-if="input.type == 'multiselect'"
                                    :data="users"
                                    :value="setSelectedUsers(batch, input.id)"
                                    :multiple="true"
                                    @update="syncSelectUsers(batch, input.id, $event)"
                                />
                                <CDatePicker v-else-if="input.type == 'datepicker'" locale="es-ES" size="sm"
                                    :date="getModel(batch, input.id)"
                                    @update:date="setModel(batch, input.id, $event)"
                                    placeholder="Seleccione la fecha"
                                />
                                <CFormSelect v-else-if="input.type == 'select'"
                                    :value="getModel(batch, input.id)"
                                    @input="setModel(batch, input.id, $event.target.value)"
                                    size="sm"
                                >
                                    <option v-for="(option, optionIndex) in input.options" :key="optionIndex"
                                        :value="option.value">
                                        {{ option.label }}
                                    </option>
                                </CFormSelect>
                            </CTableDataCell>
                        </template>
                        <template v-else>
                            <CTableDataCell v-for="(input, inputIndex) in form.inputs" :key="inputIndex" style="font-size: 14px;">
                                {{ getAnswer(batch, input.id, input.type) }}
                            </CTableDataCell>
                        </template>
                        <CTableDataCell v-if="!showAsAdmin" class="text-white">
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
import { updateBatch, saveBatch, getMyAnswers, getAnswersByCompany } from '../../../services/api/tools/bizig/answer-service';
import { useUsers } from '../../../store/user';
import { useBizig } from "../../../store/tools/bizig/bizig"

/// Hooks
const store = useUsers();
const bizigStore = useBizig();


/// Props
const props = defineProps({
    section: {
        type: Object
    },
    form: {
        type: Object
    },
    loading: {
        type: Boolean
    }
});


/// Static variables
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


/// Reactive variables
const batches = ref([]);
const globalProgress = ref(0);


/// Computed properties
const users = computed(() => store.getUsers.map(user => ({ value: user.id, label: user.name })));
const progress = computed(() => batches.value.map((b) => b.answers.find(a => a.input_id == 14)?.body || 0));
const showAsAdmin = computed(() => bizigStore.showAsAdmin);
const companyId = computed(() => bizigStore.companyId);


/// Methods
const initBatches = async () => {
    let response;
    if (showAsAdmin.value) {
        response = await getAnswersByCompany(companyId.value, props.section.id);
    } else {
        response = await getMyAnswers(props.section.id);
    }

    batches.value = response.map(batch => reactive({ ...batch }));
    const answerBatch = JSON.parse(JSON.stringify(answersBatchShape));


    if (!showAsAdmin.value) batches.value.push(reactive({ ...answerBatch, id: Math.random() * 100 }));
};


const getModel = (batch, inputId) => {
    let answer = batch.answers.find(a => a.input_id === inputId);
    if (!answer) {
        batch.answers.push({ id: null, input_id: inputId, body: '' });
    }

    answer = batch.answers.find(a => a.input_id === inputId);

    return answer.body;
};

const setModel = (batch, inputId, value) => {
    const answer = batch.answers.find(a => a.input_id === inputId);
    if (answer) {
        answer.body = value;
    }
};

const syncSelectUsers = (batch, inputId, value) => {
    const answer = batch.answers.find(a => a.input_id === inputId);
    if (answer) {
        answer.body = JSON.stringify(value);
    } else {
        batch.answers.push({ id: null, input_id: inputId, body: JSON.stringify(value) });
    }
}

const setSelectedUsers = (batch, inputId) => {
    try {
        const answer = batch.answers.find(a => a.input_id === inputId);
        return answer ? JSON.parse(answer.body) : [];
    } catch (error) {
        return [];
    }
};

const getAnswer = (batch, inputId, inputType) => {
    const answer = batch.answers.find(a => a.input_id === inputId);
    if (answer) {
        if (inputType === 'multiselect') {
            return JSON.parse(answer.body).map(id => store.getUsers.find(u => u.id == id).name).join(', ');
        }

        if (inputType === 'datepicker') {
            const date = new Date(answer.body);
            const day = date.getDate().toString().padStart(2, '0');
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            const year = date.getFullYear().toString();
            return `${day}/${month}/${year}`;
        }

        return answer.body;
    }
    return '';
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
            console.log(answersBatchShape)
            const newAnswerBatch = JSON.parse(JSON.stringify(answersBatchShape));
            newAnswerBatch.id = Math.random() * 100;
            newAnswerBatch.editing = true;
            batches.value.push(reactive(newAnswerBatch));
        }
    } catch (error) {
        console.error('Error al guardar', error);
    }
};

const editAnswer = (id) => {
    batches.value.find(b => b.id == id).editing = true;
};

const calculateGlobalProgress = () => {
    let totalProgress = 0;

    if (batches.value.length === 0) {
        globalProgress.value = 0;
        return;
    }

    for (let i = 0; i < batches.value.length; i++) {
        const avance = parseInt(batches.value[i].answers.find(a => a.input_id == 14)?.body || 0);
        if (!isNaN(avance) && avance >= 0 && avance <= 100) {
            totalProgress += avance;
        }
    }

    globalProgress.value = parseInt((totalProgress / batches.value.length).toFixed(0));
};


/// Watchers
watch(progress, (newProgress) => {
    calculateGlobalProgress();
});

watch(() => props.section, () => {
    initBatches();
    calculateGlobalProgress();
}, { immediate: true });

</script>
