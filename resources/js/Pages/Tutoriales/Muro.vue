<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Estructura</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#agregar-publicacion">Agregar publicacion</a></li>
                    <li>2) <a class="hover:underline" href="#editar-eliminar-publicacion">Editar y eliminar publicacion</a></li>
                    <li>3) <a class="hover:underline" href="#agregar-eliminar-archivo">Agregar y eliminar archivo</a></li>
                    <li>4) <a class="hover:underline" href="#agregar-editar-eliminar-respuesta">Agregar, editar y eliminar respuesta</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="agregar-publicacion">
                        <template #titulo-sub-tutorial>
                            Agregar publicacion
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/HjrH6M4yjHY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="editar-eliminar-publicacion">
                        <template #titulo-sub-tutorial>
                            Editar y eliminar publicacion
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/mEr8WG6JChc"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="agregar-eliminar-archivo">
                        <template #titulo-sub-tutorial>
                            Agregar y eliminar archivo
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/Gfgdj-kD8YY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="agregar-editar-eliminar-respuesta">
                        <template #titulo-sub-tutorial>
                            Agregar, editar y eliminar respuesta
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