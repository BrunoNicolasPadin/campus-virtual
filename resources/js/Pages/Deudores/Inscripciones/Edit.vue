<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('divisiones.index', institucion_id)">Estructura</inertia-link> /
                <inertia-link class="hover:underline" :href="route('divisiones.show', [institucion_id, division.id])">
                    <span v-if="division.orientacion_nombre">{{ division.nivel_nombre }} - {{ division.orientacion_nombre }} - {{ division.curso_nombre }} - {{ division.division }}</span>
                    <span v-else>{{ division.nivel_nombre }} - {{ division.curso_nombre }} - {{ division.division }}</span>
                </inertia-link> / 
                <inertia-link class="hover:underline" :href="route('asignaturas.index', [institucion_id, division.id])">Asignaturas</inertia-link> /
                <inertia-link class="hover:underline" :href="route('mesas.index', [institucion_id, division.id, asignatura.id])">Mesas de {{ asignatura.nombre }}</inertia-link> / 
                <inertia-link class="hover:underline" :href="route('mesas.show', [institucion_id, division.id, asignatura.id, mesa.id])">Mesa {{ mesa.fechaHoraRealizacion }} - {{ mesa.fechaHoraFinalizacion }}</inertia-link> / 
                <inertia-link class="hover:underline" :href="route('inscripciones.show', [institucion_id, division.id, asignatura.id, mesa.id, inscripcion.id])">Entrega de {{ inscripcion.alumno.user.name }}</inertia-link> /
                Calificar
            </span>
        </template>

        <div class="py-6">

            <estructura-form>
                <template #formulario>
                    <form method="post" @submit.prevent="submit">
                        
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Calificación
                                    </template>
                                </label-form>
                                
                                <select
                                v-if="tipoEvaluacion == 'Escrita'"
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                v-model="form.calificacion">
                                    
                                    <option value="">-</option>
                                    <option v-for="formaDescripcion in formasDescripcion" :key="formaDescripcion.id" :value="formaDescripcion.opcion">
                                        {{ formaDescripcion.opcion }}
                                    </option>
                                </select>

                                <select
                                v-else
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                v-model="form.calificacion">
                                    
                                    <option value="">-</option>
                                    <option v-for="formaDescripcion in formasDescripcion" :key="formaDescripcion.id" :value="formaDescripcion">
                                        {{ formaDescripcion }}
                                    </option>
                                </select>
                                
                                <info>
                                    <template #info>
                                        Se puede dejar vacío.
                                    </template>
                                </info>
                            </div>
                        </div>

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Comentario
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
            institucion_id: String,
            division: Object,
            asignatura: Object,
            mesa: Object,
            inscripcion: Object,
            formasDescripcion: Array,
            tipoEvaluacion: String,
        },

        title: 'Calificar al inscripto',

        data() {
            return {
                form: {
                    calificacion: this.inscripcion.calificacion,
                    comentario: this.inscripcion.comentario,
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.put(this.route('inscripciones.update', [this.institucion_id, this.division.id, this.asignatura.id, this.mesa.id, this.inscripcion.id]), this.form)
            },
        },
    }
</script>
