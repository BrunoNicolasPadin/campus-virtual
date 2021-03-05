<template>
    <div class="h-screen bg-blue-50 py-5">
        <div class="text-center">
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Registrarse
            </p>
        </div>
        <div class="pt-6 pb-8 px-4 sm:px-8 my-2 mb-4">
            <!-- Errors Messages -->

            <transition name="fade">
                <div v-if="Object.keys(errors).length > 0 && mostrarErrores" class="bg-red-200 px-6 py-4 mx-2 my-4 rounded-md text-lg flex items-center container mx-auto w-full">
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

            <estructura-form>
                <template #formulario>
                    <form method="post" @submit.prevent="submit">
                        
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Nombre
                                    </template>
                                </label-form>
                                
                                <input-form required type="text" v-model="form.nombre" autofocus />
                                
                                <info>
                                    <template #info>
                                        Es obligatorio.
                                    </template>
                                </info>
                            </div>

                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Tipo de cuenta
                                    </template>
                                </label-form>
                                
                                <select required v-model="form.tipo" class="form-select mt-1 block w-full">
                                    <option value="" disabled>-</option>
                                    <option value="Institucion">Institución</option>
                                    <option value="Persona">Persona</option>
                                </select>

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
                                        Email
                                    </template>
                                </label-form>
                                
                                <input-form required type="email" v-model="form.email" />
                                
                                <info>
                                    <template #info>
                                        Es obligatorio.
                                    </template>
                                </info>
                            </div>

                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        Confirmar email
                                    </template>
                                </label-form>
                                
                                <input-form required type="text" v-model="form.email_confirmation" />
                                
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
                                        Contraseña
                                    </template>
                                </label-form>
                                
                                <input-form required type="password" v-model="form.clave" />
                                
                                <info>
                                    <template #info>
                                        Es obligatorio.
                                    </template>
                                </info>
                            </div>

                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        Confirmar contraseña
                                    </template>
                                </label-form>
                                
                                <input-form required type="password" v-model="form.clave_confirmation" />
                                
                                <info>
                                    <template #info>
                                        Es obligatorio.
                                    </template>
                                </info>
                            </div>
                        </div>

                        <div class="flex items-center mt-4">
                            <inertia-link class="w-2/12 underline text-sm text-gray-600 hover:text-gray-900" :href="route('login.formulario')">
                                ¿Ya estás registrado?
                            </inertia-link>

                            <div class="ml-2 w-10/12">
                                <button type="submit" class="border border-indigo-500 bg-indigo-500 text-white rounded-full px-4 py-2 transition duration-500 ease select-none hover:bg-indigo-700 focus:outline-none focus:shadow-outline">
                                    Registrarse
                                </button>
                            </div>
                        </div>
                    </form>
                </template>
            </estructura-form>
        </div>
    </div>
</template>

<script>
    import EstructuraForm from '@/Formulario/EstructuraForm.vue'
    import LabelForm from '@/Formulario/LabelForm.vue'
    import InputForm from '@/Formulario/InputForm.vue'
    import Info from '@/Formulario/Info.vue'

    export default {
        components: {
            EstructuraForm,
            LabelForm,
            InputForm,
            Info,
        },

        props: {
            errors: Object,
        },

        title: 'Ingresar',

        data() {
            return {
                form: {
                    nombre: null,
                    email: null,
                    email_confirmation: null,
                    clave: null,
                    clave_confirmation: null,
                    tipo: null,
                },
                mostrarErrores: true,
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('register'), this.form)
            },

            cerrarAlerta() {
                this.mostrarErrores = false;
            }
        },
    }
</script>
