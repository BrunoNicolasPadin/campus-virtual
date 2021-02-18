<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Como empezar: primeros pasos</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#registrar-institucion">Registrar tu institucion</a></li>
                    <li>2) <a class="hover:underline" href="#registrar-ciclo-lectivo">Registrar un ciclo lectivo</a></li>
                    <li>3) <a class="hover:underline" href="#registrar-estructura">Registrar estructura</a></li>
                    <li>4) <a class="hover:underline" href="#registrar-asignaturas">Registrar todas las asignaturas de cada division</a></li>
                    <li>5) <a class="hover:underline" href="#registrar-docentes">Que los docentes se registren</a></li>
                    <li>6) <a class="hover:underline" href="#anotar-docentes">Anotar a los docentes en las asignaturas que les corresponden</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="registrar-institucion">
                        <template #titulo-sub-tutorial>
                            Registrar tu institucion
                        </template>

                        <template #informacion>
                            Anotar la clave de acceso.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/ZIgNB9Rs6Ss"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="registrar-ciclo-lectivo">
                        <template #titulo-sub-tutorial>
                            Registrar un ciclo lectivo
                        </template>

                        <template #informacion>
                            Al crear un ciclo lectivo activado, hara que el resto se desactive. Antes de hacer eso verifique que haya cumplido los pasos de "Comienza de ciclo lectivo nuevo? Sigue estos pasos".
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/26YEJA_QXD4"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="registrar-estructura">
                        <template #titulo-sub-tutorial>
                            Registrar tu estructura
                        </template>

                        <template #informacion>
                            Recomendacion: escriba todas las claves de acceso de cada division.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/HjrH6M4yjHY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="registrar-asignaturas">
                        <template #titulo-sub-tutorial>
                            Registrar todas las asignaturas de cada division
                        </template>

                        <template #informacion>
                            Puede hacerlo sin tener docentes anotados en su institucion, luego los podra agregar y asi estos podran ingresar a la/s division/es en las que son docentes de una o mas asignaturas.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/HjrH6M4yjHY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="registrar-docentes">
                        <template #titulo-sub-tutorial>
                            Que los docentes se registren
                        </template>

                        <template #informacion>
                            No podra registrarse como docente nuevamente en la misma institucion pero si con otro rol. 
                            Si podra registrarse en otra institucion con el rol de docente sin ningun problema.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/ZIgNB9Rs6Ss"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="anotar-docentes">
                        <template #titulo-sub-tutorial>
                            Anotar a los docentes en las asignaturas que les corresponden
                        </template>

                        <template #informacion>
                            Le permitira a los docentes ingresar a la division.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/ZIgNB9Rs6Ss"></video-embed>
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