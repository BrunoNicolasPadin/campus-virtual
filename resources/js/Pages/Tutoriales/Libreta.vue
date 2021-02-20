<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Libretas</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#calificar">Calificar</a></li>
                    <li>1) <a class="hover:underline" href="#exportar">Exportar la libreta</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="calificar">
                        <template #titulo-sub-tutorial>
                            Calificar
                        </template>

                        <template #informacion>
                            Las calificaciones deben ser del 1 al 10 y escritos numéricamente, ya que sino las estadísticas no funcionarán.
                            Estamos trabajando para que pueda calificarse de otras maneras y aun así funcionen las estadísticas de forma correcta.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/HjrH6M4yjHY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="exportar">
                        <template #titulo-sub-tutorial>
                            Exportar la libreta
                        </template>

                        <template #informacion>
                            En el caso de que desee tener la libreta de calificaciones en una tabla excel 
                            podrá conseguirlo simplemente apretando un botón.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/HjrH6M4yjHY"></video-embed>
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

        title: 'Gescol - Tutorial - Libretas',
    }
</script>