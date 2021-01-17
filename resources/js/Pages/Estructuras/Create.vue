<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <inertia-link :href="route('divisiones.index', institucion_id)">Estructura</inertia-link>
                 > Armar estructura
            </h2>
        </template>

        <div class="py-12">

            <!-- Errors Messages -->

            <transition name="fade">
                <div v-if="Object.keys(errors).length > 0" class="bg-red-200 px-6 py-4 mx-2 my-4 rounded-md text-lg flex items-center container mx-auto w-full">
                    <div class="w-1/12">
                        <svg viewBox="0 0 24 24" class="text-red-600 w-5 h-5 sm:w-5 sm:h-5 mr-3">
                            <path fill="currentColor" d="M11.983,0a12.206,12.206,0,0,0-8.51,3.653A11.8,11.8,0,0,0,0,12.207,11.779,11.779,0,0,0,11.8,24h.214A12.111,12.111,0,0,0,24,11.791h0A11.766,11.766,0,0,0,11.983,0ZM10.5,16.542a1.476,1.476,0,0,1,1.449-1.53h.027a1.527,1.527,0,0,1,1.523,1.47,1.475,1.475,0,0,1-1.449,1.53h-.027A1.529,1.529,0,0,1,10.5,16.542ZM11,12.5v-6a1,1,0,0,1,2,0v6a1,1,0,1,1-2,0Z"
                            ></path>
                        </svg>
                    </div>
                    <div class="w-9/12">
                        <span class="text-red-800"> {{ errors[Object.keys(errors)[0]][0] }} </span>
                    </div>
                    <div class="w-2/12">
                        <span class="text-black font-bold float-right text-2xl cursor-pointer" @click="cerrarAlerta()">&times;</span> 
                    </div>
                </div>
            </transition>

            <!-- Success Message -->

            <transition name="fade">
                <div v-if="successMessage" class="bg-green-200 px-6 py-4 mx-2 my-4 rounded-md text-lg flex items-center container mx-auto w-full">
                    <div class="w-1/12">
                        <svg viewBox="0 0 24 24" class="text-green-600 w-5 h-5 sm:w-5 sm:h-5 mr-3">
                            <path fill="currentColor" d="M12,0A12,12,0,1,0,24,12,12.014,12.014,0,0,0,12,0Zm6.927,8.2-6.845,9.289a1.011,1.011,0,0,1-1.43.188L5.764,13.769a1,1,0,1,1,1.25-1.562l4.076,3.261,6.227-8.451A1,1,0,1,1,18.927,8.2Z">

                            </path>
                        </svg>
                    </div>
                    <div class="w-9/12">
                        <span class="text-green-800 float-left">{{ successMessage }} </span>
                    </div>
                    <div class="w-2/12">
                        <span class="text-black font-bold float-right text-2xl cursor-pointer" @click="cerrarAlerta()">&times;</span> 
                    </div>
                </div>
            </transition>

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
                                        Es obligatorio
                                    </template>
                                </info>
                            </div>

                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        Orientacion
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
                                        No es obligatorio. Puede crear cursos sin tener que seleccionar una orientacion.
                                    </template>
                                </info>
                            </div>
                        </div>

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                
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
                                        Es obligatorio
                                    </template>
                                </info>
                            </div>

                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        Periodo de evaluacion
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
                                        Es obligatorio
                                    </template>
                                </info>
                            </div>
                        </div>

                        <div v-for="(div, index) in form.divisiones" :key="index">
                            <div class="-mx-3 md:flex mb-6">
                                <div class="md:w-10/12 px-3">
                                    <label-form>
                                        <template #label-value>
                                            Division
                                        </template>
                                    </label-form>
                                    
                                    <input-form required type="text" v-model="div.division" placeholder="EJ: A, a, b, c, B" />
                                    
                                    <info>
                                        <template #info>
                                            Es obligatorio
                                        </template>
                                    </info>
                                </div>

                                <div class="md:w-2/12 px-3 mb-6 md:mb-0">
                                    <button 
                                    @click="eliminarOtraDivision(index)"
                                    type="button" 
                                    class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 my-8 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
                                        Eliminar division
                                    </button>
                                </div>
                            </div>

                            <div class="-mx-3 md:flex mb-6">
                                <div class="md:w-1/2 px-3">
                                    <label-form>
                                        <template #label-value>
                                            Clave de acceso.
                                        </template>
                                    </label-form>

                                    <input-form required type="password" v-model="div.claveDeAcceso" />
                                    
                                    <info>
                                        <template #info>
                                            Es obligatorio y debe tener como minimo 8 caracteres y como maximo 32.
                                        </template>
                                    </info>
                                </div>

                                <div class="md:w-1/2 px-3">
                                    <label-form>
                                        <template #label-value>
                                            Repetir clave de acceso para confirmar.
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
                                    Agregar otra division
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
            errors: Object,
            successMessage: String,
            institucion_id: String,
            niveles: Array,
            orientaciones: Array,
            cursos: Array,
            periodos: Array,
        },

        data() {
            return {
                form: {
                    nivel_id: null,
                    orientacion_id: null,
                    curso_id: null,
                    periodo_id: null,
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
            }
        },
    }
</script>
