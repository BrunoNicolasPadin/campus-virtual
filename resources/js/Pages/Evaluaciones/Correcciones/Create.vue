<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <inertia-link :href="route('divisiones.index', institucion_id)">Estructura</inertia-link>
                 > 
                <inertia-link :href="route('divisiones.show', [institucion_id, division.id])">
                    <span v-if="division.orientacion">{{ division.nivel.nombre }} - {{ division.orientacion.nombre }} - {{ division.curso.nombre }} - {{ division.division }}</span>
                    <span v-else>{{ division.nivel.nombre }} - {{ division.curso.nombre }} - {{ division.division }}</span>
                </inertia-link>
                 > 
                <inertia-link :href="route('evaluaciones.index', [institucion_id, division.id])">Evaluaciones</inertia-link>
                 > 
                <inertia-link :href="route('evaluaciones.show', [institucion_id, division.id, evaluacion.id])">{{ evaluacion.titulo }}</inertia-link>
                 > 
                <inertia-link :href="route('entregas.index', [institucion_id, division.id, evaluacion.id])">Entregas</inertia-link>
                 > 
                <inertia-link :href="route('entregas.show', [institucion_id, division.id, evaluacion.id, entrega.id])">{{ entrega.alumno.user.name }}</inertia-link>
                 > Corregir {{ evaluacion.tipo }}
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

            <estructura-form>
                <template #formulario>
                    <form method="post" @submit.prevent="submit" enctype="multipart/form-data">
                        
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Archivo
                                    </template>
                                </label-form>
                                
                                <file-input v-model="form.archivo" type="file" />
                                
                                <info>
                                    <template #info>
                                        Es obligatorio. Solo puede subir de a uno.
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
    import FileInput from '@/Formulario/FileInput.vue'

    export default {
        components: {
            AppLayout,
            EstructuraForm,
            LabelForm,
            InputForm,
            Info,
            Guardar,
            FileInput,
        },
   
        props: {
            errors: Object,
            institucion_id: String,
            division: Object,
            evaluacion: Object,
            entrega: Object,
        },

        data() {
            return {
                form: {
                    archivo: null,
                },
            }
        },

        methods: {
            submit() {
                var data = new FormData();
                data.append('archivo', this.form.archivo);

                this.$inertia.post(this.route('correcciones.store', [this.institucion_id, this.division.id, this.evaluacion.id, this.entrega.id]), data)
            },
        }
    }
</script>
