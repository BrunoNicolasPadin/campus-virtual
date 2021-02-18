<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Estructura</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#agregar">Agregar</a></li>
                    <li>2) <a class="hover:underline" href="#editar">Editar</a></li>
                    <li>3) <a class="hover:underline" href="#eliminar">Eliminar</a></li>
                    <li>3) <a class="hover:underline" href="#limpiar">Limpiar</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="agregar">
                        <template #titulo-sub-tutorial>
                            Agregar
                        </template>

                        <template #informacion>
                            Recomendacion: escriba todas las claves de acceso de cada division.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/HjrH6M4yjHY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="editar">
                        <template #titulo-sub-tutorial>
                            Editar
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/mEr8WG6JChc"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar">
                        <template #titulo-sub-tutorial>
                            Eliminar
                        </template>

                        <template #informacion>
                            No la elimine aunque en la vida real no exista mas, no paga nada adicional por la cantidad de divisiones que tenga ;).
                            Si elimina una division automaticamente se eliminaran las libretas de todos los alumnos que pasaron por aqui, asignaturas, evaluaciones, 
                            materiales, archivos de correcciones, entregas, publicaciones en el muro y sus respectivas respuestas. 
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/Gfgdj-kD8YY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="limpiar">
                        <template #titulo-sub-tutorial>
                            Limpiar
                        </template>

                        <template #informacion>
                            Se eliminaran las evaluaciones, archivos de evaluaciones, comentarios y respuestas de evaluaciones, entregas, correcciones, 
                            comentarios de entregas, publicaciones, respuestas y archivos del muro. 
                            El resto se mantiene: materiales, asignaturas, docentes, alumnos, repitentes y estadisticas.
                        </template>

                        <template #contenido-video>
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
    }
</script>