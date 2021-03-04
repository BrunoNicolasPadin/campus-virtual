<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                Anotate como padre
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
                                        Seleccionar hijo/a
                                    </template>
                                </label-form>
                                
                                <select
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.alumno_id">
                                    
                                    <option value="" disabled selected>-</option>
                                    <option v-for="alumno in alumnos" :key="alumno.id" :value="alumno.id">
                                            {{ alumno.name }}
                                    </option>

                                </select>
                                
                                <info>
                                    <template #info>
                                        Es obligatorio. Debe apretar en "Guardar" para registrar a este/a alumno/a como su hijo/a y luego, si ya cargo a todos sus hijos/as, apriete en "Finalizar registro".
                                    </template>
                                </info>
                            </div>
                        </div>

                        <guardar></guardar>

                        <button type="button" class="border border-yellow-200 bg-yellow-200 text-black rounded-full px-4 py-2 transition duration-500 ease select-none hover:bg-yellow-400 focus:outline-none focus:shadow-outline">
                            <inertia-link :href="route('roles.mostrarCuentas')">Finalizar registro</inertia-link>
                        </button>

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
            alumnos: Array,
        },

        title: 'Registrarte como padre',

        data() {
            return {
                form: {
                    alumno_id: null,
                },
            }
        },

        methods: {

            submit() {
                this.$inertia.post(this.route('padres.store', this.institucion_id), this.form)
            },
        },
    }
</script>
