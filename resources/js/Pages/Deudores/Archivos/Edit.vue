<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('mesas.show', [institucion_id, division.id, asignatura.id, mesa.id])">Mesa {{ mesa.fechaHoraRealizacion }} - {{ mesa.fechaHoraFinalizacion }}</inertia-link> / 
                Editar archivo
            </h2>
        </template>

        <div class="py-6">

            <estructura-form>
                <template #formulario>
                    <form method="post" @submit.prevent="submit" enctype="multipart/form-data">
                        
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Visibilidad
                                    </template>
                                </label-form>
                                
                                <select
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.visibilidad">
                                    
                                    <option value="" disabled selected>-</option>
                                    <option value="1">Si</option>
                                    <option value="0">No</option>

                                </select>
                                
                                <info>
                                    <template #info>
                                        Es obligatorio y se refiere a si el archivo lo pueden ver los alumnos o no.
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
            institucion_id: String,
            division_id: String,
            asignatura_id: String,
            mesa: Object,
            archivo: Object,
        },

        title: 'Editar visibilidad del archivo de una mesa',

        data() {
            return {
                form: {
                    visibilidad: this.archivo.visibilidad,
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.put(this.route('mesas-archivos.update', [this.institucion_id, this.division_id, this.asignatura_id, this.mesa.id, this.archivo.id]), this.form)
            },
        }
    }
</script>
