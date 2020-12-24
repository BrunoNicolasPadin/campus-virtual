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

        <!-- Success Message -->

        <div v-if="successMessage" class="bg-green-200 px-6 py-4 mx-2 my-4 rounded-md text-lg flex items-center container mx-auto w-full">
            <svg viewBox="0 0 24 24" class="text-green-600 w-5 h-5 sm:w-5 sm:h-5 mr-3">
                <path fill="currentColor" d="M12,0A12,12,0,1,0,24,12,12.014,12.014,0,0,0,12,0Zm6.927,8.2-6.845,9.289a1.011,1.011,0,0,1-1.43.188L5.764,13.769a1,1,0,1,1,1.25-1.562l4.076,3.261,6.227-8.451A1,1,0,1,1,18.927,8.2Z"
                    ></path>
            </svg>
            <span class="text-green-800">{{ successMessage }} </span>
        </div>

        <div class="py-12">
            <estructura-informacion v-for="asignatura in asignaturas" :key="asignatura.id">
                <template #cabecera-info>
                    {{ asignatura.nombre }}
                </template>

                <template #dl-contenido>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Docentes
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <span v-for="(asignaturasDocentes, index) in asignatura.docentes" :key="asignaturasDocentes.id">
                                <span>
                                    {{ asignaturasDocentes.docente.user.name }}<span v-if="index != Object.keys(asignatura.docentes).length - 1">, </span>
                                </span>
                            </span>
                        </dd>
                    </div>
                    
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Horarios
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <span v-for="horario in asignatura.horarios" :key="horario.id">
                                {{ horario.dia }}: {{ horario.horaDesde }} - {{ horario.horaHasta }} <br>
                            </span>
                        </dd>
                    </div>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
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

                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
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

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
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
            successMessage: String,
            institucion_id: String,
            division: Object,
            asignaturas: Array,
        },

        methods: {
            destroy(asignatura_id) {
                if (confirm('Estas seguro de que desea eliminar esta asignatura?')) {
                    this.$inertia.delete(this.route('asignaturas.destroy', [this.institucion_id, this.division.id, asignatura_id]))
                }
            },
        },
    }
</script>
