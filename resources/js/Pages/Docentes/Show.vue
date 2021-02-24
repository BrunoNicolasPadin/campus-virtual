<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('roles.index', institucion_id)">Roles</inertia-link> /
                <inertia-link class="hover:underline" :href="route('docentes.index', institucion_id)">Docentes</inertia-link> /
                {{ docente.name }}
            </span>
        </template>

        <div class="py-6">
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
                            {{ docente.name }}<span v-show="docente.profile_photo_path">
                                - <img class="block m-auto p-auto h-20 w-20 object-cover" :src="'../../../../storage/' + docente.profile_photo_path "  alt="Foto de perfil" />
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
            docente: Object,
        },

        title: 'Perfil docente',
    }
</script>
