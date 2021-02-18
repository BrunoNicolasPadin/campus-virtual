<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Esta por comenzar un ciclo lectivo nuevo? Sigue estos pasos</template>

                <template #lista-tutorial>
                    <!--         
                    6. Agregar a ex alumnos a los que corresponde.
                    7. Hacer pasar de curso a los que corresponde y crear nueva libreta. -->
                    <li>1) <a class="hover:underline" href="#asignaturas">Verificar asignaturas</a></li>
                    <li>2) <a class="hover:underline" href="#exportar">Exportar números, libretas y estadisticas</a></li>
                    <li>3) <a class="hover:underline" href="#limpiar">Limpiar estructura</a></li>
                    <li>4) <a class="hover:underline" href="#exalumnos">Ex alumnos</a></li>
                    <li>5) <a class="hover:underline" href="#adeudadas">Asignaturas adeudadas</a></li>
                    <li>6) <a class="hover:underline" href="#ciclo-lectivo-nuevo">Ciclo lectivo nuevo</a></li>
                    <li>7) <a class="hover:underline" href="#repitentes">Repitentes</a></li>
                    <li>8) <a class="hover:underline" href="#nuevo-curso">Pasar de año</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="asignaturas">
                        <template #titulo-sub-tutorial>
                            Verificar asignaturas
                        </template>

                        <template #informacion>
                            Si piensa en agregar o eliminar una asignatura, deberia hacerlo antes de hacer repetir y hacer pasar de año a algun alumno.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/ZIgNB9Rs6Ss"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="exportar">
                        <template #titulo-sub-tutorial>
                            Exportar números y estadisticas
                        </template>

                        <template #informacion>
                            Le recomendamos exportar los graficos y tablas que hay en cada tipo de estadistica del ciclo lectivo que esta por terminar.
                            Desde Gescol no borramos nada salvo que usted desee eliminar su cuenta, pero tal vez quiera tenerlos en su computadora e imprimirlo 
                            para verlo mejor o darle cualquier otro uso.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/ZIgNB9Rs6Ss"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="limpiar">
                        <template #titulo-sub-tutorial>
                            Limpiar estructura
                        </template>

                        <template #informacion>
                            En este paso le recomendamos eliminar las evaluaciones y con esto se eliminaran las entregas de los alumnos, las correcciones y 
                            los comentarios hechos en cada una como asi tambien los archivos que subio cada docente en cada evaluacion.
                            Si quiere conservar esos archivos le recomendamos crearse una cuenta de Gmail e ingresar a "Google drive" y asi guardar esos archivos 
                            en la nube.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/ZIgNB9Rs6Ss"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="exalumnos">
                        <template #titulo-sub-tutorial>
                            Ex alumnos
                        </template>

                        <template #informacion>
                            Ingresar a la lista de alumnos de cada division, ingresar al perfil de los alumnos que cambian de institucion, terminaron sus estudios 
                            o han abandonado y hacer el proceso para guardarlos en la lista de ex alumnos.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/ZIgNB9Rs6Ss"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="adeudadas">
                        <template #titulo-sub-tutorial>
                            Asignaturas adeudadas
                        </template>

                        <template #informacion>
                            Ingresar a la lista de alumnos de cada division, ingresar al perfil de los alumnos que adeuden asignaturas y agregar las correspondientes 
                            para que el alumno pueda inscribirse a las mesas de examen y asi rendir la asignatura que adeuda.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/ZIgNB9Rs6Ss"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="ciclo-lectivo-nuevo">
                        <template #titulo-sub-tutorial>
                            Ciclo lectivo nuevo
                        </template>

                        <template #informacion>
                            Este paso debe hacerlo si o si antes de los dos pasos que le siguen porque sino puede llegar a cometer un error que no tiene 
                            vuelta atras y es eliminar accidentalmente la ultima libreta de un alumno o de muchos, depende cuantos alumnos estuvieron haciendo 
                            repetir y haciendo pasar de año.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/ZIgNB9Rs6Ss"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="repitentes">
                        <template #titulo-sub-tutorial>
                            Repitentes
                        </template>

                        <template #informacion>
                            Ingresar a la lista de alumnos de cada division, ingresar al perfil de los alumnos y hacer el proceso para haceerlos repetir. 
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/ZIgNB9Rs6Ss"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="nuevo-curso">
                        <template #titulo-sub-tutorial>
                            Pasar de año
                        </template>

                        <template #informacion>
                            Ingresar a la lista de alumnos de cada division, ingresar al perfil de los alumnos e ir a la parte de "cambiar de curso".
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

        title: 'Gescol - Tutoriales - Como empezar un ciclo lectivo nuevo',
    }
</script>