<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Alumno</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#registrarse">Registrarse</a></li>
                    <li>2) <a class="hover:underline" href="#eliminarte">Eliminarte como alumno</a></li>
                    <li>3) <a class="hover:underline" href="#anotarte">Anotarte en una institucion</a></li>
                    <li>4) <a class="hover:underline" href="#eliminar">Eliminar alumno de mi institucion</a></li>
                    <li>5) <a class="hover:underline" href="#cambiar-curso">Cambiar de curso</a></li>
                    <li>6) <a class="hover:underline" href="#agregar-asignatura-adeudada">Agregar asignaturas que adeuda</a></li>
                    <li>7) <a class="hover:underline" href="#repetir">Hacerlo repetir</a></li>
                    <li>8) <a class="hover:underline" href="#eliminar-division">Eliminar alumno de la division</a></li>
                    <li>9) <a class="hover:underline" href="#ex-alumno">Abandono el institucion o cambio de institucion</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="registrarse">
                        <template #titulo-sub-tutorial>
                            Registrarse
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/uDqlFfPjuHY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminarte">
                        <template #titulo-sub-tutorial>
                            Eliminarte como alumno
                        </template>

                        <template #informacion>
                            Para hacerlo deberas tener la cuenta activada que deseas eliminar.
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/2nBAGrqSKM8"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="anotarte">
                        <template #titulo-sub-tutorial>
                            Anotarte en una institucion
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/o-gpXJyPwhc"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar">
                        <template #titulo-sub-tutorial>
                            Eliminar alumno de mi institucion
                        </template>

                        <template #informacion>
                            Se eliminara todo de este alumno: entregas, inscripciones a mesas, libreta y deja de contar en las estadisticas.
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/eXv_ncBxlsY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="cambiar-curso">
                        <template #titulo-sub-tutorial>
                            Cambiar de curso
                        </template>

                        <template #informacion>
                            Si quiere hacerlo pasar de año verifique que haya creado un nuevo ciclo lectivo y que esté activado.
                            Si quiere hacerlo repetir no hace falta hacer nada, solo agregarlo en la lista de repitentes como se explica en "Hacerlo repetir".
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/uDqlFfPjuHY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="agregar-asignatura-adeudada">
                        <template #titulo-sub-tutorial>
                            Agregar asignaturas que adeuda
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/2nBAGrqSKM8"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="repetir">
                        <template #titulo-sub-tutorial>
                            Hacerlo repetir
                        </template>

                        <template #informacion>
                            Esto sirve mas que nada para la estadistica.
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/o-gpXJyPwhc"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar-division">
                        <template #titulo-sub-tutorial>
                            Eliminar alumno de la division
                        </template>

                        <template #informacion>
                            Al eliminar al alumno de la division solo le prohibes su ingreso a esta, salvo que el alumno vuelva a anotarse y para eso debe sabeer la clave de acceso, cambiala si quieres evitar esto. 
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/eXv_ncBxlsY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="ex-alumno">
                        <template #titulo-sub-tutorial>
                            Abandono el institucion o cambio de institucion
                        </template>

                        <template #informacion>
                            Esto tambien sirve mas que nada para la estadistica.
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/eXv_ncBxlsY"></video-embed>
                        </template>
                    </detalles-tutorial>
                </template>
            </titulo-lista>
        </template>
    </estructura>
</template>

<script>
    import Estructura from '@/TutorialesEstructura/Estructura'
    import TituloLista from '@/TutorialesEstructura/TituloLista'
    import DetallesTutorial from '@/TutorialesEstructura/DetallesTutorial'

    export default {
        components: {
            Estructura,
            TituloLista,
            DetallesTutorial,
        },
    }
</script>