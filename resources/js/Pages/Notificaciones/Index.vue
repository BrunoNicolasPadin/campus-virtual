<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                Notificaciones
            </span>
        </template>

        <div class="py-6 container mx-auto px-4 sm:px-8">

            <span class="text-black" v-for="notificacion in notificaciones.data" :key="notificacion.id">
                <div class="flex justify-center my-12 sm:my-0">
                    <div class="w-full px-6 py-3 shadow-2xl flex flex-col items-center border-t
                            sm:m-4 sm:rounded-lg sm:flex-row sm:border bg-blue-600 border-blue-600 text-white">
                        <div class="w-10/12">
                            <span v-if="notificacion.type == 'App\\Notifications\\Libretas\\ActualizacionLibretaNotification'">
                                <strong>Actualización de tu libreta</strong>: tienes un <strong>{{ notificacion.data.calificacion }}</strong> 
                                en <strong>{{ notificacion.data.asignatura }}</strong>
                                para el periodo <strong>{{ notificacion.data.periodo }}</strong>.
                            </span>

                            <span v-if="notificacion.type == 'App\\Notifications\\Deudores\\NuevoComentarioNotification'">
                                Nuevo comentario de <strong>{{ notificacion.data.usuario }}</strong> en la mesa del 
                                <strong>{{ notificacion.data.fechaHoraRealizacion }}</strong> de <strong>{{ notificacion.data.asignatura }}</strong>.
                                <br><br>
                            </span>

                            <span v-if="notificacion.type == 'App\\Notifications\\Deudores\\ActualizacionMesaNotification'">
                                Acaban de actualizar la mesa del <strong>{{ notificacion.data.fechaHoraRealizacion }}</strong> de 
                                <strong>{{ notificacion.data.asignatura }}</strong>. <br><br>
                            </span>

                            <span v-if="notificacion.type == 'App\\Notifications\\Evaluaciones\\NuevaRespuestaNotification'">
                                <strong>{{ notificacion.data.usuario }}</strong> te respondió un comentario en la evaluación 
                                <strong>{{ notificacion.data.evaluacion }}</strong> de <strong>{{ notificacion.data.asignatura }}</strong>. <br><br>
                            </span>

                            <span v-if="notificacion.type == 'App\\Notifications\\Evaluaciones\\NuevoComentarioEntregaNotification'">
                                <strong>{{ notificacion.data.usuario }}</strong> te hizo un comentario en la entrega para 
                                <strong>{{ notificacion.data.evaluacion }}</strong> de <strong>{{ notificacion.data.asignatura }}</strong>. <br><br>
                            </span>

                            <span v-if="notificacion.type == 'App\\Notifications\\Muro\\NuevaPublicacionNotification'">
                                <strong>{{ notificacion.data.usuario }}</strong> hizo una nueva publicación en el muro. <br><br>
                            </span>

                            <span v-if="notificacion.type == 'App\\Notifications\\Evaluaciones\\ActualizacionEntregaNotification'">
                                Nueva actualización en tu entrega para la evaluación <strong>{{ notificacion.data.evaluacion }}</strong> de 
                                <strong>{{ notificacion.data.asignatura }}</strong>: tu calificación es <strong>{{ notificacion.data.calificacion }}</strong> 
                                y el comentario: <strong>{{ notificacion.data.comentario }}</strong>. <br><br>
                            </span>

                            <span v-if="notificacion.type == 'App\\Notifications\\Evaluaciones\\EvaluacionNuevaNotification'">
                                <strong>{{ notificacion.data.titulo }}</strong> - 
                                <span v-if="notificacion.data.tipo == 'Tarea'">Nueva </span>
                                <span v-else>Nuevo </span>
                                <strong>{{ notificacion.data.tipo }}</strong> de <strong>{{ notificacion.data.asignatura }}</strong> para el 
                                <strong>{{ notificacion.data.fechaHoraRealizacion }}</strong> - <strong>{{ notificacion.data.fechaHoraFinalizacion }}</strong>.
                                <br><br>
                            </span>

                            <span v-if="notificacion.type == 'App\\Notifications\\Deudores\\ActualizacionInscripcionNotification'">
                                Nueva actualización en tu entrega para la mesa <strong>{{ notificacion.data.fechaHoraRealizacion }}</strong> de 
                                <strong>{{ notificacion.data.asignatura }}</strong>: tu calificación es <strong>{{ notificacion.data.calificacion }}</strong> 
                                y el comentario: <strong>{{ notificacion.data.comentario }}</strong>. <br><br>
                            </span>

                            <span v-if="notificacion.type == 'App\\Notifications\\Deudores\\NuevaAsignaturaAdeudadaNotification'">
                                Debes rendir <strong>{{ notificacion.data.asignatura }}</strong>. <br><br>
                            </span>

                            <span v-if="notificacion.type == 'App\\Notifications\\Evaluaciones\\NuevoComentarioNotification'">
                                <strong>{{ notificacion.data.usuario }}</strong> te hizo un comentario en 
                                <strong>{{ notificacion.data.evaluacion }}</strong> de <strong>{{ notificacion.data.asignatura }}</strong>. <br><br>
                            </span>

                            <span v-if="notificacion.type == 'App\\Notifications\\Muro\\NuevaRespuestaNotification'">
                                <strong>{{ notificacion.data.usuario }}</strong> respondió tu publicación. <br><br>
                            </span>
                        </div>
                        <div class="w-2/12 mt-2 sm:mt-0 sm:ml-4 justify-end">
                            <button @click="marcarComoLeido(notificacion.id)" class="px-3 py-2 hover:bg-blue-700 transition ease-in-out duration-300"> Marcar como leida </button>
                        </div>
                    </div>
                </div>
            </span>
            <pagination :links="notificaciones.links" />
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Pagination from '@/Pagination/Pagination.vue'

    export default {
        components: {
            AppLayout,
            Pagination,
        },

        props: {
            notificaciones: Object,
        },

        title: 'Notificaciones',

        methods: {
            marcarComoLeido(id) {
                this.$inertia.get(this.route('notificaciones.marcar_como_leida', id))
            },
        }
    }
</script>
