<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Ciclos lectivos</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#agregar">Agregar</a></li>
                    <li>2) <a class="hover:underline" href="#editar">Editar</a></li>
                    <li>3) <a class="hover:underline" href="#eliminar">Eliminar</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="agregar">
                        <template #titulo-sub-tutorial>
                            Agregar
                        </template>

                        <template #informacion>
                            Al crear un ciclo lectivo activado, hara que el resto se desactive. Antes de hacer eso verifique que haya cumplido los pasos de "Comienza de ciclo lectivo nuevo? Sigue estos pasos".
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/26YEJA_QXD4"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="editar">
                        <template #titulo-sub-tutorial>
                            Editar
                        </template>

                        <template #informacion>
                            Si coloca el ciclo lectivo como "activado" se desactivaran los otros.
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/xOxqUf9cO-k"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar">
                        <template #titulo-sub-tutorial>
                            Eliminar
                        </template>

                        <template #informacion>
                            Si elimina el ciclo lectivo se eliminaran las libretas creadas para este ciclo (lo cual afectaria a las estadisticas), las asignaturas adeudadas que tienen los alumnos en el ciclo lectivo eliminado, registros de la lista de ex alumnos y repetidores.
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/Vg04Bv-A0X0"></video-embed>
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