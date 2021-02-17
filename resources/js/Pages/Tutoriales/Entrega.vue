<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Entregas</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#agregar">Agregar</a></li>
                    <li>2) <a class="hover:underline" href="#eliminar">Eliminar</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="agregar">
                        <template #titulo-sub-tutorial>
                            Agregar
                        </template>

                        <template #informacion>
                            Luego de subir el/los archivo/s, vera en su nombre la fecha y hora (Argentina) en las que se subieron.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/HjrH6M4yjHY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar">
                        <template #titulo-sub-tutorial>
                            Eliminar
                        </template>

                        <template #informacion>
                            Lo elimina para siempre y no se podra recuperar.
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