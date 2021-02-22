<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Estadisticas y numeros</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#evaluacion">Evaluacion</a></li>
                    <li>2) <a class="hover:underline" href="#alumno">Alumno</a></li>
                    <li>3) <a class="hover:underline" href="#asignatura">Asignatura</a></li>
                    <li>4) <a class="hover:underline" href="#division">Division</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="evaluacion">
                        <template #titulo-sub-tutorial>
                            Evaluacion
                        </template>

                        <template #informacion>
                            Si la calificación no es numérica no aparecerá quién tuvo la mejor nota ni cual es.
                            Para que el alumno aparezca en la lista de "Entregado a tiempo" se compara la fecha y hora de entrega establecida por el docente, 
                            y la fecha y hora en la que el alumno entregó el último archivo.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/HjrH6M4yjHY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="alumno">
                        <template #titulo-sub-tutorial>
                            Alumno
                        </template>

                        <template #informacion>
                            Es el promedio obtenido de todas las calificaciones en la libreta separada por el periodo de evaluación 
                            seleccionado al momento de crear cada división. Las calificaciones deben ser numéricas sino esto no funcionará.
                            
                            Acceso: los alumnos solo puede acceder a la suya y los padres al de su hijo/a activado/a. La institución y los directivos 
                            puede acceder a todas. Los docentes a ninguna.
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/mEr8WG6JChc"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="asignatura">
                        <template #titulo-sub-tutorial>
                            Asignatura
                        </template>

                        <template #informacion>
                            Es el promedio obtenido de todas las calificaciones de las libretas de cada alumno segun el ciclo lectivo seleccionado, 
                            separada por el periodo de evaluación, seleccionado al momento de crear cada división. Tambien están las notas de la libreta
                            de cada alumno en la asignatura correspondiente.
                            Las calificaciones deben ser numéricas sino esto no funcionará.
                            
                            Acceso: los docentes solo pueden acceder en las que son docentes. La institución y los directivos 
                            puede acceder a todas. Los alumnos y padres a ninguna.
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/Gfgdj-kD8YY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="division">
                        <template #titulo-sub-tutorial>
                            División
                        </template>

                        <template #informacion>
                            Es el promedio obtenido en cada periodo de todas las calificaciones en las libretas.
                            Las calificaciones deben ser numérica sino esto no funcionará.
                            
                            Acceso: solo las instituciones y directivos.
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

        title: 'Gescol - Tutorial - Estadísticas',
    }
</script>