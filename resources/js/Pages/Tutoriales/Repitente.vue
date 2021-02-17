<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Repitentes</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#agregar">Hacer repetir a un alumno</a></li>
                    <li>2) <a class="hover:underline" href="#editar">Editar repitente</a></li>
                    <li>3) <a class="hover:underline" href="#eliminar">Eliminar repitente</a></li>
                    <li>3) <a class="hover:underline" href="#numeros">Numeros</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="agregar">
                        <template #titulo-sub-tutorial>
                            Hacer repetir a un alumno
                        </template>

                        <template #informacion>
                            Esto sirve mas que nada para la estadistica, no debe volver a ingresar la division en la que cursara.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/HjrH6M4yjHY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="editar">
                        <template #titulo-sub-tutorial>
                            Editar repitente
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/mEr8WG6JChc"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar">
                        <template #titulo-sub-tutorial>
                            Eliminar de la lista de repitentes
                        </template>

                        <template #informacion>
                            Solo saldra de la lista.
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/Gfgdj-kD8YY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="numeros">
                        <template #titulo-sub-tutorial>
                            Numeros
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