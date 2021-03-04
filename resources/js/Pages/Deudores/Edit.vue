<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('roles.index', institucion_id)">Roles</inertia-link> /
                <inertia-link class="hover:underline" :href="route('alumnos.index', institucion_id)">Alumnos</inertia-link> /
                <inertia-link class="hover:underline" :href="route('alumnos.show', [institucion_id, alumno.id])">{{ alumno.name }}</inertia-link> /
                <inertia-link class="hover:underline" :href="route('asignaturas-adeudadas.index', [institucion_id, alumno.id])">
                    Asignatura adeudadas y/o ya rendidas
                </inertia-link> / Editar
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
                                        Seleccionar ciclo lectivo
                                    </template>
                                </label-form>
                                
                                <select
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.ciclo_lectivo_id">
                                    
                                    <option value="" disabled selected>-</option>
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
                                        Seleccionar condición
                                    </template>
                                </label-form>
                                
                                <select
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.aprobado">
                                    
                                    <option value="" disabled selected>-</option>
                                    <option value="1">Aprobado</option>
                                    <option value="0">No aprobado</option>

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
            deuda: Object,
        },

        title: 'Adeudar asignaturas - Editar',

        data() {
            return {
                form: {
                    ciclo_lectivo_id: this.deuda.ciclo_lectivo_id,
                    aprobado: this.deuda.aprobado,
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.put(this.route('asignaturas-adeudadas.update', [this.institucion_id, this.alumno.id, this.deuda.id]), this.form)
            },
        },
    }
</script>
