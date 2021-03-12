<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Calendario</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#mostrar">Mostrar</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="mostrar">
                        <template #titulo-sub-tutorial>
                            Mostrar
                        </template>

                        <template #informacion>
                            -La institución y los directivos pueden ver todo. <br>

                            -Los alumnos solo las evaluaciones de la división de la que forman parte y las mesas en las que están anotados. <br>
                            
                            -Los padres lo mismo que el hijo que tengan activado. <br>

                            -Los docentes las evaluaciones y mesas de las asignaturas en las que son docente. <br>
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/8yRtZ8KhFIo" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
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

        title: 'Gescol - Tutorial - Calendario',
    }
</script>