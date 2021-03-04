<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('roles.index', institucion_id)">Roles</inertia-link> /
                <inertia-link class="hover:underline" :href="route('alumnos.index', institucion_id)">Alumnos</inertia-link> /
                <inertia-link class="hover:underline" :href="route('alumnos.show', [institucion_id, alumno.id])">{{ alumno.name }}</inertia-link> /
                <inertia-link class="hover:underline" :href="route('asignaturas-adeudadas.index', [institucion_id, alumno.id])">
                    Asignatura adeudadas y/o ya rendidas
                </inertia-link> / Agregar asignaturas
            </span>
        </template>

        <div class="py-6">
            <estructura-form>
                <template #formulario>
                    <form method="post">
                        
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        División
                                    </template>
                                </label-form>
                                
                                <select
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                 @change="onChange()"
                                v-model="form.division_id">
                                    
                                    <option value="" disabled selected>-</option>
                                    <option v-for="division in divisiones" :key="division.id" :value="division.id">
                                        <span v-if="division.orientacion_nombre">
                                            {{ division.nivel_nombre }} - {{ division.orientacion_nombre }} - {{ division.curso_nombre }} - {{ division.division }}
                                        </span>

                                        <span v-else>
                                            {{ division.nivel_nombre }} - {{ division.curso_nombre }} - {{ division.division }}
                                        </span>
                                    </option>

                                </select>
                                
                                <info>
                                    <template #info>
                                        Seleccione la división donde se encuentren las asignaturas que desee agregar.
                                    </template>
                                </info>
                            </div>
                        </div>
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

    export default {
        components: {
            AppLayout,
            EstructuraForm,
            LabelForm,
            Info,
        },

        props: {
            institucion_id: String,
            alumno: Object,
            divisiones: Array,
        },

        title: 'Adeudar asignaturas - Seleccionar division',

        data() {
            return {
                form: {
                    division_id: null,
                },
            }
        },

        methods: {
            onChange() {
                this.$inertia.get(this.route('asignaturas-adeudadas.createAsignatura', [this.institucion_id, this.alumno.id, this.form.division_id]))
            },
        },
    }
</script>
