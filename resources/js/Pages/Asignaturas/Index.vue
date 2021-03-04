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
                        </inertia-link> /  Asignaturas
                    </span>
                </div>
                <div class="w-4/12" v-show="tipo == 'Institucion' || tipo == 'Directivo' ">
                    <primary class="float-right">
                        <template #boton-primary>
                            <inertia-link :href="route('asignaturas.create', [institucion_id, division.id])">Agregar</inertia-link>
                        </template>
                    </primary>
                </div>
            </div>
            
        </template>

        <div class="py-6">
            <estructura-informacion v-for="asignatura in asignaturas" :key="asignatura.id">
                <template #cabecera-info>
                    {{ asignatura.nombre }}
                </template>

                <template #dl-contenido>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Docente
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <span v-for="(asignaturasDocentes, index) in asignatura.docentes" :key="asignaturasDocentes.id">
                                <inertia-link class="hover:underline" :href="route('docentes.show', [institucion_id, asignaturasDocentes.docente.id])">
                                    {{ asignaturasDocentes.docente.user.name }}</inertia-link><span v-if="index != Object.keys(asignatura.docentes).length - 1">, </span>
                            </span>
                        </dd>
                    </div>
                    
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Horarios
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <span v-for="horario in asignatura.horarios" :key="horario.id">
                                {{ horario.dia }}: {{ horario.horaDesde }} - {{ horario.horaHasta }} <br>
                            </span>
                        </dd>
                    </div>

                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Mesas de examen
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <inertia-link class="hover:underline" :href="route('mesas.index', [institucion_id, division.id, asignatura.id])">
                                Ver
                            </inertia-link>
                        </dd>
                    </div>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6" v-show="tipo == 'Docente' || tipo == 'Institucion' || tipo == 'Directivo' ">
                        <dt class="text-sm font-medium text-gray-500">
                            Alumnos que deben rendirla
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <inertia-link class="hover:underline" :href="route('asignaturas.deudores', [institucion_id, division.id, asignatura.id])">
                                Ver
                            </inertia-link>
                        </dd>
                    </div>

                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6" v-show="tipo == 'Docente' || tipo == 'Institucion' || tipo == 'Directivo' ">
                        <dt class="text-sm font-medium text-gray-500">
                            Estadísticas
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <inertia-link class="hover:underline" :href="route('asignaturas.estadisticas', [institucion_id, division.id, asignatura.id])">
                                Ver
                            </inertia-link>
                        </dd>
                    </div>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6" v-show="tipo == 'Institucion' || tipo == 'Directivo' ">
                        <dt class="text-sm font-medium text-gray-500">
                            Acciones con la asignatura
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <inertia-link :href="route('asignaturas.edit', [institucion_id, division.id, asignatura.id])">
                                <editar></editar>
                            </inertia-link>

                            <form method="post" @submit.prevent="destroy(asignatura.id)">
                                <eliminar></eliminar>
                            </form>
                        </dd>
                    </div>

                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6" v-show="tipo == 'Institucion' || tipo == 'Directivo' ">
                        <dt class="text-sm font-medium text-gray-500">
                            Acciones con los horarios
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <primary>
                                <template #boton-primary>
                                    <inertia-link :href="route('asignaturas-horarios.create', [institucion_id, division.id, asignatura.id])">Agregar</inertia-link>
                                </template>
                            </primary>
                        </dd>
                    </div>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6" v-show="tipo == 'Institucion' || tipo == 'Directivo' ">
                        <dt class="text-sm font-medium text-gray-500">
                            Acciones con los docentes
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <primary>
                                <template #boton-primary>
                                    <inertia-link :href="route('asignaturas-docentes.create', [institucion_id, division.id, asignatura.id])">Agregar</inertia-link>
                                </template>
                            </primary>
                        </dd>
                    </div>

                </template>
            </estructura-informacion>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import EstructuraInformacion from '@/Datos/EstructuraInformacion.vue'
    import Primary from '@/Botones/Primary.vue'
    import Editar from '@/Botones/Editar.vue'
    import Eliminar from '@/Botones/Eliminar.vue'

    export default {
        components: {
            AppLayout,
            EstructuraInformacion,
            Primary,
            Editar,
            Eliminar
        },

        props: {
            institucion_id: String,
            tipo: String,
            division: Object,
            asignaturas: Array,
        },

        title: 'Asignaturas',

        methods: {
            destroy(asignatura_id) {
                if (confirm('Estas seguro de que desea eliminar esta asignatura?')) {
                    this.$inertia.delete(this.route('asignaturas.destroy', [this.institucion_id, this.division.id, asignatura_id]))
                }
            },
        },
    }
</script>
