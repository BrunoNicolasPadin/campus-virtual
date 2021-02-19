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
                            Cada tipo de cuenta ve algo distinto. La institución y los directivos pueden ver todo.
                            Los alumnos solo las evaluaciones de la división de la que forman parte y las mesas en las que están anotados.
                            Los padres lo mismo que el hijo que tengan activado.
                            Los docentes las evaluaciones y mesas de las asignaturas en las que son docente.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/HjrH6M4yjHY"></video-embed>
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