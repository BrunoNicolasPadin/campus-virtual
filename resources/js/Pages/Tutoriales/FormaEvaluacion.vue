<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Formas de evaluación</template>

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

                            <video-embed src="https://youtu.be/26YEJA_QXD4"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="editar">
                        <template #titulo-sub-tutorial>
                            Editar
                        </template>

                        <template #informacion>
                            -Recomendación: no cambie una forma de evaluación de tipo "Escrita" a una "Numérica" o "Porcentual" y viceversa, 
                            ya que afectara a las estadísticas, salvo que no haya cargado ninguna calificación todavía.
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar">
                        <template #titulo-sub-tutorial>
                            Eliminar
                        </template>

                        <template #informacion>
                            -Antes de eliminar una "Forma de evaluación" (no una calificación/opción) deberá asignarles otra a las divisiones 
                            que poseen esta forma de evaluación, de lo contrario deberá revisar división por división para ver cual tiene en 
                            blanco su forma de evaluación.
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

        title: 'Gescol - Tutorial - Formas de evaluación',
    }
</script>