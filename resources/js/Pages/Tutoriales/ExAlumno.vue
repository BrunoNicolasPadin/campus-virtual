<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Ex alumnos</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#agregar">Transformar a ex alumno y ver números</a></li>
                    <li>2) <a class="hover:underline" href="#eliminar">Eliminar</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="agregar">
                        <template #titulo-sub-tutorial>
                            Transformar en ex alumno
                        </template>

                        <template #informacion>
                            -Pasará a desinscribirse de la división en la que este actualmente con lo cual no podrá ingresar a la división nunca mas. <br> 
                            
                            -Solo podrá ingresar a todo lo que se encuentre en su perfil y a las mesas de las asignaturas que debe rendir. <br>

                            -Números: solo se tiene en cuenta a los alumnos que abandonaron el colegio. <br>
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/yAqEes3qjXs" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar">
                        <template #titulo-sub-tutorial>
                            Eliminar de la lista de ex alumnos (ATENCION ACA)
                        </template>

                        <template #informacion>
                            -Si se equivocó de alumno tendrá un problema: <br>
                            
                            -Al volver a anotarlo en la división correspondiente se creará una nueva libreta con todas las asignaturas de esa división, 
                            si el alumno ya tiene una libreta en la base de datos con el ciclo lectivo que esta actualmente activado, se borrara la 
                            libreta ya existente y aparecerá una nueva en blanco. <br>
                            
                            -Recomendación: antes de volver a anotarlo en la división correspondiente, anote o saque una captura de pantalla de la libreta  
                            correspondiente al ciclo lectivo actualmente activad para así luego pasar las calificaciones nuevamente, no perderá nada más 
                            que tiempo. Eso sí, le llegara un email por cada calificación ingresada al alumno y sus padres.
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

        title: 'Gescol - Tutorial - Ex alumnos',
    }
</script>