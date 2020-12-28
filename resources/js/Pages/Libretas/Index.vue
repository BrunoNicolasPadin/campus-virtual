<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <inertia-link :href="route('alumnos.show', [institucion_id, alumno.id])">{{ alumno.user.name }}</inertia-link>
                 > Libreta
            </h2>
        </template>

        <div class="py-12">

            <estructura-form>
                <template #formulario>
                    <form method="post" @submit.prevent="submit">
                        
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        Seleccione ciclo lectivo:
                                    </template>
                                </label-form>
                                
                                <select
                                @change="onChange()"
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.ciclo_lectivo_id">

                                    <option disabled selected value="">-</option>
                                    <option v-for="cicloLectivo in ciclosLectivos" :key="cicloLectivo.id" :value="cicloLectivo.id">
                                        {{ cicloLectivo.comienzo }} - {{ cicloLectivo.final }}
                                    </option>

                                </select>
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

    export default {
        components: {
            AppLayout,
            EstructuraForm,
            LabelForm,
        },

        props:{ 
            successMessage: String,
            institucion_id: String,
            alumno: Object,
            ciclosLectivos: Array,
        },

        data() {
            return {
                form: {
                    ciclo_lectivo_id: null,
                },
            }
        },

        methods: {
            onChange() {
                this.$inertia.get(this.route('libretas.show', [this.institucion_id, this.alumno.id, this.form.ciclo_lectivo_id]))
            }
        }
    }
</script>
