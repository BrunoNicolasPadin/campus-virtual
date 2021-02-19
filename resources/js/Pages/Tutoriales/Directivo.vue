<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Directivos</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#registrarse">Registrarse</a></li>
                    <li>2) <a class="hover:underline" href="#eliminarte">Eliminarte como directivo</a></li>
                    <li>3) <a class="hover:underline" href="#anotarte">Anotarte en una institución</a></li>
                    <li>4) <a class="hover:underline" href="#eliminar">Eliminar directivo de mi institución</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="registrarse">
                        <template #titulo-sub-tutorial>
                            Registrarse
                        </template>

                        <template #informacion>
                            No podrá registrarse como directivo nuevamente en la misma institución pero si con otro rol. 
                            Si podrá registrarse en otra institución con el rol de directivo sin ningún problema.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/uDqlFfPjuHY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminarte">
                        <template #titulo-sub-tutorial>
                            Eliminarte como directivo
                        </template>

                        <template #informacion>
                            Para hacerlo deberás tener la cuenta activada que desee eliminar.
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/2nBAGrqSKM8"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="anotarte">
                        <template #titulo-sub-tutorial>
                            Anotarte en una institución
                        </template>

                        <template #informacion>
                            Deberá saber la clave de acceso.
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/o-gpXJyPwhc"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar">
                        <template #titulo-sub-tutorial>
                            Eliminar directivo de mi institución
                        </template>

                        <template #informacion>
                            Si el directivo tiene la clave de acceso y la sabe, podrá ingresar cuantas veces quiera a menos que cambie la clave de acceso.
                            No sucederá nada con todos los usuarios que ya están inscriptos en su institución.
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

        title: 'Gescol - Tutorial - Directivos',
    }
</script>