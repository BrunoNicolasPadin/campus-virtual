<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Estadisticas y numeros</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#alumno">Alumno</a></li>
                    <li>2) <a class="hover:underline" href="#asignatura">Asignatura</a></li>
                    <li>3) <a class="hover:underline" href="#division">Division</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="alumno">
                        <template #titulo-sub-tutorial>
                            Alumno
                        </template>

                        <template #informacion>
                            -Forma numérica/porcentual: es el promedio obtenido de todas las calificaciones en la libreta, separadas por el periodo 
                            de evaluación. <br>

                            -Forma escrita: son la cantidad de veces que obtuvo cada calificación separadas por periodo de evaluación. <br>
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/l6ssTYes5v8" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="asignatura">
                        <template #titulo-sub-tutorial>
                            Asignatura
                        </template>

                        <template #informacion>
                            -General: es la calificación que obtuvo cada alumno en la asignatura. <br>

                            -Forma numérica/porcentual: es el promedio obtenido de todas las calificaciones en la libreta de cada alumno en esa asignatura, 
                            separadas por el periodo de evaluación. <br>

                            -Forma escrita: son la cantidad de veces que los alumnos obtuvieron cada calificación en esa asignatura, separadas por periodo 
                            de evaluación. <br>
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/fhL9tlWr6ds" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="division">
                        <template #titulo-sub-tutorial>
                            División
                        </template>

                        <template #informacion>
                            -Forma numérica/porcentual: es el promedio obtenido de todas las calificaciones en la libreta de cada alumno en todas las 
                            asignaturas, separadas por el periodo de evaluación y también el promedio en cada periodo de cada alumno. <br>

                            -Forma escrita: son la cantidad de veces que los alumnos obtuvieron cada calificación en todas las asignaturas, 
                            separadas por periodo de evaluación. <br>
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/p-FFee8FWrc" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
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