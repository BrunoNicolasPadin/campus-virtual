<template>
    <app-layout>
        <template #header>
            <div class="flex">
                <div class="w-8/12">
                    <span class="font-semibold text-md text-gray-800 leading-tight">
                        <inertia-link class="hover:underline" :href="route('roles.index', institucion_id)">Roles</inertia-link> / 
                        Ex alumnos
                    </span>
                </div>
                <div class="w-4/12">
                    <primary class="float-right">
                        <template #boton-primary>
                            <inertia-link :href="route('exalumnos.estadisticas', institucion_id)">Numeros</inertia-link>
                        </template>
                    </primary>
                </div>
            </div>
        </template>

        <div class="py-6">
            <estructura-form>
                <template #formulario>
                    <form>
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                                
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

                            <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        Seleccione una división:
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

                            <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        Seleccione una condición:
                                    </template>
                                </label-form>
                                
                                <select
                                @change="onChange()"
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.condicion">

                                    <option value="" selected>Todos</option>
                                    <option value="abandono">Abandonó</option>
                                    <option value="cambio">Cambió</option>
                                    <option value="finalizo">Finalizó</option>

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
                                    Ciclo lectivo
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    División
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Abandonó
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Finalizó
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Cambió
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
                            
                            <tr v-for="(exalumno, index) in exAlumnos.data" :key="exalumno.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link class="hover:underline" :href="route('alumnos.show', [institucion_id, exalumno.alumno_id])">
                                            {{ exalumno.name }}
                                        </inertia-link>
                                    </template>
                                </table-data>

                                <table-data >
                                    <template #td v-if="exalumno.fotoDePerfil">
                                        <img class="block m-auto p-auto h-20 w-20 object-cover" :src="'../../storage/' + exalumno.fotoDePerfil"  alt="Foto de perfil" />
                                    </template>

                                    <template #td v-else>
                                        -
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ exalumno.ciclo_lectivo }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                            <inertia-link class="hover:underline" :href="route('divisiones.show', [institucion_id, exalumno.division_id])">
                                                {{ exalumno.division }}
                                            </inertia-link>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <span v-if="exalumno.abandono">Si</span>
                                        <span v-else>No</span>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <span v-if="exalumno.finalizo">Si</span>
                                        <span v-else>No</span>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <span v-if="exalumno.cambio">Si</span>
                                        <span v-else>No</span>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link :href="route('exalumnos.edit', [institucion_id, exalumno.id])">
                                            <editar></editar>
                                        </inertia-link>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <button @click="destroy(exalumno.id)" type="submit" class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
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
                <pagination :links="exAlumnos.links" />
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
    import Primary from '@/Botones/Primary.vue'
    import EstructuraForm from '@/Formulario/EstructuraForm.vue'
    import LabelForm from '@/Formulario/LabelForm.vue'

    export default {
        components: {
            AppLayout,
            EstructuraForm,
            LabelForm,
            EstructuraTabla,
            TableHeadEstructura,
            TableHead,
            TableBody,
            TableData,
            Eliminar,
            Pagination,
            Editar,
            Primary,
        },

        props:{ 
            institucion_id: String,
            divisiones: Array,
            ciclosLectivos: Array,
            exAlumnos: Object,
            ciclo_lectivo_id_index: String,
            division_id_index: String,
            condicion_index: String,
        },

        title: 'Ex alumnos',

        data() {
            return {
                form: {
                    ciclo_lectivo_id: this.ciclo_lectivo_id_index,
                    division_id: this.division_id_index,
                    condicion: this.condicion_index,
                },
            }
        },

        methods: {
            destroy(id) {
                if (confirm('¿Estás seguro de que deseas eliminar este ex alumno?')) {
                    this.$inertia.delete(this.route('exalumnos.destroy', [this.institucion_id, id]))
                }
            },

            onChange() {
                /* axios.get(this.route('exalumnos.filtrar', this.institucion_id), this.form)
                .then(response => {
                    this.exAlumnos = response.data;
                })
                .catch(e => {
                    // Podemos mostrar los errores en la consola
                    console.log(e);
                }) */

                this.$inertia.replace(this.route('exalumnos.index', {institucion_id: this.institucion_id, ciclo_lectivo_id: this.form.ciclo_lectivo_id, division_id: this.form.division_id, condicion: this.form.condicion}))
            },
        }
    }
</script>
