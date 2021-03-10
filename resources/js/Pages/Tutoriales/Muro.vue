<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Muros</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#agregar-publicacion">Agregar publicación, respuestas y archivos</a></li>
                    <li>2) <a class="hover:underline" href="#eliminar-publicacion">Eliminar publicación</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="agregar-publicacion">
                        <template #titulo-sub-tutorial>
                            Agregar publicación
                        </template>

                        <template #informacion>
                            -Cada archivo no podrá superar los 20MB. <br>

                            -Archivos permitidos: pdf, doc, docx, powerpoint, excel, ppsx, avi, mpeg, quicktime, mp4, jpg, jpeg, png. <br>
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/yAqEes3qjXs" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="editar-eliminar-publicacion">
                        <template #titulo-sub-tutorial>
                            Eliminar publicación
                        </template>

                        <template #informacion>
                            -Al eliminar la publicación se eliminarán los archivos y las respuestas para siempre. <br>
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/yAqEes3qjXs" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
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

        title: 'Gescol - Tutorial - Muro',
    }
</script>