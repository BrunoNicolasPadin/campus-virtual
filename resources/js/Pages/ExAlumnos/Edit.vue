<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('roles.index', institucion_id)">Roles</inertia-link> / 
                <inertia-link class="hover:underline" :href="route('exalumnos.index', institucion_id)">Ex alumnos</inertia-link> /
                <inertia-link class="hover:underline" :href="route('alumnos.show', [institucion_id, exAlumno.alumno.id])">{{ exAlumno.alumno.user.name }}</inertia-link> /
                Editar
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

                                    <option selected value="">Todos</option>
                                    <option v-for="cicloLectivo in ciclosLectivos" :key="cicloLectivo.id" :value="cicloLectivo.id">
                                        {{ cicloLectivo.comienzo }} - {{ cicloLectivo.final }}
                                    </option>

                                </select>
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
                                        No es obligatorio
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
            exAlumno: Object,
            ciclosLectivos: Array,
        },

        title: 'Editar ex alumno',

        data() {
            return {
                form: {
                    ciclo_lectivo_id: this.exAlumno.ciclo_lectivo_id,
                    comentario: this.exAlumno.comentario,
                    abandono: this.exAlumno.abandono,
                    finalizo: this.exAlumno.finalizo,
                    cambio: this.exAlumno.cambio,
                    debeRendir: this.exAlumno.debeRendir,
                },
                condicion: null,
            }
        },

        created() {
            if (this.form.abandono) {
                this.condicion = 'abandono';
            }

            if (this.form.finalizo) {
                this.condicion = 'finalizo';
            }

            if (this.form.cambio) {
                this.condicion = 'cambio';
            }

            if (this.form.debeRendir) {
                this.condicion = 'debeRendir';
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

                this.$inertia.put(this.route('exalumnos.update', [this.institucion_id, this.exAlumno.id]), this.form)
            },
        },
    }
</script>
