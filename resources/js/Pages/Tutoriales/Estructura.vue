<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Estructura</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#agregar">Agregar</a></li>
                    <li>2) <a class="hover:underline" href="#eliminar">Eliminar</a></li>
                    <li>3) <a class="hover:underline" href="#limpiar">Limpiar</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="agregar">
                        <template #titulo-sub-tutorial>
                            Agregar
                        </template>

                        <template #informacion>
                            -Si la/s orientación/es de tu institución no están en la lista pónganse en contacto con nosotros (En la pagina de inicio hay un formulario de Contacto) 
                            para así agregarla. Puede registrar sus divisiones sin problema y luego editar la orientación una vez que la hayamos agregado (le avisaremos) <br>

                            -Las claves de acceso son solo cuando un alumno se crea su cuenta y cuando quiere pasar a otra división. <br>

                            -Recomendación: escriba todas las claves de acceso de cada división para no olvidárselas. <br>

                            -Formas de evaluación: se mostraran las creadas por usted. <br>

                            -Periodos: solo puede elegir entre esas tres opciones, si en su institución utilizan otra comuniquese con nosotros para asi agregarla. <br>
                        </template>

                        <template #contenido-video>
                            <a :href="'../storage/Tutoriales/Estructura/Ingresar.png'" target="_blank">
                                <img :src="'../storage/Tutoriales/Estructura/Ingresar.png'" class="border" alt="Ingresar" title="Ingresar" />
                            </a> <br>

                            <video-embed src="https://youtu.be/HjrH6M4yjHY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar">
                        <template #titulo-sub-tutorial>
                            Eliminar
                        </template>

                        <template #informacion>
                            -No la elimine aunque en la vida real no exista más, no paga nada adicional por la cantidad de divisiones que tenga, solo limpiela (abajo se explica) <br>
                            
                            -Si elimina una división automáticamente se eliminarán las libretas de todos los alumnos que pasaron por allí, asignaturas, evaluaciones, 
                            materiales, archivos de correcciones, entregas, publicaciones en el muro y sus respectivas respuestas. Esto afectara a sus estadísticas.
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="limpiar">
                        <template #titulo-sub-tutorial>
                            Limpiar
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

        title: 'Gescol - Tutorial - Estructuras',
    }
</script>