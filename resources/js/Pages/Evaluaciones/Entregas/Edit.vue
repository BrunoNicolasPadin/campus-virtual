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
                <inertia-link class="hover:underline" :href="route('evaluaciones.show', [institucion_id, division.id, evaluacion.id])">{{ evaluacion.titulo }}</inertia-link> / 
                <inertia-link class="hover:underline" :href="route('entregas.index', [institucion_id, division.id, evaluacion.id])">Entregas</inertia-link> / 
                <inertia-link class="hover:underline" :href="route('entregas.show', [institucion_id, division.id, evaluacion.id, entrega.id])">{{ entrega.alumno.user.name }}</inertia-link> /
                Editar
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
                                        Se puede dejar vacío (primera opción)
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

    export default {
        components: {
            AppLayout,
            EstructuraForm,
            LabelForm,
            InputForm,
            Info,
            Guardar,
        },

        props: {
            institucion_id: String,
            division: Object,
            evaluacion: Object,
            entrega: Object,
            formasDescripcion: Array,
            tipoEvaluacion: String,
        },

        title: 'Calificar entrega',

        data() {
            return {
                form: {
                    calificacion: this.entrega.calificacion,
                    comentario: this.entrega.comentario,
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.put(this.route('entregas.update', [this.institucion_id, this.division.id, this.evaluacion.id, this.entrega.id]), this.form)
            },
        },
    }
</script>
