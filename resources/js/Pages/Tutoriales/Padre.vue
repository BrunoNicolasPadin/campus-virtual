<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Padres</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#registrarse">Registrarse</a></li>
                    <li>2) <a class="hover:underline" href="#eliminarte">Eliminarte como padre</a></li>
                    <li>3) <a class="hover:underline" href="#anotarte">Anotarte en una institucion</a></li>
                    <li>4) <a class="hover:underline" href="#eliminar">Eliminar padre de mi institucion</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="registrarse">
                        <template #titulo-sub-tutorial>
                            Registrarse
                        </template>

                        <template #informacion>
                            Puede inscribirse con otros roles si quiere. Debe apretar en "Guardar" para guardar al hijo seleccionado.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/uDqlFfPjuHY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminarte">
                        <template #titulo-sub-tutorial>
                            Eliminarte como padre
                        </template>

                        <template #informacion>
                            Para hacerlo deberas tener la cuenta activada que deseas eliminar.
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/2nBAGrqSKM8"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="anotarte">
                        <template #titulo-sub-tutorial>
                            Anotarte en una institucion
                        </template>

                        <template #informacion>
                            Debera saber la clave de acceso.
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/o-gpXJyPwhc"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar">
                        <template #titulo-sub-tutorial>
                            Eliminar padre de mi institucion
                        </template>

                        <template #informacion>
                            Esto lo elimina completamente de la institucion, no se eliminara nada relacionado a su hijo/a.
                            Si el padre tiene la clave de acceso y la sabe podra ingresar cuantas veces quiera a menos que cambie la clave de acceso.
                            No sucedera nada con todos los usuarios que ya estan inscriptos en su institucion.
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/eXv_ncBxlsY"></video-embed>
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