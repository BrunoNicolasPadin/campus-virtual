<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Perfil de usuario</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#editar">Editar</a></li>
                    <li>2) <a class="hover:underline" href="#eliminar">Eliminar</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="editar">
                        <template #titulo-sub-tutorial>
                            Editar
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/IBedbTi6AW8"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar">
                        <template #titulo-sub-tutorial>
                            Eliminar
                        </template>

                        <template #informacion>
                            Se elimina complemtamente el usuario.
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/YGcI1Gb_UPQ"></video-embed>
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