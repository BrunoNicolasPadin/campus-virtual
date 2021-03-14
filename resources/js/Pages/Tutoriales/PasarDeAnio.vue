<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Pasar de año</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#pasar">Hacer pasar de año masivamente</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="pasar">
                        <template #titulo-sub-tutorial>
                            Hacer pasar de año masivamente
                        </template>

                        <template #informacion>
                            -Seleccionar la división a la que pasarán y luego a los alumnos que lo harán. <br>
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/LFBEe8uEd_4" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
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

        title: 'Gescol - Tutorial - Pasar de año',
    }
</script>