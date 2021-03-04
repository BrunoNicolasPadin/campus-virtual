<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                Seleccionar tu curso
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
                                        Seleccionar división
                                    </template>
                                </label-form>
                                
                                <select
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.division_id">
                                    
                                    <option value="" disabled selected>-</option>
                                    <option v-for="division in divisiones" :key="division.id" :value="division.id">
                                        <span v-if="division.orientacion">
                                            {{ division.nivel_nombre }} - {{ division.orientacion_nombre }} - {{ division.curso_nombre }} - {{ division.division }}
                                        </span>

                                        <span v-else>
                                            {{ division.nivel_nombre }} - {{ division.curso_nombre }} - {{ division.division }}
                                        </span>
                                    </option>

                                </select>
                                
                                <info>
                                    <template #info>
                                        Es obligatorio
                                    </template>
                                </info>
                            </div>

                            <div class="md:w-1/2 px-3">
                                
                                <label-form>
                                    <template #label-value>
                                        Clave de acceso de la división
                                    </template>
                                </label-form>
                                
                                <input-form required type="password" v-model="form.claveDeAcceso" />
                                
                                <info>
                                    <template #info>
                                        Es obligatorio.
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
            divisiones: Array,
        },

        title: 'Anotarse como alumno',

        data() {
            return {
                form: {
                    division_id: null,
                    claveDeAcceso: null,
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('alumnos.store', this.institucion_id), this.form)
            },
        },
    }
</script>
