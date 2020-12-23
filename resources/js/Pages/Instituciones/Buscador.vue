<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Buscador
            </h2>
        </template>

        <div class="container mx-auto py-2 px-4 sm:px-8">
            <div class="block relative">
                <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current text-gray-500">
                        <path
                            d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z">
                        </path>
                    </svg>
                </span>
                <input placeholder="Search"
                    class="appearance-none rounded-r rounded-l sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" 
                    v-model="nombre"
                    @keyup="buscar()"
                />
            </div>
        </div>

        <div class="py-2">

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
                                    Pais
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Provincia
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Ciudad
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Direccion
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
                            
                            <tr v-for="(user, index) in usuarios" :key="user.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ user.name }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        -
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ user.pais }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ user.provincia }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ user.ciudad }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ user.direccion }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link :href="route('roles.index', user.instituciones)" class="cursor-pointer hover:underline">
                                            Anotarme
                                        </inertia-link>
                                    </template>
                                </table-data>
                            </tr>
                        </template>
                    </table-body>
                    

                </template>
            </estructura-tabla>
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

    export default {
        components: {
            AppLayout,
            EstructuraTabla,
            TableHeadEstructura,
            TableHead,
            TableBody,
            TableData,
        },

        props:{ 
            usuarios: Array,
        },

        data() {
            return {
                nombre: ''
            }
        },

        methods: {
            buscar() {
                this.$inertia.replace(this.route('buscador-de-instituciones', {nombre: this.nombre}))
            }
        }
    }
</script>
