<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('divisiones.index', institucion_id)">Estructura</inertia-link> /
                <inertia-link class="hover:underline" :href="route('divisiones.show', [institucion_id, division.id])">
                    <span v-if="division.orientacion_nombre">{{ division.nivel_nombre }} - {{ division.orientacion_nombre }} - {{ division.curso_nombre }} - {{ division.division }}</span>
                    <span v-else>{{ division.nivel_nombre }} - {{ division.curso_nombre }} - {{ division.division }}</span>
                </inertia-link> / 
                <inertia-link class="hover:underline" :href="route('asignaturas.index', [institucion_id, division.id])">Asignaturas</inertia-link> /
                Agregar
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
                                        Nombre
                                    </template>
                                </label-form>
                                
                                <input-form required type="text" v-model="form.nombre" />
                                
                                <info>
                                    <template #info>
                                        Es obligatorio.
                                    </template>
                                </info>
                            </div>
                        </div>

                        <div class="-mx-3 md:flex mb-6" v-for="(docenteForm, index) in form.docente" :key="docenteForm.index">
                            <div class="md:w-10/12 px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Docente
                                    </template>
                                </label-form>
                                
                                <select
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                v-model="docenteForm.docente_id">
                                    
                                    <option value="null" disabled selected>-</option>
                                    <option v-for="docente in docentes" :key="docente.id" :value="docente.id">{{ docente.name }}</option>

                                </select>
                                
                                <info>
                                    <template #info>
                                        No es obligatorio.
                                    </template>
                                </info>
                            </div>

                            <div class="md:w-2/12 px-3 mb-6 md:mb-0">
                                <button 
                                @click="eliminarOtroDocente(index)"
                                type="button" 
                                class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 my-8 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
                                    Eliminar docente
                                </button>
                            </div>
                        </div>

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                                <button 
                                @click="agregarOtroDocente()"
                                type="button" 
                                class="border border-gray-500 bg-gray-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-gray-700 focus:outline-none focus:shadow-outline">
                                    Agregar otro docente
                                </button>
                            </div>
                        </div>

                        <div v-for="(horario, index) in form.diaHorario" :key="horario.index" class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/4 px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Día
                                    </template>
                                </label-form>
                                
                                <select
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="horario.dia">
                                    
                                    <option value="" disabled selected>-</option>
                                    <option v-for="dia in dias" :key="dia.id" :value="dia">{{ dia }}</option>

                                </select>
                                
                                <info>
                                    <template #info>
                                        Es obligatorio.
                                    </template>
                                </info>
                            </div>

                            <div class="md:w-1/4 px-3 text-center">
                                
                                <label-form>
                                    <template #label-value>
                                        Hora desde
                                    </template>
                                </label-form>
                                
                                <vue-timepicker v-model="horario.horaDesde"></vue-timepicker>
                                
                                <info>
                                    <template #info>
                                        Es obligatorio.
                                    </template>
                                </info>
                            </div>

                            <div class="md:w-1/4 px-3 text-center">
                                
                                <label-form>
                                    <template #label-value>
                                        Hora hasta
                                    </template>
                                </label-form>
                                
                                <vue-timepicker v-model="horario.horaHasta"></vue-timepicker>
                                
                                <info>
                                    <template #info>
                                        Es obligatorio. 
                                    </template>
                                </info>
                            </div>

                            <div class="md:w-1/4 px-3 text-center">
                                <button 
                                @click="eliminarOtroDiaHora(index)"
                                type="button" 
                                class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 my-8 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
                                    Eliminar día y hora
                                </button>
                            </div>
                        </div>

                        <div class="-mx-3 md:flex mb-6 text-left">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                <button 
                                @click="agregarOtroDiaHora()"
                                type="button" 
                                class="border border-gray-500 bg-gray-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-gray-700 focus:outline-none focus:shadow-outline">
                                    Agregar otro dia y hora
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
    import VueTimepicker from 'vue2-timepicker'
    import 'vue2-timepicker/dist/VueTimepicker.css'

    export default {
        components: {
            AppLayout,
            EstructuraForm,
            LabelForm,
            InputForm,
            Info,
            Guardar,
            VueTimepicker,
        },

        props: {
            institucion_id: String,
            division: Object,
            dias: Array,
            docentes: Array,
        },

        title: 'Registrar asignatura',

        data() {
            return {
                form: {
                    nombre: null,
                    docente: [{
                        docente_id: null,
                    }],
                    diaHorario: [{
                        dia: null,
                        horaDesde: null,
                        horaHasta: null,
                    }],
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('asignaturas.store', [this.institucion_id, this.division.id]), this.form)
            },

            agregarOtroDiaHora() {
                this.form.diaHorario.push({
                    dia: null,
                    horaDesde: null,
                    horaHasta: null,
                });
            },


            eliminarOtroDiaHora(index) {
                this.form.diaHorario.splice(index, 1);
            },

            agregarOtroDocente() {
                this.form.docente.push({
                    docente_id: null,
                });
            },

            eliminarOtroDocente(index) {
                this.form.docente.splice(index, 1);
            },
        },
    }
</script>
