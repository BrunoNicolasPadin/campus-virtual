<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>¿Está por comenzar un ciclo lectivo nuevo? Sigue estos pasos</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#asignaturas">Verificar asignaturas</a></li>
                    <li>2) <a class="hover:underline" href="#limpiar">Limpiar estructura</a></li>
                    <li>3) <a class="hover:underline" href="#adeudadas">Asignaturas adeudadas</a></li>
                    <li>4) <a class="hover:underline" href="#exalumnos">Ex alumnos</a></li>
                    <li>5) <a class="hover:underline" href="#ciclo-lectivo-nuevo">Ciclo lectivo nuevo</a></li>
                    <li>6) <a class="hover:underline" href="#repitentes">Repitentes</a></li>
                    <li>7) <a class="hover:underline" href="#nuevo-curso">Pasar de año</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="asignaturas">
                        <template #titulo-sub-tutorial>
                            Verificar asignaturas
                        </template>

                        <template #informacion>
                            -Si piensa en agregar o eliminar una asignatura, debería hacerlo antes de hacer repetir y hacer pasar de año a algun alumno. <br>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="limpiar">
                        <template #titulo-sub-tutorial>
                            Limpiar estructura
                        </template>

                        <template #informacion>
                            -Ingresar desde "Perfil institucional". <br>

                            -Se eliminarán las evaluaciones, archivos de evaluaciones, comentarios y respuestas de evaluaciones, entregas, correcciones, 
                            comentarios de entregas, publicaciones, respuestas y archivos del muro. <br>
                            
                            -El resto se mantiene: materiales, asignaturas, docentes, alumnos, repitentes, forma de evaluación y estadísticas.
                        </template>

                        <template #contenido-video>
                            <a :href="'../storage/Tutoriales/Estructura/LimpiarDivision.png'" target="_blank">
                                <img :src="'../storage/Tutoriales/Estructura/LimpiarDivision.png'" class="border" alt="Limpiar Division" title="Limpiar Division" />
                            </a> <br>

                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/mQQ7QpKHbFQ" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="adeudadas">
                        <template #titulo-sub-tutorial>
                            Asignaturas adeudadas
                        </template>

                        <template #informacion>
                            -Ingresar al perfil de los alumnos que adeuden asignaturas y agregar las correspondientes para que el alumno pueda inscribirse 
                            a las mesas de examen y así rendir la asignatura que adeuda.
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="exalumnos">
                        <template #titulo-sub-tutorial>
                            Ex alumnos
                        </template>

                        <template #informacion>
                            -Ingresar al perfil de cada alumno que haya cambiado de colegio, abandonado o finalizado sus estudios y agregarlo a la lista.

                            -Pasará a desinscribirse de la división en la que este actualmente con lo cual no podrá ingresar a la división nunca mas. <br> 
                            
                            -Solo podrá ingresar a todo lo que se encuentre en su perfil y a las mesas de las asignaturas que debe rendir. <br>

                            -Números: solo se tiene en cuenta a los alumnos que abandonaron el colegio. <br>
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/BWmnpc2xoDI" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="ciclo-lectivo-nuevo">
                        <template #titulo-sub-tutorial>
                            Ciclo lectivo nuevo
                        </template>

                        <template #informacion>
                            -Este paso debe hacerlo si o si antes de los dos pasos que le siguen porque sino puede llegar a cometer un error que no tiene 
                            vuelta atrás y es eliminar accidentalmente la ultima libreta de un alumno o de muchos, depende cuantos alumnos estuvieron haciendo 
                            repetir y haciendo pasar de año.

                            -Ingresamos desde "Institucional -> Ciclos lectivos". <br>
                            
                            -Al crear un ciclo lectivo activado, hará que el resto se desactive. <br>
                        </template>

                        <template #contenido-video>
                            <a :href="'../storage/Tutoriales/CicloLectivo/Ingresar.png'" target="_blank">
                                <img :src="'../storage/Tutoriales/CicloLectivo/Ingresar.png'" class="border" alt="Ingresar" title="Ingresar" />
                            </a> <br>

                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/bGRRzjsqfVg" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="repitentes">
                        <template #titulo-sub-tutorial>
                            Repitentes
                        </template>

                        <template #informacion>
                            -Ingresar al perfil de cada alumno que haya cambiado de colegio, abandonado o finalizado sus estudios y agregarlo a la lista. <br>

                            -Esto sirve más que nada para la estadística. <br>

                             -La división en la que estará anotado será la misma que acaba de repetir, si desea que sea otra, desde el perfil del alumno 
                             vaya a "Cambiar de curso" y seleccione la división e ingrese la clave correspondiente. En el caso de no acordarse la clave, 
                             vaya a la división del alumno, en el apartado "Alumnos - Ver" encontrara un botón que dice "Hacerlos pasar", seleccione 
                             solo a ese alumno y listo.<br>

                            -Debe hacerlo una vez activado el nuevo ciclo lectivo en el que cursara, no antes. En el caso de haberlo hecho contáctese 
                            con nosotros para solucionar el problema. <br>
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/LVN8PG9j_6s" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="nuevo-curso">
                        <template #titulo-sub-tutorial>
                            Pasar de año
                        </template>

                        <template #informacion>
                            -Ingresar a la lista de alumnos de cada división y apriete en "Hacerlos pasar". <br>

                            -Seleccionar la división a la que pasarán y luego a los alumnos que lo harán. <br>
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/LFBEe8uEd_4" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
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

        title: 'Gescol - Tutoriales - Como empezar un ciclo lectivo nuevo',
    }
</script>