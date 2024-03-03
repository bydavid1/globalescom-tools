<template>
    <CCard>
        <CCardHeader>
            <CRow class="align-items-center">
                <CCol xl="10">
                    Perspectiva: "Aprendizaje y Crecimiento del Capital Humano".
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
                        <CTableHeaderCell>Objetivos Estratégicos:</CTableHeaderCell>
                        <CTableHeaderCell>Indicadores:</CTableHeaderCell>
                        <CTableHeaderCell>¿De dónde obtendrá el Presupuesto?</CTableHeaderCell>
                        <CTableHeaderCell>Presupuesto:</CTableHeaderCell>
                        <CTableHeaderCell>Responsables:</CTableHeaderCell>
                        <CTableHeaderCell>Tiempo:</CTableHeaderCell>
                        <CTableHeaderCell>Avance</CTableHeaderCell>
                        <CTableHeaderCell></CTableHeaderCell>
                    </CTableRow>
                </CTableHead>
                <CTableBody>
                    <CTableRow v-for="(answer, index) in answers" :key="index">
                        <CTableDataCell>
                            <CFormInput :disabled="!answer.editing" type="text" size="sm"
                                placeholder="Ingrese la respuesta" />
                        </CTableDataCell>
                        <CTableDataCell>
                            <CFormInput :disabled="!answer.editing" type="text" size="sm"
                                placeholder="Ingrese la respuesta" />
                        </CTableDataCell>
                        <CTableDataCell>
                            <CFormInput :disabled="!answer.editing" type="text" size="sm"
                                placeholder="Ingrese la respuesta" />
                        </CTableDataCell>
                        <CTableDataCell>
                            <CFormInput :disabled="!answer.editing" type="text" size="sm"
                                placeholder="Ingrese la respuesta" />
                        </CTableDataCell>
                        <CTableDataCell>
                            <CFormInput :disabled="!answer.editing" type="text" size="sm"
                                placeholder="Ingrese la respuesta" />
                        </CTableDataCell>
                        <CTableDataCell>
                            <CFormInput :disabled="!answer.editing" type="text" size="sm"
                                placeholder="Ingrese la respuesta" />
                        </CTableDataCell>
                        <CTableDataCell>
                            <CFormSelect v-model="answer.avance" size="sm" aria-label="Seleccione el avance">
                                <option value="0">0%</option>
                                <option value="10">10%</option>
                                <option value="20">20%</option>
                                <option value="30">30%</option>
                                <option value="40">40%</option>
                                <option value="50">50%</option>
                                <option value="60">60%</option>
                                <option value="70">70%</option>
                                <option value="80">80%</option>
                                <option value="90">90%</option>
                                <option value="100">100%</option>
                            </CFormSelect>
                        </CTableDataCell>
                        <CTableDataCell class="text-white">
                            <CButton v-if="answer.editing" color="primary" size="sm" @click="saveAnswer(index)">
                                Guardar
                            </CButton>
                            <CButton v-else color="success" size="sm" @click="editAnswer(index)">
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

const answerShape = {
    objetivo: '',
    indicador: '',
    presupuesto: '',
    responsable: '',
    tiempo: '',
    avance: 0,
    editing: true
};

const globalProgress = ref(0);
const answers = reactive([answerShape]);

const progress = computed(() => answers.map((answer) => answer.avance));

const saveAnswer = (index) => {
    answers[index].editing = false;

    if (index === answers.length - 1) {
        const newAnswer = { ...answerShape, editing: true, avance: 0 }; // Avoid editing issues
        answers.push(newAnswer);
    }
};

const editAnswer = (index) => {
    answers[index].editing = true;
};

watch(progress, (newProgress) => {
    calculateGlobalProgress();
});

const calculateGlobalProgress = () => {
    let totalProgress = 0;

    for (let i = 0; i < answers.length; i++) {
        const avance = parseInt(answers[i].avance);
        if (!isNaN(avance) && avance >= 0 && avance <= 100) {
            totalProgress += avance;
        }
    }

    globalProgress.value = (totalProgress / answers.length).toFixed(0);
};
</script>
