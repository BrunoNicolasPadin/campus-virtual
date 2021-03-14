<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('roles.index', institucion_id)">Roles</inertia-link> /
                <inertia-link class="hover:underline" :href="route('alumnos.index', institucion_id)">Alumnos</inertia-link> /
                <inertia-link class="hover:underline" :href="route('alumnos.show', [institucion_id, alumno.id])">{{ alumno.name }}</inertia-link> /
                <inertia-link class="hover:underline" :href="route('libretas.index', [institucion_id, alumno.id])">Libreta</inertia-link> / 
                Editar notas de {{ libretas.asignatura.nombre }}
            </span>
        </template>

        <div class="py-6">

            <estructura-form>
                <template #formulario>
                    <form method="post" @submit.prevent="submit">
                        
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/3 px-3 mb-6 md:mb-0" v-for="nota in form.notas" :key="nota.id">
                                <label-form>
                                    <template #label-value>
                                        {{ nota.periodo }}
                                    </template>
                                </label-form>

                                <select
                                v-if="tipoEvaluacion == 'Escrita'"
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                v-model="nota.calificacion">
                                    
                                    <option value="">-</option>
                                    <option v-for="formaDescripcion in formasDescripcion" :key="formaDescripcion.id" :value="formaDescripcion.opcion">
                                        {{ formaDescripcion.opcion }}
                                    </option>
                                </select>

                                <select
                                v-else
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                v-model="nota.calificacion">
                                    
                                    <option value="">-</option>
                                    <option v-for="formaDescripcion in formasDescripcion" :key="formaDescripcion.id" :value="formaDescripcion">
                                        {{ formaDescripcion }}
                                    </option>
                                </select>
                                
                                <info>
                                    <template #info>
                                        Puede dejarlo vacío.
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
            alumno: Object,
            libretas: Object,
            formasDescripcion: Array,
            tipoEvaluacion: String,
        },

        title: 'Editar libreta',

        data() {
            return {
                form: {
                    notas: this.libretas.calificaciones,
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.put(this.route('libretas.update', [this.institucion_id, this.alumno.id, this.libretas.id]), this.form)
            },
        },
    }
</script>
