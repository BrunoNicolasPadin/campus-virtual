<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-md text-gray-800 leading-tight">
                Tipos de cuentas
            </h2>
        </template>

        <div class="py-6">
            <div v-if="directivos">   
                <h2 class="container mx-auto px-4 sm:px-8 text-2xl font-semibold leading-tight">Directivos</h2>
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
                                        Institución
                                    </template>
                                </table-head>

                                <table-head colspan="3">
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
                                            <inertia-link class="hover:underline" :href="route('directivos.show', [directivo.institucion_id, directivo.id])">
                                                Ver perfil
                                            </inertia-link>
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
                                            <button @click="destroyDirectivo(directivo.institucion_id, directivo.id)" type="submit" class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
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
                <h2 class="container mx-auto px-4 sm:px-8 text-2xl font-semibold leading-tight">Docentes</h2>
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
                                        Institución
                                    </template>
                                </table-head>

                                <table-head colspan="3">
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
                                            <inertia-link class="hover:underline" :href="route('docentes.show', [docente.institucion_id, docente.id])">
                                                Ver tu perfil
                                            </inertia-link>
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
                                            <button @click="destroyDocente(docente.institucion_id, docente.id)" type="submit" class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
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
                <h2 class="container mx-auto px-4 sm:px-8 text-2xl font-semibold leading-tight">Alumnos</h2>
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
                                        Institución
                                    </template>
                                </table-head>

                                <table-head colspan="3">
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
                                            <inertia-link class="hover:underline" :href="route('alumnos.show', [alumno.institucion_id, alumno.id])">
                                                Ver tu perfil
                                            </inertia-link>
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
                                            <button @click="destroyAlumno(alumno.institucion_id, alumno.id)" type="submit" class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
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
                <h2 class="container mx-auto px-4 sm:px-8 text-2xl font-semibold leading-tight">Padres (Activar para ver lo mismo que su hijo/a)</h2>
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
                                        Hijo/a
                                    </template>
                                </table-head>

                                <table-head colspan="3">
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
                                            <inertia-link class="hover:underline" :href="route('alumnos.show', [padre.hijos.institucion_id, padre.hijos.id])">
                                                Ver perfil de {{ padre.hijos.user.name }}
                                            </inertia-link>
                                        </template>
                                    </table-data>

                                    <table-data>
                                        <template #td>
                                            <inertia-link class="hover:underline" :href="route('padres.show', [padre.hijos.institucion_id, padre.id])">
                                                Ver tu perfil
                                            </inertia-link>
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
                                            <button @click="destroyPadre(padre.hijos.institucion_id, padre.id)" type="submit" class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
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
            activarAlumno(alumno_id) {
                this.$inertia.get(this.route('roles.activarAlumno', alumno_id))
            },
            activarDirectivo(directivo_id) {
                this.$inertia.get(this.route('roles.activarDirectivo', directivo_id))
            },
            activarPadre(padre_id) {
                this.$inertia.get(this.route('roles.activarPadre', padre_id))
            },
            
            destroyDirectivo(institucion_id, id) {
                if (confirm('¿Estás seguro de que deseas eliminar tu cuenta como directivo?')) {
                    this.$inertia.delete(this.route('directivos.destroy', [institucion_id, id]))
                }
            },

            destroyDocente(institucion_id, id) {
                if (confirm('¿Estás seguro de que deseas eliminar tu cuenta como docente?')) {
                    this.$inertia.delete(this.route('docentes.destroy', [institucion_id, id]))
                }
            },

            destroyAlumno(institucion_id, id) {
                if (confirm('¿Estás seguro de que deseas eliminar tu cuenta como alumno?')) {
                    this.$inertia.delete(this.route('alumnos.destroy', [institucion_id, id]))
                }
            },

            destroyPadre(institucion_id, id) {
                if (confirm('¿Estás seguro de que deseas eliminar tu cuenta como directivo?')) {
                    this.$inertia.delete(this.route('padres.destroy', [institucion_id, id]))
                }
            },
        },
    }
</script>
