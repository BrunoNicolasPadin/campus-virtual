<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Asignatura</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#agregar-asignatura">Agregar asignatura</a></li>
                    <li>2) <a class="hover:underline" href="#editar-asignatura">Editar asignatura</a></li>
                    <li>3) <a class="hover:underline" href="#eliminar-asignatura">Eliminar asignatura</a></li>
                    <li>4) <a class="hover:underline" href="#agregar-docente">Agregar docente</a></li>
                    <li>5) <a class="hover:underline" href="#cambiar-docente">Cambiar docente</a></li>
                    <li>6) <a class="hover:underline" href="#eliminar-docente">Eliminar docente</a></li>
                    <li>7) <a class="hover:underline" href="#agregar-horario">Agregar horario</a></li>
                    <li>8) <a class="hover:underline" href="#eliminar-horario">Eliminar horario</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="agregar-asignatura">
                        <template #titulo-sub-tutorial>
                            Agregar asignatura
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/HjrH6M4yjHY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="editar-asignatura">
                        <template #titulo-sub-tutorial>
                            Editar asignatura
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/mEr8WG6JChc"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar-asignatura">
                        <template #titulo-sub-tutorial>
                            Eliminar asignatura
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/Gfgdj-kD8YY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="agregar-docente">
                        <template #titulo-sub-tutorial>
                            Agregar docente
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/HjrH6M4yjHY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="cambiar-docente">
                        <template #titulo-sub-tutorial>
                            Cambiar docente
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/mEr8WG6JChc"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar-docente">
                        <template #titulo-sub-tutorial>
                            Eliminar docente
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/Gfgdj-kD8YY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="agregar-horario">
                        <template #titulo-sub-tutorial>
                            Agregar horario
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/HjrH6M4yjHY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar-horario">
                        <template #titulo-sub-tutorial>
                            Eliminar horario
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/Gfgdj-kD8YY"></video-embed>
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