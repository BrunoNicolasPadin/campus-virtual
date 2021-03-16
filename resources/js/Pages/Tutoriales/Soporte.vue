<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Soporte</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#contactarse">¿Cómo contactarte con nosotros si tienes un problema?</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="contactarse">
                        <template #titulo-sub-tutorial>
                            ¿Cómo contactarte con nosotros si tienes un problema?
                        </template>

                        <template #informacion>
                            Si tiene alguna queja, una nueva idea, encontró un error, quiere solicitar el servicio u otro motivo puede contactarnos así.
                        </template>

                        <template #contenido-video>
                            <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Tutoriales/Soporte.png'" target="_blank">
                                <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Tutoriales/Soporte.png'" class="border" alt="Soporte" title="Soporte" />
                            </a>
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

        title: 'Gescol - Tutorial - Calendario',
    }
</script>