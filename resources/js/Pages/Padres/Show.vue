<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <inertia-link :href="route('roles.index', institucion_id)">Roles</inertia-link>
                 > 
                <inertia-link :href="route('alumnos.index', institucion_id)">Padres</inertia-link>
                 > 
                {{ padre.user.name }}
            </h2>
        </template>

        <div class="py-12">
            <estructura-informacion>
                <template #cabecera-info>
                    Datos
                </template>

                <template #dl-contenido>
                    
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Nombre
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            {{ padre.user.name }}
                        </dd>
                    </div>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Hijo/s
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <span v-for="(padre, index) in padres" :key="padre.id">
                                <inertia-link class="hover:underline" :href="route('alumnos.show', [institucion_id, padre.hijos.id])">{{ padre.hijos.user.name }}</inertia-link>
                                <span v-if="index != Object.keys(padres).length - 1">- </span>
                            </span>
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

    export default {
        components: {
            AppLayout,
            EstructuraInformacion,
        },

        props: {
            institucion_id: String,
            padre: Object,
            padres: Array,
        },

        title: 'Perfil de padre/madre/tutor',
    }
</script>
