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
                <inertia-link class="hover:underline" :href="route('mesas.show', [institucion_id, division.id, asignatura.id, mesa.id])">Mesa {{ fechaHoraRealizacion }} - {{ fechaHoraFinalizacion }}</inertia-link> / 
                Editar
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
                                        Fecha y hora de realización
                                    </template>
                                </label-form>
                                
                                <datetime type="datetime" value-zone="UTC-3" required v-model="form.fechaHoraRealizacion"></datetime>
                                
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
    import { Datetime } from 'vue-datetime'

    export default {
        components: {
            AppLayout,
            EstructuraForm,
            LabelForm,
            InputForm,
            Info,
            Guardar,
            datetime: Datetime
        },

        props: {
            institucion_id: String,
            division: Object,
            asignatura: Object,
            mesa: Object,
            fechaHoraRealizacion: String,
            fechaHoraFinalizacion: String,
        },

        title: 'Editar mesa de examen',

        data() {
            return {
                form: {
                    fechaHoraRealizacion: this.mesa.fechaHoraRealizacion,
                    fechaHoraFinalizacion: this.mesa.fechaHoraFinalizacion,
                    comentario: this.mesa.comentario,
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.put(this.route('mesas.update', [this.institucion_id, this.division.id, this.asignatura.id, this.mesa.id]), this.form)
            },
        },
    }
</script>
