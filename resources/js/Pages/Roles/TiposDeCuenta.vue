<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tipos de cuentas
            </h2>
        </template>

        <div class="py-6">

            <!-- Success Message -->

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

            <div v-if="directivos">   
                <h2 class="container mx-auto px-4 sm:px-8 text-2xl font-semibold leading-tight">Directivos (Activar para eliminar)</h2>
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
                                        Institucion
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
                                <tr v-for="(directivo, index) in directivos" :key="directivo.id">
                                    <table-data>
                                        <template #td>
                                            {{ index + 1 }}
                                        </template>
                                    </table-data>

                                    <table-data>
                                        <template #td>
                                            {{ directivo.institucion.user.name }}
                                        </template>
                                    </table-data>

                                    <table-data>
                                        <template #td>
                                            <button v-if="directivo.activado" type="button" class="border border-green-500 bg-green-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-700 focus:outline-none focus:shadow-outline">
                                                Activado
                                            </button>

                                            <button v-else @click="activarDirectivo(directivo.id)" type="button" class="border border-green-500 bg-green-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-700 focus:outline-none focus:shadow-outline">
                                                Activar
                                            </button>
                                        </template>
                                    </table-data>

                                    <table-data>
                                        <template #td>
                                            <button @click="destroyDirectivo(directivo.id)" type="submit" class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
                                                Eliminar
                                            </button>
                                        </template>
                                    </table-data>
                                </tr>
                            </template>
                        </table-body>
                    </template>
                </estructura-tabla>
            </div>

            <div v-if="docentes">   
                <h2 class="container mx-auto px-4 sm:px-8 text-2xl font-semibold leading-tight">Docentes (Activar para eliminar)</h2>
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
                                        Institucion
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
                                <tr v-for="(docente, index) in docentes" :key="docente.id">
                                    <table-data>
                                        <template #td>
                                            {{ index + 1 }}
                                        </template>
                                    </table-data>

                                    <table-data>
                                        <template #td>
                                            {{ docente.institucion.user.name }}
                                        </template>
                                    </table-data>

                                    <table-data>
                                        <template #td>
                                            <button v-if="docente.activado" type="button" class="border border-green-500 bg-green-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-700 focus:outline-none focus:shadow-outline">
                                                Activado
                                            </button>

                                            <button v-else @click="activarDocente(docente.id)" type="button" class="border border-green-500 bg-green-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-700 focus:outline-none focus:shadow-outline">
                                                Activar
                                            </button>
                                        </template>
                                    </table-data>

                                    <table-data>
                                        <template #td>
                                            <button @click="destroyDocente(docente.id)" type="submit" class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
                                                Eliminar
                                            </button>
                                        </template>
                                    </table-data>
                                </tr>
                            </template>
                        </table-body>
                    </template>
                </estructura-tabla>
            </div>

            <div v-if="alumnos">   
                <h2 class="container mx-auto px-4 sm:px-8 text-2xl font-semibold leading-tight">Alumnos (Activar para eliminar)</h2>
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
                                        Institucion
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
                                <tr v-for="(alumno, index) in alumnos" :key="alumno.id">
                                    <table-data>
                                        <template #td>
                                            {{ index + 1 }}
                                        </template>
                                    </table-data>

                                    <table-data>
                                        <template #td>
                                            {{ alumno.institucion.user.name }}
                                        </template>
                                    </table-data>

                                    <table-data>
                                        <template #td>
                                            <button v-if="alumno.activado" type="button" class="border border-green-500 bg-green-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-700 focus:outline-none focus:shadow-outline">
                                                Activado
                                            </button>

                                            <button v-else @click="activarAlumno(alumno.id)" type="button" class="border border-green-500 bg-green-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-700 focus:outline-none focus:shadow-outline">
                                                Activar
                                            </button>
                                        </template>
                                    </table-data>

                                    <table-data>
                                        <template #td>
                                            <button @click="destroyAlumno(alumno.id)" type="submit" class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
                                                Eliminar
                                            </button>
                                        </template>
                                    </table-data>
                                </tr>
                            </template>
                        </table-body>
                    </template>
                </estructura-tabla>
            </div>

            <div v-if="padres">   
                <h2 class="container mx-auto px-4 sm:px-8 text-2xl font-semibold leading-tight">Padres (Activar para eliminar)</h2>
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
                                        Hijo
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
                                <tr v-for="(padre, index) in padres" :key="padre.id">
                                    <table-data>
                                        <template #td>
                                            {{ index + 1 }}
                                        </template>
                                    </table-data>

                                    <table-data>
                                        <template #td>
                                            {{ padre.hijos.user.name }}
                                        </template>
                                    </table-data>

                                    <table-data>
                                        <template #td>
                                            <button v-if="padre.activado" type="button" class="border border-green-500 bg-green-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-700 focus:outline-none focus:shadow-outline">
                                                Activado
                                            </button>

                                            <button v-else @click="activarPadre(padre.id)" type="button" class="border border-green-500 bg-green-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-700 focus:outline-none focus:shadow-outline">
                                                Activar
                                            </button>
                                        </template>
                                    </table-data>

                                    <table-data>
                                        <template #td>
                                            <button @click="destroyPadre(padre.id)" type="submit" class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
                                                Eliminar
                                            </button>
                                        </template>
                                    </table-data>
                                </tr>
                            </template>
                        </table-body>
                    </template>
                </estructura-tabla>
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
            successMessage: String,
            institucion_id: String,
            directivos: Array,
            docentes: Array,
            alumnos: Array,
            padres: Array,
        },

        title: 'Tipos de cuenta',

         methods: {
            activarDocente(docente_id) {
                this.$inertia.get(this.route('roles.activarDocente', docente_id))
            },
            activarAlumno(docente_id) {
                this.$inertia.get(this.route('roles.activarAlumno', docente_id))
            },
            activarDirectivo(directivo_id) {
                this.$inertia.get(this.route('roles.activarDirectivo', directivo_id))
            },
            activarPadre(padre_id) {
                this.$inertia.get(this.route('roles.activarPadre', padre_id))
            },
            
            destroyDirectivo(id) {
                if (confirm('Estas seguro de que desea eliminar tu cuenta de directivo?')) {
                    this.$inertia.delete(this.route('directivos.destroy', [this.institucion_id, id]))
                }
            },

            destroyDocente(id) {
                if (confirm('Estas seguro de que desea eliminar tu cuenta de docente?')) {
                    this.$inertia.delete(this.route('docentes.destroy', [this.institucion_id, id]))
                }
            },

            destroyAlumno(id) {
                if (confirm('Estas seguro de que desea eliminar tu cuenta de alumno?')) {
                    this.$inertia.delete(this.route('alumnos.destroy', [this.institucion_id, id]))
                }
            },

            destroyPadre(id) {
                if (confirm('Estas seguro de que desea eliminar tu cuenta de padre?')) {
                    this.$inertia.delete(this.route('padres.destroy', [this.institucion_id, id]))
                }
            },

            cerrarAlerta() {
                this.successMessage = false;
            }
        },
    }
</script>
