<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('roles.index', institucion_id)">Roles</inertia-link> /
                <inertia-link class="hover:underline" :href="route('alumnos.index', institucion_id)">Alumnos</inertia-link> /
                <inertia-link class="hover:underline" :href="route('alumnos.show', [institucion_id, alumno.id])">{{ alumno.name }}</inertia-link> /
                Convertir
            </h2>
        </template>

        <div class="py-6">
            <estructura-form>
                <template #formulario>
                    <form method="post" @submit.prevent="submit">

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        Seleccione un ciclo lectivo:
                                    </template>
                                </label-form>
                                
                                <select
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.ciclo_lectivo_id">

                                    <option selected value="" disabled>-</option>
                                    <option v-for="cicloLectivo in ciclosLectivos" :key="cicloLectivo.id" :value="cicloLectivo.id">
                                        {{ cicloLectivo.comienzo }} - {{ cicloLectivo.final }}
                                    </option>

                                </select>

                                <info>
                                    <template #info>
                                        Es obligatorio.
                                    </template>
                                </info>
                            </div>
                        </div>
                        
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Comentario
                                    </template>
                                </label-form>
                                
                                <textarea
                                    class="appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                    cols="30" 
                                    rows="5" v-model="form.comentario"></textarea>
                                
                                <info>
                                    <template #info>
                                        No es obligatorio.
                                    </template>
                                </info>
                            </div>
                        </div>

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        Seleccionar la condición:
                                    </template>
                                </label-form>
                                
                                <select
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="condicion">

                                    <option selected value="" disabled>-</option>
                                    <option value="abandono">Abandonó el colegio</option>
                                    <option value="finalizo">Finalizó sus estudios</option>
                                    <option value="cambio">Se cambió de colegio</option>
                                    <option value="debeRendir">Le quedan asignaturas por rendir</option>

                                </select>

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

    export default {
        components: {
            AppLayout,
            EstructuraForm,
            LabelForm,
            Info,
            Guardar,
        },

        props: {
            institucion_id: String,
            alumno: Object,
            ciclosLectivos: Array,
        },

        title: 'Convertir en ex alumno',

        data() {
            return {
                form: {
                    alumno_id: this.alumno.id,
                    division_id: this.alumno.division_id,
                    ciclo_lectivo_id: null,
                    comentario: null,
                    abandono: false,
                    finalizo: false,
                    cambio: false,
                    debeRendir: false,
                },
                condicion: null,
            }
        },

        methods: {
            submit() {
                if (this.condicion == 'abandono') {
                   this.form.abandono = true;
                   this.form.finalizo = false;
                   this.form.cambio = false;
                   this.form.debeRendir = false;
                }

                if (this.condicion == 'finalizo') {
                   this.form.abandono = false;
                   this.form.finalizo = true;
                   this.form.cambio = false;
                   this.form.debeRendir = false;
                }

                if (this.condicion == 'cambio') {
                   this.form.abandono = false;
                   this.form.finalizo = false;
                   this.form.cambio = true;
                   this.form.debeRendir = false;
                }

                if (this.condicion == 'debeRendir') {
                   this.form.abandono = false;
                   this.form.finalizo = false;
                   this.form.cambio = true;
                   this.form.debeRendir = false;
                }
                this.$inertia.post(this.route('exalumnos.store', this.institucion_id), this.form)
            },
        },
    }
</script>
