<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Libretas</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#calificar">Calificar</a></li>
                    <!-- <li>2) <a class="hover:underline" href="#exportar">Exportar la libreta</a></li> -->
                </template>

                <template #detalles>
                    <detalles-tutorial id="calificar">
                        <template #titulo-sub-tutorial>
                            Calificar
                        </template>

                        <template #informacion>
                            -El alumno y sus padres recibirán un email por cada calificación ingresada o actualizada. <br>

                            -Podrá seleccionar entre las calificaciones que posee la forma de evaluación que existe ACTUALMENTE en la división. <br>
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/yAqEes3qjXs" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <!-- <detalles-tutorial id="exportar">
                        <template #titulo-sub-tutorial>
                            Exportar la libreta
                        </template>

                        <template #informacion>
                            En el caso de que desee tener la libreta de calificaciones en una tabla excel 
                            podrá conseguirlo simplemente apretando un botón.
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/HjrH6M4yjHY"></video-embed>
                        </template>
                    </detalles-tutorial> -->
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

        title: 'Gescol - Tutorial - Libretas',
    }
</script>