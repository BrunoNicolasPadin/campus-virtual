<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Ciclos lectivos</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#agregar">Agregar</a></li>
                    <li>2) <a class="hover:underline" href="#editar">Editar</a></li>
                    <li>3) <a class="hover:underline" href="#eliminar">Eliminar</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="agregar">
                        <template #titulo-sub-tutorial>
                            Agregar
                        </template>

                        <template #informacion>
                            -Ingresamos desde "Institucional -> Ciclos lectivos". <br>
                            
                            -Al crear un ciclo lectivo activado, hará que el resto se desactive. <br>

                            -Si es el segundo ciclo lectivo que creará, antes de crearlo verifique que haya cumplido los pasos de "<inertia-link class="hover:underline" :href="route('tutoriales.nuevo_ciclo_lectivo')">¿Está por comenzar un ciclo lectivo nuevo? Sigue estos pasos</inertia-link>".
                        </template>

                        <template #contenido-video>
                            <a :href="'../https://gescol.s3-sa-east-1.amazonaws.com/Tutoriales/CicloLectivo/Ingresar.png'" target="_blank">
                                <img :src="'../https://gescol.s3-sa-east-1.amazonaws.com/Tutoriales/CicloLectivo/Ingresar.png'" class="border" alt="Ingresar" title="Ingresar" />
                            </a> <br>

                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/bGRRzjsqfVg" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="editar">
                        <template #titulo-sub-tutorial>
                            Editar
                        </template>

                        <template #informacion>
                            -Si al editar un ciclo lectivo lo coloca como "activado" se desactivarán los otros.
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar">
                        <template #titulo-sub-tutorial>
                            Eliminar
                        </template>

                        <template #informacion>
                            -Si elimina el ciclo lectivo se eliminarán las libretas creadas para este ciclo (lo cual afectaría a las estadísticas), 
                            las asignaturas adeudadas que tienen los alumnos en el ciclo lectivo eliminado, registros de la lista de ex alumnos y repetidores.
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

        title: 'Gescol - Tutorial - Ciclos lectivos',
    }
</script>