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
                <inertia-link class="hover:underline" :href="route('mesas.index', [institucion_id, division.id, asignatura.id])">Mesas de {{ asignatura.nombre }}</inertia-link> / 
                <inertia-link class="hover:underline" :href="route('mesas.show', [institucion_id, division.id, asignatura.id, mesa.id])">Mesa {{ mesa.fechaHoraRealizacion }} - {{ mesa.fechaHoraFinalizacion }}</inertia-link> / 
                <inertia-link class="hover:underline" :href="route('anotados.show', [institucion_id, division.id, asignatura.id, mesa.id, anotado.id])">Entrega de {{ anotado.name }}</inertia-link> /
                Agregar archivo
            </span>
        </template>

        <div class="py-6">
            <estructura-form>
                <template #formulario>
                    <form method="post" @submit.prevent="submit" enctype="multipart/form-data">
                        <div v-for="(arc, index) in form.archivos" :key="index">
                            <div class="-mx-3 md:flex mb-6">
                                <div class="md:w-10/12 px-3 mb-6 md:mb-0">
                                    <label-form>
                                        <template #label-value>
                                            Archivo
                                        </template>
                                    </label-form>
                                    
                                    <file-input v-model="arc.archivo" type="file" />
                                    
                                    <info>
                                        <template #info>
                                            Es obligatorio. Solo puede subir de a uno.
                                        </template>
                                    </info>
                                </div>

                                <div class="md:w-2/12 px-3 mb-6 md:mb-0">
                                    <button 
                                    @click="eliminarArchivo(index)"
                                    type="button" 
                                    class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 my-8 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
                                        Eliminar formulario
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                                <button 
                                @click="agregarOtroArchivo()"
                                type="button" 
                                class="border border-gray-500 bg-gray-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-gray-700 focus:outline-none focus:shadow-outline">
                                    Agregar otro archivo
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
            division: Object,
            asignatura: Object,
            mesa: Object,
            anotado: Object,
        },

        title: 'Agregar entregas',

        data() {
            return {
                form: {
                    archivos: [{
                        archivo: null,
                    }],
                },
            }
        },

        methods: {
            submit() {
                var data = new FormData();
                var archivos = [];

                for (let i = 0; i < this.form.archivos.length; i++) {
                    data.append('archivos[]', this.form.archivos[i].archivo);
                }

                this.$inertia.post(this.route('rendir-entregas.store', [this.institucion_id, this.division.id, this.asignatura.id, this.mesa.id, this.anotado.id]), data)
            },

            agregarOtroArchivo() {
                this.form.archivos.push({
                    archivo: null,
                });
            },

            eliminarArchivo(index) {
                this.form.archivos.splice(index, 1);
            },
        }
    }
</script>
