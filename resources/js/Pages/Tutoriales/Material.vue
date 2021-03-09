<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Materiales</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#agregar-material">Agregar grupo y material</a></li>
                    <li>2) <a class="hover:underline" href="#eliminar-grupo">Eliminar grupo</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="agregar-material">
                        <template #titulo-sub-tutorial>
                            Agregar grupo y material
                        </template>

                        <template #informacion>
                            -Se debe crear un grupo en el cual se agregaran archivos. <br>
                            
                            -Cada archivo no podrá superar los 20MB. <br>

                            -Archivos permitidos: pdf, doc, docx, powerpoint, excel, ppsx, avi, mpeg, quicktime, mp4, jpg, jpeg, png. <br>
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/HjrH6M4yjHY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar-grupo">
                        <template #titulo-sub-tutorial>
                            Eliminar grupo
                        </template>

                        <template #informacion>
                            -Se eliminarán todos los archivos guardados en este grupo y no se podrán recuperar.
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

        title: 'Gescol - Tutorial - Materiales',
    }
</script>