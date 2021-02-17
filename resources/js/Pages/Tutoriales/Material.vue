<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Materiales</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#agregar-material">Agregar grupo y material</a></li>
                    <li>2) <a class="hover:underline" href="#editar-grupo">Editar grupo</a></li>
                    <li>3) <a class="hover:underline" href="#eliminar-grupo">Eliminar grupo</a></li>
                    <li>4) <a class="hover:underline" href="#editar-material">Editar material</a></li>
                    <li>5) <a class="hover:underline" href="#eliminar-material">Eliminar material</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="agregar-material">
                        <template #titulo-sub-tutorial>
                            Agregar grupo y material
                        </template>

                        <template #informacion>
                            Se debe crear un grupo en el cual se agregaran los archivos que desee cada docente. 
                            Se pueden crear muchos grupos y agregar todos los materiales que desee.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/HjrH6M4yjHY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="editar-grupo">
                        <template #titulo-sub-tutorial>
                            Editar grupo
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/mEr8WG6JChc"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar-grupo">
                        <template #titulo-sub-tutorial>
                            Eliminar grupo
                        </template>

                        <template #informacion>
                            Se eliminaran todos los archivos guardados en este grupo y no se podran recuperar.
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/Gfgdj-kD8YY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="editar-material">
                        <template #titulo-sub-tutorial>
                            Editar material
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/mEr8WG6JChc"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar-material">
                        <template #titulo-sub-tutorial>
                            Eliminar material
                        </template>

                        <template #informacion>
                            Se eliminara para siempre y no se podra recuperar.
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