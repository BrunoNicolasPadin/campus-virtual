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
                    <li>7) <a class="hover:underline" href="#anotar-docentes">Anotar a los docentes en las asignaturas que les corresponde o dejar que ellos lo hagan</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="registrar-institucion">
                        <template #titulo-sub-tutorial>
                            Registrar tu institución
                        </template>

                        <template #informacion>
                            Recomendación: anotar la clave de acceso para no olvidarsela.
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/zSnPtw3crIM" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="registrar-ciclo-lectivo">
                        <template #titulo-sub-tutorial>
                            Registrar un ciclo lectivo
                        </template>

                        <template #informacion>
                            -Ingresamos desde "Institucional -> Ciclos lectivos". <br>
                            
                            -Al crear un ciclo lectivo activado, hará que el resto se desactive. <br>

                            -Si es el segundo ciclo lectivo que creará, antes de crearlo verifique que haya cumplido los pasos de "<inertia-link class="hover:underline" :href="route('tutoriales.nuevo_ciclo_lectivo')">¿Está por comenzar un ciclo lectivo nuevo? Sigue estos pasos</inertia-link>".
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

                    <detalles-tutorial id="registrar-forma-evaluacion">
                        <template #titulo-sub-tutorial>
                            Registrar formas de evaluación
                        </template>

                        <template #informacion>
                            -Ingresamos desde "Institucional -> Perfil institucional". <br>

                            -Al crear una división deberá seleccionar una forma de evaluación, que contendrá las distintas calificaciones que podrán utilizar los docentes para evaluar a sus alumnos. <br>

                            -Dentro de cada forma de evaluación podrá ver las divisiones en las cuales esta aplicada y las opciones de calificación que tiene (en el caso de las "Escritas") y poder editarlas o eliminarlas.
                        </template>

                        <template #contenido-video>
                            <a :href="'../storage/Tutoriales/Institucion/Editar_1.png'" target="_blank">
                                <img :src="'../storage/Tutoriales/Institucion/Editar_1.png'" class="border" alt="Editar_1" title="Editar_1" />
                            </a> <br>

                            <a :href="'../storage/Tutoriales/FormaEvaluacion/Ingresar.png'" target="_blank">
                                <img :src="'../storage/Tutoriales/FormaEvaluacion/Ingresar.png'" class="border" alt="Ingresar" title="Ingresar" />
                            </a> <br>

                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/aL8-tzkJ6p4" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="registrar-estructura">
                        <template #titulo-sub-tutorial>
                            Registrar estructura
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

                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/mQQ7QpKHbFQ" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="registrar-asignaturas">
                        <template #titulo-sub-tutorial>
                            Registrar todas las asignaturas de cada división
                        </template>

                        <template #informacion>
                            -Puede hacerlo sin tener docentes inscriptos en su institución, luego los podrá agregar (o ellos mismos lo podrán hacer) y 
                            así estos podrán ingresar a la/s división/es en las que son docentes de una o mas asignaturas. <br>
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/EMYcLxJjZek" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="registrar-docentes">
                        <template #titulo-sub-tutorial>
                            Que los docentes se registren
                        </template>

                        <template #informacion>
                            -No podrá registrarse como docente nuevamente en la misma institución pero si con otro rol. <br>

                            -Si podrá registrarse en otra institución con el rol de docente sin ningún problema. <br>
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/CcMqWoB71G0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="anotar-docentes">
                        <template #titulo-sub-tutorial>
                            Anotar a los docentes en las asignaturas que les corresponde o dejar que ellos lo hagan
                        </template>

                        <template #informacion>
                            -Le permitirá a los docentes ingresar a la división. <br>
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/yAqEes3qjXs" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>

                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/yAqEes3qjXs" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
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

        title: 'Gescol - Tutoriales - Primeros pasos',
    }
</script>