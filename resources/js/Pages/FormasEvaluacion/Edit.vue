<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('instituciones.show', institucion_id)">Perfil institucional</inertia-link> /
                <inertia-link class="hover:underline" :href="route('formas-evaluacion.index', institucion_id)">Formas de evaluación</inertia-link> / 
                Editar {{ formaEvaluacion.nombre }}
            </h2>
        </template>

        <div class="py-6">

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
                                
                                <input-form required type="text" v-model="form.nombre" />
                                
                                <info>
                                    <template #info>
                                        Es obligatorio.
                                    </template>
                                </info>
                            </div>

                            <div class="md:w-1/2 px-3">
                                
                                <label-form>
                                    <template #label-value>
                                        Tipo
                                    </template>
                                </label-form>
                                
                                <select
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                @change="onChange()"
                                v-model="form.tipo">
                                    
                                    <option value="" disabled selected>-</option>
                                    <option value="Numerica">Numerica</option>
                                    <option value="Porcentual">Porcentual</option>
                                    <option value="Escrita">Escrita</option>

                                </select>
                                
                                <info>
                                    <template #info>
                                        Es obligatorio.
                                    </template>
                                </info>
                            </div>
                        </div>

                        <div v-show="mostrar" class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        ¿Desde que valor un alumno esta aprobado? EJ: 60, 6 o 7, etc...
                                    </template>
                                </label-form>
                                
                                <input-form required type="text" v-model="form.desdeCuando" />
                                
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
    import Info from '@/Formulario/Info.vue'
    import Guardar from '@/Botones/Guardar.vue'
    import InputForm from '@/Formulario/InputForm.vue'

    export default {
        components: {
            AppLayout,
            EstructuraForm,
            LabelForm,
            Info,
            Guardar,
            InputForm,
        },

        props: {
            institucion_id: String,
            formaEvaluacion: Object,
        },

        title: 'Editar forma de evaluación',

        data() {
            return {
                form: {
                    nombre: this.formaEvaluacion.nombre,
                    tipo: this.formaEvaluacion.tipo,
                    desdeCuando: this.formaEvaluacion.desdeCuando,
                },
                mostrar: false,
            }
        },

        created() {
            if (this.form.tipo == 'Numerica' || this.form.tipo == 'Porcentual') {
                return this.mostrar = true;
            }
        },

        methods: {
            submit() {
                this.$inertia.put(this.route('formas-evaluacion.update', [this.institucion_id, this.formaEvaluacion.id]), this.form)
            },

            onChange() {
                if (this.form.tipo == 'Numerica' || this.form.tipo == 'Porcentual') {
                    this.form.desdeCuando = this.formaEvaluacion.desdeCuando;
                    return this.mostrar = true;
                }
                this.form.desdeCuando = false;
                return this.mostrar = false;
            },
        },
    }
</script>
