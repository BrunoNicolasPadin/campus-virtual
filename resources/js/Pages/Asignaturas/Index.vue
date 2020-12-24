<template>
    <app-layout>
        <template #header>
            <div class="flex">
                <div class="w-1/2">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        <inertia-link :href="route('divisiones.index', institucion_id)">Estructura</inertia-link>
                        > 
                        <inertia-link :href="route('divisiones.show', [institucion_id, division.id])">
                            <span v-if="division.orientacion">{{ division.nivel.nombre }} - {{ division.orientacion.nombre }} - {{ division.curso.nombre }} - {{ division.division }}</span>
                            <span v-else>{{ division.nivel.nombre }} - {{ division.curso.nombre }} - {{ division.division }}</span>
                        </inertia-link>
                        > 
                        Asignaturas
                    </h2>
                </div>
                <div class="w-1/2">
                    <primary class="float-right">
                        <template #boton-primary>
                            <inertia-link :href="route('asignaturas.create', [institucion_id, division.id])">Agregar</inertia-link>
                        </template>
                    </primary>
                </div>
            </div>
            
        </template>

        <div class="py-12">
            <estructura-informacion>
                <template #cabecera-info>
                    Datos
                </template>

                <template #dl-contenido>

                    <div v-for="asignatura in asignaturas" :key="asignatura.id">
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Nombre
                            </dt>
                            <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                                {{ asignatura.nombre }}
                            </dd>
                        </div>

                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Docentes
                            </dt>
                            <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                                <span v-for="docentes in asignatura.docentes" :key="docentes.id">
                                    {{ docentes.docente.user.name }}
                                </span>
                            </dd>
                        </div>

                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Horarios
                            </dt>
                            <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                                <span v-for="horario in asignatura.horarios" :key="horario.id">
                                    {{ horario.dia }}: {{ horario.horaDesde }} - {{ horario.horaHasta }}
                                </span>
                            </dd>
                        </div>
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

    export default {
        components: {
            AppLayout,
            EstructuraInformacion,
            Primary,
        },

        props: {
            institucion_id: String,
            division: Object,
            asignaturas: Array,
        },
    }
</script>
