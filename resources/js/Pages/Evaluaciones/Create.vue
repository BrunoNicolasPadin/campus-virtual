<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <inertia-link :href="route('divisiones.index', institucion_id)">Estructura</inertia-link>
                > 
                <inertia-link :href="route('divisiones.show', [institucion_id, division.id])">
                    <span v-if="division.orientacion">{{ division.nivel.nombre }} - {{ division.orientacion.nombre }} - {{ division.curso.nombre }} - {{ division.division }}</span>
                    <span v-else>{{ division.nivel.nombre }} - {{ division.curso.nombre }} - {{ division.division }}</span>
                </inertia-link>
                > 
                <inertia-link :href="route('evaluaciones.index', [institucion_id, division.id])">Evaluaciones</inertia-link>
                 > Nueva evaluacion
            </h2>
        </template>

        <div class="py-12">

            <!-- Errors Messages -->

            <transition name="fade">
                <div v-if="Object.keys(errors).length > 0" class="bg-red-200 px-6 py-4 mx-2 my-4 rounded-md text-lg flex items-center container mx-auto w-full">
                    <div class="w-1/12">
                        <svg viewBox="0 0 24 24" class="text-red-600 w-5 h-5 sm:w-5 sm:h-5 mr-3">
                            <path fill="currentColor" d="M11.983,0a12.206,12.206,0,0,0-8.51,3.653A11.8,11.8,0,0,0,0,12.207,11.779,11.779,0,0,0,11.8,24h.214A12.111,12.111,0,0,0,24,11.791h0A11.766,11.766,0,0,0,11.983,0ZM10.5,16.542a1.476,1.476,0,0,1,1.449-1.53h.027a1.527,1.527,0,0,1,1.523,1.47,1.475,1.475,0,0,1-1.449,1.53h-.027A1.529,1.529,0,0,1,10.5,16.542ZM11,12.5v-6a1,1,0,0,1,2,0v6a1,1,0,1,1-2,0Z"
                            ></path>
                        </svg>
                    </div>
                    <div class="w-9/12">
                        <span class="text-red-800"> {{ errors[Object.keys(errors)[0]][0] }} </span>
                    </div>
                    <div class="w-2/12">
                        <span class="text-black font-bold float-right text-2xl cursor-pointer" @click="cerrarAlerta()">&times;</span> 
                    </div>
                </div>
            </transition>

            <estructura-form>
                <template #formulario>
                    <form method="post" @submit.prevent="submit">
                        
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Titulo
                                    </template>
                                </label-form>
                                
                                <input-form required type="text" v-model="form.titulo" />
                                
                                <info>
                                    <template #info>
                                        Es obligatorio.
                                    </template>
                                </info>
                            </div>

                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Asignatura
                                    </template>
                                </label-form>
                                
                                <select
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.asignatura_id">
                                    
                                    <option value="" disabled selected>-</option>
                                    <option v-for="asignaturaDocente in asignaturasDocentes" :key="asignaturaDocente.id" :value="asignaturaDocente.asignatura_id">{{ asignaturaDocente.asignatura.nombre }}</option>

                                </select>
                                
                                <info>
                                    <template #info>
                                        Es obligatorio.
                                    </template>
                                </info>
                            </div>
                        </div>

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Tipo
                                    </template>
                                </label-form>
                                
                                <select
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.tipo">
                                    
                                    <option value="" disabled selected>-</option>
                                    <option value="Examen">Examen</option>
                                    <option value="Trabajo practico">Trabajo practico</option>
                                    <option value="Tarea">Tarea</option>

                                </select>
                                
                                <info>
                                    <template #info>
                                        Es obligatorio.
                                    </template>
                                </info>
                            </div>
                        </div>

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Fecha y hora de realizacion
                                    </template>
                                </label-form>
                                
                                <datetime
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                format="DD-MM-YYYY H:i:s"
                                v-model="form.fechaHoraRealizacion"></datetime>
                                
                                <info>
                                    <template #info>
                                        Es obligatorio.
                                    </template>
                                </info>
                            </div>

                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Fecha y hora de finalizacion
                                    </template>
                                </label-form>
                                
                                <datetime
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                format="DD-MM-YYYY H:i:s"
                                v-model="form.fechaHoraFinalizacion"></datetime>
                                
                                <info>
                                    <template #info>
                                        Es obligatorio.
                                    </template>
                                </info>
                            </div>
                        </div>

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Temas/Comentario
                                    </template>
                                </label-form>
                                
                                <textarea
                                class="appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.comentario"></textarea>
                                
                                <info>
                                    <template #info>
                                        Es obligatorio poner aunque sea una letra o simbolo como minimo.
                                    </template>
                                </info>
                            </div>
                        </div>

                        <guardar></guardar>

                    </form>
                </template>
            </estructura-form>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import EstructuraForm from '@/Formulario/EstructuraForm.vue'
    import LabelForm from '@/Formulario/LabelForm.vue'
    import InputForm from '@/Formulario/InputForm.vue'
    import Info from '@/Formulario/Info.vue'
    import Guardar from '@/Botones/Guardar.vue'
    import datetime from 'vuejs-datetimepicker';

    export default {
        components: {
            AppLayout,
            EstructuraForm,
            LabelForm,
            InputForm,
            Info,
            Guardar,
            datetime,
        },

        props: {
            errors: Object,
            institucion_id: String,
            division: Object,
            asignaturasDocentes: Array,
        },

        data() {
            return {
                form: {
                    titulo: null,
                    tipo: null,
                    asignatura_id: null,
                    fechaHoraRealizacion: null,
                    fechaHoraFinalizacion: null,
                    comentario: null,
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('evaluaciones.store', [this.institucion_id, this.division.id]), this.form)
            },
        },
    }
</script>
