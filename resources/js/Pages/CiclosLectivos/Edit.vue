<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('ciclos-lectivos.index', institucion_id)">Ciclos lectivos</inertia-link> / 
                Editar ciclo lectivo
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
                                        Comienzo
                                    </template>
                                </label-form>
                                
                                <date-picker
                                required
                                valueType="format"
                                format="DD-MM-YYYY"
                                v-model="form.comienzo"
                                class="appearance-none block w-full bg-white text-black border border-red rounded py-3 px-4 mb-3"></date-picker>
                                
                                <info>
                                    <template #info>
                                        Es obligatorio.
                                    </template>
                                </info>
                            </div>

                            <div class="md:w-1/2 px-3">
                                
                                <label-form>
                                    <template #label-value>
                                        Final
                                    </template>
                                </label-form>
                                
                                <date-picker
                                required
                                valueType="format"
                                format="DD-MM-YYYY"
                                v-model="form.final"
                                class="appearance-none block w-full bg-white text-black border border-red rounded py-3 px-4 mb-3"></date-picker>
                                
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
                                        Activado
                                    </template>
                                </label-form>
                                
                                <input type="checkbox" v-model="form.activado" />
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
    import DatePicker from 'vue2-datepicker'
    import 'vue2-datepicker/index.css'
    import 'vue2-datepicker/locale/es'

    export default {
        components: {
            AppLayout,
            EstructuraForm,
            LabelForm,
            InputForm,
            Info,
            Guardar,
            DatePicker,
        },

        props: {
            institucion_id: String,
            cicloLectivo: Object,
        },

        title: 'Editar ciclo lectivo',

        data() {
            return {
                form: {
                    comienzo: this.cicloLectivo.comienzo,
                    final: this.cicloLectivo.final,
                    activado: this.cicloLectivo.activado,
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.put(this.route('ciclos-lectivos.update', [this.institucion_id, this.cicloLectivo.id]), this.form)
            },
        },
    }
</script>
