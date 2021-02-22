<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Cómo empezar: primeros pasos</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#registrar-institucion">Registrar tu institución</a></li>
                    <li>2) <a class="hover:underline" href="#registrar-ciclo-lectivo">Registrar un ciclo lectivo</a></li>
                    <li>3) <a class="hover:underline" href="#registrar-forma-evaluacion">Registrar formas de evaluación</a></li>
                    <li>4) <a class="hover:underline" href="#registrar-estructura">Registrar estructura</a></li>
                    <li>5) <a class="hover:underline" href="#registrar-asignaturas">Registrar todas las asignaturas de cada división</a></li>
                    <li>6) <a class="hover:underline" href="#registrar-docentes">Que los docentes se registren</a></li>
                    <li>7) <a class="hover:underline" href="#anotar-docentes">Anotar a los docentes en las asignaturas que les corresponde</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="registrar-institucion">
                        <template #titulo-sub-tutorial>
                            Registrar tu institución
                        </template>

                        <template #informacion>
                            Anotar la clave de acceso para no olvidarsela.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/ZIgNB9Rs6Ss"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="registrar-ciclo-lectivo">
                        <template #titulo-sub-tutorial>
                            Registrar un ciclo lectivo
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/26YEJA_QXD4"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="registrar-forma-evaluacion">
                        <template #titulo-sub-tutorial>
                            Registrar formas de evaluación
                        </template>

                        <template #informacion>
                            Deberá ingresar las distintas formas de valores en las que evaluara a sus alumnos, ya se con números de 1 al 10, del 1 al 100 
                            o con calificaciones alfabéticas como "Excelente", "Muy bien", o la que deseen. Luego pondrá en cada división la forma de 
                            evaluación que tendrá cada una.
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
                            Recomendación: escriba todas las claves de acceso de cada división.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/HjrH6M4yjHY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="registrar-asignaturas">
                        <template #titulo-sub-tutorial>
                            Registrar todas las asignaturas de cada división
                        </template>

                        <template #informacion>
                            Puede hacerlo sin tener docentes anotados en su institución, luego los podra agregar y así estos podran ingresar a 
                            la/s división/es en las que son docentes de una o mas asignaturas.
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
                            No podrá registrarse como docente nuevamente en la misma institución pero si con otro rol. 
                            Si podrá registrarse en otra institución con el rol de docente sin ningún problema.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/ZIgNB9Rs6Ss"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="anotar-docentes">
                        <template #titulo-sub-tutorial>
                            Anotar a los docentes en las asignaturas que les corresponde
                        </template>

                        <template #informacion>
                            Le permitirá a los docentes ingresar a la división.
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

        title: 'Gescol - Tutoriales - Primeros pasos',
    }
</script>