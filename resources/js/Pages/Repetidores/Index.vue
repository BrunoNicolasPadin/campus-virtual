<template>
    <app-layout>
        <template #header>
            <div class="flex">
                <div class="w-8/12">
                    <span class="font-semibold text-md text-gray-800 leading-tight">
                        Repetidores
                    </span>
                </div>
                <div class="w-4/12">
                    <primary class="float-right">
                        <template #boton-primary>
                            <inertia-link :href="route('repetidores.estadisticas', institucion_id)">Numeros</inertia-link>
                        </template>
                    </primary>
                </div>
            </div>
        </template>

        <transition name="fade">
            <div v-if="successMessage" class="bg-green-200 px-6 py-4 mx-2 my-4 rounded-md text-lg flex items-center container mx-auto w-full">
                <div class="w-1/12">
                    <svg viewBox="0 0 24 24" class="text-green-600 w-5 h-5 sm:w-5 sm:h-5 mr-3">
                        <path fill="currentColor" d="M12,0A12,12,0,1,0,24,12,12.014,12.014,0,0,0,12,0Zm6.927,8.2-6.845,9.289a1.011,1.011,0,0,1-1.43.188L5.764,13.769a1,1,0,1,1,1.25-1.562l4.076,3.261,6.227-8.451A1,1,0,1,1,18.927,8.2Z">

                        </path>
                    </svg>
                </div>
                <div class="w-9/12">
                    <span class="text-green-800 float-left">{{ successMessage }} </span>
                </div>
                <div class="w-2/12">
                    <span class="text-black font-bold float-right text-2xl cursor-pointer" @click="cerrarAlerta()">&times;</span> 
                </div>
            </div>
        </transition>

        <div class="py-12">

            <estructura-form>
                <template #formulario>
                    <form method="post" @submit.prevent="submit">
                        
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                
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

                                    <option selected value="">Todos</option>
                                    <option v-for="cicloLectivo in ciclosLectivos" :key="cicloLectivo.id" :value="cicloLectivo.id">
                                        {{ cicloLectivo.comienzo }} - {{ cicloLectivo.final }}
                                    </option>

                                </select>
                            </div>

                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        Seleccione division:
                                    </template>
                                </label-form>
                                
                                <select
                                @change="onChange()"
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.division_id">

                                    <option selected value="">Todas</option>
                                    <option v-for="division in divisiones" :key="division.id" :value="division.id">
                                        <span v-if="division.orientacion">
                                            {{ division.nivel.nombre }} - {{ division.orientacion.nombre }} - {{ division.curso.nombre }} - {{ division.division }}
                                        </span>

                                        <span v-else>
                                            {{ division.nivel.nombre }} - {{ division.curso.nombre }} - {{ division.division }}
                                        </span>
                                    </option>

                                </select>
                            </div>
                        </div>
                    </form>
                </template>
            </estructura-form>

            <estructura-tabla>
                <template #tabla>

                    <table-head-estructura>
                        <template #th>

                            <table-head>
                                <template #th-titulo>
                                    #
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Nombre
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Division
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Ciclo lectivo
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Comentario
                                </template>
                            </table-head>

                            <table-head colspan="2">
                                <template #th-titulo>
                                    Acciones
                                </template>
                            </table-head>

                        </template>
                    </table-head-estructura>

                    <table-body>
                        <template #tr>
                            
                            <tr v-for="(repetidor, index) in repetidores.data" :key="repetidor.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link :href="route('alumnos.show', [institucion_id, repetidor.alumno_id])" class="hover:underline">
                                            {{ repetidor.alumno.user.name }}
                                        </inertia-link>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <span v-if="repetidor.division.orientacion">
                                            <inertia-link class="hover:underline" :href="route('divisiones.show', [institucion_id, repetidor.division_id])">
                                                {{ repetidor.division.nivel.nombre }} - {{ repetidor.division.orientacion.nombre }} - 
                                                {{ repetidor.division.curso.nombre }} - {{ repetidor.division.division }}
                                            </inertia-link>
                                        </span>

                                        <span v-else>
                                            <inertia-link class="hover:underline" :href="route('divisiones.show', [institucion_id, repetidor.division_id])">
                                                {{ repetidor.division.nivel.nombre }} - {{ repetidor.division.orientacion.nombre }} - 
                                                {{ repetidor.division.curso.nombre }} - {{ repetidor.division.division }}
                                            </inertia-link>
                                        </span>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ repetidor.comienzo }} - {{ repetidor.final }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ repetidor.comentario }}
                                    </template>
                                </table-data>


                                <table-data>
                                    <template #td>
                                        <inertia-link :href="route('repetidores.edit', [institucion_id, repetidor.id])">
                                            <editar></editar>
                                        </inertia-link>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <button @click="destroy(repetidor.id)" type="submit" class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
                                            Eliminar
                                        </button>
                                    </template>
                                </table-data>
                            </tr>
                        </template>
                    </table-body>
                </template>
            </estructura-tabla>

            <div class="container mx-auto px-4 sm:px-8 my-6">
                <pagination :links="repetidores.links" />
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import EstructuraTabla from '@/Tabla/EstructuraTabla'
    import TableHeadEstructura from '@/Tabla/TableHeadEstructura'
    import TableHead from '@/Tabla/TableHead'
    import TableBody from '@/Tabla/TableBody'
    import TableData from '@/Tabla/TableData'
    import Eliminar from '@/Botones/Eliminar'
    import Pagination from '@/Pagination/Pagination.vue'
    import Editar from '@/Botones/Editar.vue'
    import EstructuraForm from '@/Formulario/EstructuraForm.vue'
    import LabelForm from '@/Formulario/LabelForm.vue'
    import Primary from '@/Botones/Primary.vue'

    export default {
        components: {
            AppLayout,
            EstructuraTabla,
            TableHeadEstructura,
            TableHead,
            TableBody,
            TableData,
            Eliminar,
            Pagination,
            Editar,
            EstructuraForm,
            LabelForm,
            Primary,
        },

        props:{ 
            successMessage: String,
            institucion_id: String,
            repetidores: Object,
            ciclosLectivos:  Array,
            divisiones: Array,
        },

        title: 'Repetidores',

        data() {
            return {
                form: {
                    ciclo_lectivo_id: null,
                    division_id: null,
                },
            }
        },

        methods: {
            destroy(id) {
                if (confirm('Estas seguro de que desea eliminar a este repetidor?')) {
                    this.$inertia.delete(this.route('repetidores.destroy', [this.institucion_id, id]))
                }
            },
            
            cerrarAlerta() {
                this.successMessage = false;
            },

            onChange() {
                this.$inertia.post(this.route('repetidores.filtrar', this.institucion_id), this.form)
            },
            
        }
    }
</script>
