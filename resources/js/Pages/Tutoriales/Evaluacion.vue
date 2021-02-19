<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Evaluaciones</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#agregar-evaluacion">Agregar evaluación</a></li>
                    <li>2) <a class="hover:underline" href="#editar-evaluacion">Editar evaluación</a></li>
                    <li>3) <a class="hover:underline" href="#eliminar-evaluacion">Eliminar evaluación</a></li>
                    <li>4) <a class="hover:underline" href="#agregar-archivo">Agregar archivo</a></li>
                    <li>5) <a class="hover:underline" href="#editar-archivo">Editar archivo</a></li>
                    <li>6) <a class="hover:underline" href="#eliminar-archivo">Eliminar archivo</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="agregar-evaluacion">
                        <template #titulo-sub-tutorial>
                            Agregar evaluación
                        </template>

                        <template #informacion>
                            Al crear una evaluación, se le cargará en la base de datos una entrega correspondiente a cada alumno que esté anotado en ese 
                            momento en la división. Si ingresa un alumno nuevo luego de crear la evaluación, no tendrá ninguna entrega para realizar. <br>
                            Debe apretar en "OK" luego de seleccionar la fecha y hora deseada.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/HjrH6M4yjHY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="editar-evaluacion">
                        <template #titulo-sub-tutorial>
                            Editar evaluación
                        </template>

                        <template #informacion>
                            Debe apretar en "OK" luego de CAMBIAR la fecha y hora deseada para que se actualice.
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/mEr8WG6JChc"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar-evaluacion">
                        <template #titulo-sub-tutorial>
                            Eliminar evaluación
                        </template>

                        <template #informacion>
                            Se eliminarán los archivos entregados por los alumnos, tus correcciones y los archivos cargados a la evaluación.
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/Gfgdj-kD8YY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="agregar-archivo">
                        <template #titulo-sub-tutorial>
                            Agregar archivo
                        </template>

                        <template #informacion>
                            Se puede agregar uno o mas archivos. También se puede cambiar de archivo si se equivocó al subirlo o si se equivocó y en realidad 
                            no quiere agregar otro puede "eliminar el formulario" de ese nuevo archivo.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/HjrH6M4yjHY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="editar-archivo">
                        <template #titulo-sub-tutorial>
                            Editar archivo
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/mEr8WG6JChc"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar-archivo">
                        <template #titulo-sub-tutorial>
                            Eliminar archivo
                        </template>

                        <template #informacion>
                            Se eliminará para siempre y no podra ser recueperado.
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

        title: 'Gescol - Tutorial - Evaluaciones',
    }
</script>