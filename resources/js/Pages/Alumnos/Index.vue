<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('roles.index', institucion_id)">Roles</inertia-link> / Alumnos
            </span>
        </template>

        <buscador>
            <template #input-buscador>
                <input placeholder="Search"
                    class="appearance-none rounded-r rounded-l sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" 
                    v-model="nombre"
                    @keyup="buscar()"
                />
            </template>
        </buscador>

        <div class="py-6">

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
                                    Acciones
                                </template>
                            </table-head>

                        </template>
                    </table-head-estructura>

                    <table-body>
                        <template #tr>
                            
                            <tr v-for="(alumno, index) in alumnos.data" :key="alumno.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link :href="route('alumnos.show', [institucion_id, alumno.id])" class="hover:underline">
                                            {{ alumno.name }}
                                        </inertia-link>
                                    </template>
                                </table-data>

                                <table-data >
                                    <template #td v-if="alumno.foto">
                                        <img class="block m-auto p-auto h-20 w-20 object-cover" :src="'../../storage/' + alumno.foto "  alt="Foto de perfil" />
                                    </template>

                                    <template #td v-else>
                                        -
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <button @click="destroy(alumno.id)" type="submit" class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
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
                <pagination :links="alumnos.links" />
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
    import Buscador from '@/Buscador/Buscador.vue'

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
            Buscador,
        },

        props:{ 
            institucion_id: String,
            alumnos: Object,
            nombreProp: String,
        },

        title: 'Alumnos',

        data() {
            return {
                nombre: this.nombreProp,
            }
        },

        created() {
            this.nombre = this.nombreProp;
        },

        methods: {
            destroy(id) {
                if (confirm('Estas seguro de que desea eliminar a este alumno?')) {
                    this.$inertia.delete(this.route('alumnos.destroy', [this.institucion_id, id]))
                }
            },

            buscar() {
                if (this.nombre == '') {
                    this.$inertia.get(this.route('alumnos.index', this.institucion_id))
                } else {
                    this.$inertia.replace(this.route('buscador-de-alumnos', {institucion_id: this.institucion_id, nombre: this.nombre}))
                }
            }
        }
    }
</script>
