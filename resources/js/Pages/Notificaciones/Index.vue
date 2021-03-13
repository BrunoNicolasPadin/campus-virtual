<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                Notificaciones
            </span>
        </template>

        <div class="py-6 container mx-auto px-4 sm:px-8">

            <span class="text-black" v-for="notificacion in notificaciones" :key="notificacion.id">
                {{ notificacion.data }}
            </span>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'

    export default {
        components: {
            AppLayout,
        },

        props: {
            notificaciones: Array,
        },

        title: 'Notificaciones',

        methods: {
            
        }
    }
</script>
