<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('instituciones.show', institucion_id)">Perfil institucional</inertia-link> /
                <inertia-link class="hover:underline" :href="route('formas-evaluacion.index', institucion_id)">Formas de evaluación</inertia-link> / 
                <inertia-link class="hover:underline" :href="route('formas-evaluacion.show', [institucion_id, formaEvaluacion.id])">{{ formaEvaluacion.nombre }}</inertia-link> / 
                Agregar opción
            </h2>
        </template>

        <div class="py-6">
            <estructura-form>
                <template #formulario>
                    <form method="post" @submit.prevent="submit">
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        Opción/Valor. EJ: excelente, no satisfactorio, mal, etc...
                                    </template>
                                </label-form>
                                
                                <input-form required type="text" v-model="form.opcion" />
                                
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
                                        Aprobado
                                    </template>
                                </label-form>
                                
                                <input type="checkbox" v-model="form.aprobado">
                                
                                <info>
                                    <template #info>
                                        Apretarlo si este valor significa que el alumno aprobó.
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
    import Info from '@/Formulario/Info.vue'
    import Guardar from '@/Botones/Guardar.vue'
    import InputForm from '@/Formulario/InputForm.vue'

    export default {
        components: {
            AppLayout,
            EstructuraForm,
            LabelForm,
            Info,
            Guardar,
            InputForm,
        },

        props: {
            institucion_id: String,
            formaEvaluacion: Object,
        },

        title: 'Agregar forma de evaluación',

        data() {
            return {
                form: {
                    opcion: null,
                    aprobado: false,
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('formas-descripcion.store', [this.institucion_id, this.formaEvaluacion.id]), this.form)
            },
        },
    }
</script>
