<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('divisiones.index', institucion_id)">Estructura</inertia-link> / Editar division
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
                                        Nivel
                                    </template>
                                </label-form>
                                
                                <select
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.nivel_id">
                                    
                                    <option value="" disabled selected>-</option>
                                    <option v-for="nivel in niveles" :key="nivel.id" :value="nivel.id">{{ nivel.nombre }}</option>

                                </select>
                                
                                <info>
                                    <template #info>
                                        Es obligatorio.
                                    </template>
                                </info>
                            </div>

                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        Orientación
                                    </template>
                                </label-form>
                                
                                <select
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                v-model="form.orientacion_id">
                                    
                                    <option value="" disabled selected>-</option>
                                    <option v-for="orientacion in orientaciones" :key="orientacion.id" :value="orientacion.id">{{ orientacion.nombre }}</option>

                                </select>
                                
                                <info>
                                    <template #info>
                                        No es obligatorio. Puede crear cursos sin tener que seleccionar una orientación.
                                    </template>
                                </info>
                            </div>
                        </div>

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        Curso
                                    </template>
                                </label-form>
                                
                                <select
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.curso_id">
                                    
                                    <option value="" disabled selected>-</option>
                                    <option v-for="curso in cursos" :key="curso.id" :value="curso.id">{{ curso.nombre }}</option>

                                </select>
                                
                                <info>
                                    <template #info>
                                        Es obligatorio.
                                    </template>
                                </info>
                            </div>

                            <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Periodo de evaluación
                                    </template>
                                </label-form>
                                
                                <select
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.periodo_id">
                                    
                                    <option value="" disabled selected>-</option>
                                    <option v-for="periodo in periodos" :key="periodo.id" :value="periodo.id">{{ periodo.nombre }}</option>

                                </select>
                                
                                <info>
                                    <template #info>
                                        Es obligatorio.
                                    </template>
                                </info>
                            </div>

                            <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        Forma de evaluación
                                    </template>
                                </label-form>
                                
                                <select
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.forma_evaluacion_id">
                                    
                                    <option value="" disabled selected>-</option>
                                    <option v-for="formaEvaluacion in formasEvaluacion" :key="formaEvaluacion.id" :value="formaEvaluacion.id">{{ formaEvaluacion.nombre }}</option>

                                </select>
                                
                                <info>
                                    <template #info>
                                        Es obligatorio.
                                    </template>
                                </info>
                            </div>
                        </div>

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3">
                                <label-form>
                                    <template #label-value>
                                        División
                                    </template>
                                </label-form>
                                
                                <input-form required type="text" v-model="form.division" placeholder="EJ: A, B, C, D" />
                                
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
                                        Clave de acceso
                                    </template>
                                </label-form>
                                
                                <input-form type="password" v-model="form.claveDeAcceso" />
                                
                                <info>
                                    <template #info>
                                        Es obligatoria solo si desea cambiarla y debe tener entre 8 y 32 caracteres. Es la clave que deberan ingresar los alumnos para poder anotarse en la división.
                                    </template>
                                </info>
                            </div>

                            <div class="md:w-1/2 px-3">
                                
                                <label-form>
                                    <template #label-value>
                                        Confirmar clave de acceso
                                    </template>
                                </label-form>
                                
                                <input-form type="password" v-model="form.claveDeAcceso_confirmation" />
                                
                                <info>
                                    <template #info>
                                        Vuelva a ingresar la clave de acceso.
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
            niveles: Array,
            orientaciones: Array,
            cursos: Array,
            periodos: Array,
            division: Object,
            formasEvaluacion: Array,
        },

        title: 'Editar division',

        data() {
            return {
                form: {
                    nivel_id: this.division.nivel_id,
                    orientacion_id: this.division.orientacion_id,
                    curso_id: this.division.curso_id,
                    periodo_id: this.division.periodo_id,
                    forma_evaluacion_id: this.division.forma_evaluacion_id,
                    division: this.division.division,
                    claveDeAcceso: null,
                    claveDeAcceso_confirmation: null,
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.put(this.route('divisiones.update', [this.institucion_id, this.division.id]), this.form)
            },
        },
    }
</script>
