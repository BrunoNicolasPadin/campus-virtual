<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('divisiones.index', institucion_id)">Estructura</inertia-link> /
                Agregar divisiones
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

                        <div v-for="(div, index) in form.divisiones" :key="index">
                            <div class="-mx-3 md:flex mb-6">
                                <div class="md:w-10/12 px-3">
                                    <label-form>
                                        <template #label-value>
                                            División
                                        </template>
                                    </label-form>
                                    
                                    <input-form required type="text" v-model="div.division" placeholder="EJ: A, a, b, c, B" />
                                    
                                    <info>
                                        <template #info>
                                            Es obligatorio.
                                        </template>
                                    </info>
                                </div>

                                <div class="md:w-2/12 px-3 mb-6 md:mb-0">
                                    <button 
                                    @click="eliminarOtraDivision(index)"
                                    type="button" 
                                    class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 my-8 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
                                        Eliminar división
                                    </button>
                                </div>
                            </div>

                            <div class="-mx-3 md:flex mb-6">
                                <div class="md:w-1/2 px-3">
                                    <label-form>
                                        <template #label-value>
                                            Clave de acceso
                                        </template>
                                    </label-form>

                                    <input-form required type="password" v-model="div.claveDeAcceso" />
                                    
                                    <info>
                                        <template #info>
                                            Es obligatorio y debe tener como mínimo 8 caracteres y como máximo 32.
                                        </template>
                                    </info>
                                </div>

                                <div class="md:w-1/2 px-3">
                                    <label-form>
                                        <template #label-value>
                                            Repetir clave de acceso para confirmar
                                        </template>
                                    </label-form>

                                    <input-form required type="password" v-model="div.claveDeAccesoConfirmation" />
                                    
                                    <info>
                                        <template #info>
                                            Es obligatorio.
                                        </template>
                                    </info>
                                </div>
                            </div>
                        </div>

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                                <button 
                                @click="agregarOtraDivision()"
                                type="button" 
                                class="border border-gray-500 bg-gray-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-gray-700 focus:outline-none focus:shadow-outline">
                                    Agregar otra división
                                </button>
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
            formasEvaluacion: Array,
        },

        title: 'Registrar division',

        data() {
            return {
                form: {
                    nivel_id: null,
                    orientacion_id: null,
                    curso_id: null,
                    periodo_id: null,
                    forma_evaluacion_id: null,
                    divisiones: [{
                        division: null,
                        claveDeAcceso: null,
                        claveDeAccesoConfirmation: null,
                    }],
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('divisiones.store', this.institucion_id), this.form)
            },

            agregarOtraDivision() {
                this.form.divisiones.push({
                    division: null,
                    claveDeAcceso: null,
                    claveDeAccesoConfirmation: null,
                });
            },

            eliminarOtraDivision(index) {
                this.form.divisiones.splice(index, 1);
            },
        },
    }
</script>
