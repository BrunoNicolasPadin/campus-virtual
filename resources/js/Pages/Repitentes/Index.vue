<template>
    <app-layout>
        <template #header>
            <div class="flex">
                <div class="w-8/12">
                    <span class="font-semibold text-md text-gray-800 leading-tight">
                        <inertia-link class="hover:underline" :href="route('roles.index', institucion_id)">Roles</inertia-link> / Repitentes
                    </span>
                </div>
                <div class="w-4/12">
                    <primary class="float-right">
                        <template #boton-primary>
                            <inertia-link :href="route('repitentes.estadisticas', institucion_id)">Numeros</inertia-link>
                        </template>
                    </primary>
                </div>
            </div>
        </template>

        <div class="py-6">

            <estructura-form>
                <template #formulario>
                    <form method="post" @submit.prevent="submit">
                        
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        Seleccione un ciclo lectivo:
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
                                        Seleccione una división
                                    </template>
                                </label-form>
                                
                                <select
                                @change="onChange()"
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.division_id">

                                    <option selected value="">Todas</option>
                                    <option v-for="division in divisiones" :key="division.id" :value="division.id">
                                        <span v-if="division.orientacion_nombre">
                                            {{ division.nivel_nombre }} - {{ division.orientacion_nombre }} - {{ division.curso_nombre }} - {{ division.division }}
                                        </span>

                                        <span v-else>
                                            {{ division.nivel_nombre }} - {{ division.curso_nombre }} - {{ division.division }}
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
                                    Foto de perfil
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    División
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
                            
                            <tr v-for="(repitente, index) in repitentes.data" :key="repitente.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link :href="route('alumnos.show', [institucion_id, repitente.alumno_id])" class="hover:underline">
                                            {{ repitente.name }}
                                        </inertia-link>
                                    </template>
                                </table-data>

                                <table-data >
                                    <template #td v-if="repitente.fotoDePerfil">
                                        <img class="block m-auto p-auto h-20 w-20 object-cover" :src="'../../storage/' + repitente.fotoDePerfil "  alt="Foto de perfil" />
                                    </template>

                                    <template #td v-else>
                                        -
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link class="hover:underline" :href="route('divisiones.show', [institucion_id, repitente.division_id])">
                                            {{ repitente.division }}
                                        </inertia-link>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ repitente.ciclo_lectivo }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ repitente.comentario }}
                                    </template>
                                </table-data>


                                <table-data>
                                    <template #td>
                                        <inertia-link :href="route('repitentes.edit', [institucion_id, repitente.id])">
                                            <editar></editar>
                                        </inertia-link>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <button @click="destroy(repitente.id)" type="submit" class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
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
                <pagination :links="repitentes.links" />
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
            institucion_id: String,
            ciclosLectivos: Array,
            divisiones: Array,
            repitentes: Object,
            ciclo_lectivo_id_index: String,
            division_id_index: String,
        },

        title: 'Repitentes',

        data() {
            return {
                form: {
                    ciclo_lectivo_id: this.ciclo_lectivo_id_index,
                    division_id: this.division_id_index,
                },
            }
        },

        methods: {
            destroy(id) {
                if (confirm('¿Estás seguro de que deseas eliminar a este repitente?')) {
                    this.$inertia.delete(this.route('repitentes.destroy', [this.institucion_id, id]))
                }
            },

            onChange() {
                this.$inertia.replace(this.route('repitentes.index', {institucion_id: this.institucion_id, ciclo_lectivo_id: this.form.ciclo_lectivo_id, division_id: this.form.division_id}))
            },
            
        }
    }
</script>
