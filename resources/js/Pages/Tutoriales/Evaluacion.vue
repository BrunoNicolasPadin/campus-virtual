<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Evaluaciones, archivos, entregas, correcciones y comentarios</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#agregar-evaluacion">Agregar evaluación</a></li>
                    <li>2) <a class="hover:underline" href="#agregar-archivo">Subir archivos</a></li>
                    <li>3) <a class="hover:underline" href="#agregar-correccion">Calificar y subir corrección</a></li>
                    <li>4) <a class="hover:underline" href="#agregar-entrega">Subir entrega</a></li>
                    <li>5) <a class="hover:underline" href="#ver-numeros">Números</a></li>
                    <li>6) <a class="hover:underline" href="#responder">Responder comentarios</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="agregar-evaluacion">
                        <template #titulo-sub-tutorial>
                            Agregar evaluación
                        </template>

                        <template #informacion>
                            -Al crear una evaluación, se le cargará en la base de datos una entrega correspondiente a cada alumno que esté anotado en 
                            ESE MOMENTO en la división. <br>

                            -Los alumnos y padres de estos serán avisados por medio de un email de la creación de la evaluación. <br>
                            
                            -Si ingresa un alumno nuevo luego de crear la evaluación, no tendrá ninguna entrega para realizar. <br>

                            -La lista de asignaturas a seleccionar depende de quien cree la evaluación: si lo hace un directivo/institución aparecerán 
                            todas las de la división, si lo hace un docente solo aparecerán en las que es docente en esa división. <br>

                            -Eliminar evaluación: se eliminan los archivos, comentarios, respuestas, entregas y correcciones. <br>
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/bChvZZgAT9o" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="agregar-archivo">
                        <template #titulo-sub-tutorial>
                            Subir archivos
                        </template>

                        <template #informacion>
                            -Visibilidad: los docentes de la asignatura, la institución y los directivos podrán verlo sin importar la visibilidad, 
                            solo afecta a los alumnos y padres. <br>

                            -Cada archivo no podrá superar los 20MB. <br>

                            -Archivos permitidos: pdf, doc, docx, powerpoint, excel, ppsx, avi, mpeg, quicktime, mp4, jpg, jpeg, png. <br>

                            -En la imagen se muestra cómo verán los alumnos un archivo "no visible" y un archivo "visible". <br>
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/m-rRdPhxadI" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div> <br>

                            <a :href="'../https://gescol.s3-sa-east-1.amazonaws.com/Tutoriales/Evaluacion/VistaAlumno.png'" target="_blank">
                                <img :src="'../https://gescol.s3-sa-east-1.amazonaws.com/Tutoriales/Evaluacion/VistaAlumno.png'" class="border" alt="VistaAlumno" title="VistaAlumno" />
                            </a> <br>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="agregar-correccion">
                        <template #titulo-sub-tutorial>
                            Calificar y subir corrección
                        </template>

                        <template #informacion>
                            -Se muestran las calificaciones cargadas en la forma de evaluación seleccionada. <br>

                            -El alumno y los padres de estos serán avisados por medio de un email de la calificación, comentario y corrección/es. <br>
                            
                            -Cada corrección no podrá superar los 20MB. <br>

                            -Archivos permitidos: pdf, doc, docx, powerpoint, excel, ppsx, avi, mpeg, quicktime, mp4, jpg, jpeg, png. <br>
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/PohNrm4XSK8" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="agregar-entrega">
                        <template #titulo-sub-tutorial>
                            Subir entrega
                        </template>

                        <template #informacion>
                            -Cada entrega no podrá superar los 20MB. <br>

                            -Solo los alumnos pueden realizar entregas, no los padres pero si comentar. <br>

                            -Archivos permitidos: pdf, doc, docx, powerpoint, excel, ppsx, avi, mpeg, quicktime, mp4, jpg, jpeg, png. <br>
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/u1_foenvhz0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="ver-numeros">
                        <template #titulo-sub-tutorial>
                            Números
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/-SEm9jTfrA4" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="responder">
                        <template #titulo-sub-tutorial>
                            Responder comentarios
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/foXT-sw2NEw" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
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

        title: 'Gescol - Tutorial - Evaluaciones, archivos, entregas y correcciones',
    }
</script>