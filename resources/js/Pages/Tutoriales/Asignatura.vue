<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Asignaturas</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#agregar-asignatura">Agregar asignaturas</a></li>
                    <li>2) <a class="hover:underline" href="#editar-asignatura">Editar asignatura</a></li>
                    <li>3) <a class="hover:underline" href="#eliminar-asignatura">Eliminar asignatura</a></li>
                    <li>4) <a class="hover:underline" href="#agregar-docente">Agregar docente</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="agregar-asignatura">
                        <template #titulo-sub-tutorial>
                            Agregar asignaturas
                        </template>

                        <template #informacion>
                            -Puede hacerlo sin tener docentes inscriptos en su institución, luego los podrá agregar (o ellos mismos lo podrán hacer) y así estos podrán ingresar a 
                            la/s división/es en las que son docentes de una o mas asignaturas.
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/EMYcLxJjZek" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="editar-asignatura">
                        <template #titulo-sub-tutorial>
                            Editar asignatura
                        </template>

                        <template #informacion>
                            -Desde aquí podrá eliminar horarios y docentes, no permitiéndoles a estos ingresar a esta división a menos que sean docente en otra asignatura. <br>
                            
                            -Si no desea eliminar nada y solo cambiarlos también puede hacerlo desde allí pero recuerde apretar el botón "Guardar". <br>
                        </template>

                        <template #contenido-video>
                            <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Tutoriales/Asignatura/Editar.png'" target="_blank">
                                <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Tutoriales/Asignatura/Editar.png'" class="border" alt="Editar" title="Editar" />
                            </a> <br>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar-asignatura">
                        <template #titulo-sub-tutorial>
                            Eliminar asignatura
                        </template>

                        <template #informacion>
                            -Se eliminará todo lo relacionado a la asignatura: horarios, materiales, mesas de examen, evaluaciones, entregas, correcciones, 
                            desaparecerá de las libretas, dejará de contar en la estadística.
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="agregar-docente">
                        <template #titulo-sub-tutorial>
                            Agregar docente
                        </template>

                        <template #informacion>
                            -Le permitirá a los docentes ingresar a la división.
                        </template>

                        <template #contenido-video>
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

        title: 'Gescol - Tutorial - Asignaturas',
    }
</script>