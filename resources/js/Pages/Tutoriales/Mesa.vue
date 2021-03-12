<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Mesas y asignaturas adeudadas</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#agregar-mesa">Agregar mesas</a></li>
                    <li>2) <a class="hover:underline" href="#agregar-alumno">Agregar asignatura/s que debe rendir un alumno</a></li>
                    <li>3) <a class="hover:underline" href="#inscribirse">Inscribirse a rendir</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="agregar-mesa">
                        <template #titulo-sub-tutorial>
                            Agregar mesa de examen
                        </template>

                        <template #informacion>
                            -Para agregar, editar y eliminar archivos, peso máximo (20MB) y tipos de archivos permitidos es el mismo que para las evaluaciones. <br>
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/HYpQWX5tWmk" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="agregar-alumno">
                        <template #titulo-sub-tutorial>
                            Agregar asignatura/s que debe rendir un alumno
                        </template>

                        <template #informacion>
                            -Debe realizar este proceso para que el alumno pueda inscribirse en una mesa y rendir. <br>
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/ItVETSogBPs" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="inscribirse">
                        <template #titulo-sub-tutorial>
                            Inscribirse
                        </template>

                        <template #informacion>
                            -No se puede inscribir el mismo día y hora de la mesa de examen y no puede inscribirse o desinscribirse luego de la misma. <br>

                            -Solo puede inscribirse el alumno desde su propia cuenta y no desde la del madre, padre o tutor. <br>

                            -Subir correcciones, calificar y subir entrega es igual que con cualquier evaluación. <br>

                            -El alumno y los padres de estos serán avisados por medio de un email de la calificación, comentario y corrección/es. <br>
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/CqdynJIvk9k" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
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

        title: 'Gescol - Tutorial - Mesas',
    }
</script>