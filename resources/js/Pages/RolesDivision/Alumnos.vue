<template>
    <app-layout>
        <template #header>
            <div class="flex">
                <div class="w-8/12">
                    <span class="font-semibold text-md text-gray-800 leading-tight">
                        <inertia-link class="hover:underline" :href="route('divisiones.index', institucion_id)">Estructura</inertia-link> /
                        <inertia-link class="hover:underline" :href="route('divisiones.show', [institucion_id, division.id])">
                            <span v-if="division.orientacion_nombre">{{ division.nivel_nombre }} - {{ division.orientacion_nombre }} - {{ division.curso_nombre }} - {{ division.division }}</span>
                            <span v-else>{{ division.nivel_nombre }} - {{ division.curso_nombre }} - {{ division.division }}</span>
                        </inertia-link> / 
                        Alumnos
                    </span>
                </div>
                <div v-show="tipo == 'Institucion' || tipo == 'Directivo' " class="w-4/12">
                    <primary class="float-right">
                        <template #boton-primary>
                            <inertia-link :href="route('alumnosDivision.hacerlosPasar', [institucion_id, division.id])">Pasar de año</inertia-link>
                        </template>
                    </primary>
                </div>
            </div>
            
        </template>

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
                                    Foto de perfil
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Nombre
                                </template>
                            </table-head>

                            <table-head v-show="tipo == 'Institucion' || tipo == 'Directivo' ">
                                <template #th-titulo>
                                    Acciones
                                </template>
                            </table-head>
                        </template>
                    </table-head-estructura>

                    <table-body>
                        <template #tr>
                            
                            <tr v-for="(alumno, index) in alumnos.data" :key="alumno.index">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td v-if="alumno.profile_photo_path">
                                        <img class="block m-auto p-auto h-20 w-20 object-cover" :src="'../../../../storage/' + alumno.profile_photo_path "  alt="Foto de perfil" />
                                    </template>

                                    <template #td v-else>
                                        -
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link class="hover:underline" :href="route('alumnos.show', [institucion_id, alumno.id])">
                                            {{ alumno.name }}
                                        </inertia-link>
                                    </template>
                                </table-data>

                                <table-data v-show="tipo == 'Institucion' || tipo == 'Directivo' ">
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
    import EstructuraTabla from '@/Tabla/EstructuraTabla.vue'
    import TableHeadEstructura from '@/Tabla/TableHeadEstructura.vue'
    import TableHead from '@/Tabla/TableHead.vue'
    import TableBody from '@/Tabla/TableBody.vue'
    import TableData from '@/Tabla/TableData.vue'
    import Pagination from '@/Pagination/Pagination.vue'
    import Primary from '@/Botones/Primary.vue'

    export default {
        components: {
            AppLayout,
            EstructuraTabla,
            TableHeadEstructura,
            TableHead,
            TableBody,
            TableData,
            Pagination,
            Primary,
        },

        props: {
            successMessage: String,
            institucion_id: String,
            tipo: String,
            user_id: Number,
            division: Object,
            alumnos: Object,
        },

        title: 'Alumnos de la division',

        methods: {
            destroy(alumno_id) {
                if (confirm('¿Estás seguro de que desea sacar de la división a este alumno?')) {
                    this.$inertia.get(this.route('alumnosDivision.sacarlo', [this.institucion_id, this.division.id, alumno_id]))
                }
            },
        },
    }
</script>
