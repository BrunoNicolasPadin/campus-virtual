<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('divisiones.index', institucion_id)">Estructura</inertia-link> /
                <inertia-link class="hover:underline" :href="route('divisiones.show', [institucion_id, division.id])">
                    <span v-if="division.orientacion_nombre">{{ division.nivel_nombre }} - {{ division.orientacion_nombre }} - {{ division.curso_nombre }} - {{ division.division }}</span>
                    <span v-else>{{ division.nivel_nombre }} - {{ division.curso_nombre }} - {{ division.division }}</span>
                </inertia-link> / 
                <inertia-link class="hover:underline" :href="route('evaluaciones.index', [institucion_id, division.id])">Evaluaciones</inertia-link> / 
                Agregar
            </span>
        </template>

        <div class="py-6">
            <estructura-form>
                <template #formulario>
                    <form method="post" @submit.prevent="submit">
                        
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Título
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
                                    <option v-for="asignaturaDocente in asignaturasDocentes" :key="asignaturaDocente.id" :value="asignaturaDocente.id">{{ asignaturaDocente.nombre }}</option>

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
                                        Fecha y hora de realización
                                    </template>
                                </label-form>

                                <datetime type="datetime" value-zone="UTC-3" required v-model="form.fechaHoraRealizacion"></datetime>
                                
                                <!-- <datetime
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                format="DD-MM-YYYY H:i:s"
                                v-model="form.fechaHoraRealizacion"></datetime> -->
                                
                                <info>
                                    <template #info>
                                        Es obligatorio.
                                    </template>
                                </info>
                            </div>

                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Fecha y hora de finalización
                                    </template>
                                </label-form>

                                <datetime type="datetime" value-zone="UTC-3" required v-model="form.fechaHoraFinalizacion"></datetime>
                                
                                <!-- <datetime
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                format="DD-MM-YYYY H:i:s"
                                v-model="form.fechaHoraFinalizacion"></datetime> -->
                                
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
                                v-model="form.comentario"></textarea>
                                
                                <info>
                                    <template #info>
                                        No es obligatorio.
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
    /* import datetime from 'vuejs-datetimepicker'; */
    import { Datetime } from 'vue-datetime'

    export default {
        components: {
            AppLayout,
            EstructuraForm,
            LabelForm,
            InputForm,
            Info,
            Guardar,
            /* datetime, */
            datetime: Datetime
        },

        props: {
            institucion_id: String,
            division: Object,
            asignaturasDocentes: Array,
        },

        title: 'Registrar evaluacion',

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
