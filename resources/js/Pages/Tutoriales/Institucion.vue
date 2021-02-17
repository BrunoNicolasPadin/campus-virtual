<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Instituciones</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#registrarse">Registrarse</a></li>
                    <li>2) <a class="hover:underline" href="#editar">Editar</a></li>
                    <li>3) <a class="hover:underline" href="#eliminar">Eliminar</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="registrarse">
                        <template #titulo-sub-tutorial>
                            Registrarse
                        </template>

                        <template #informacion>
                            Anotar la clave de acceso.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/ZIgNB9Rs6Ss"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="editar">
                        <template #titulo-sub-tutorial>
                            Editar
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/a9DMyHHs270"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar">
                        <template #titulo-sub-tutorial>
                            Eliminar
                        </template>

                        <template #informacion>
                            Topnav -> Institucional -> Perfil institucional -> Boton eliminar.
                            Si lo hace se borrara absolutamente todo y no se podra recuperar.
                        </template>

                        <template #contenido-video>
                            <a :href="'institucion/Eliminar.png'" target="_blank">
                                <img :src="'institucion/Eliminar.png'" class="border" alt="Eliminar institucion" title="Eliminar institucion" />
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
    }
</script>