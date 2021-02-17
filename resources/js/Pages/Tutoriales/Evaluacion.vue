<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Evaluacion</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#agregar-evaluacion">Agregar evaluacion</a></li>
                    <li>2) <a class="hover:underline" href="#editar-evaluacion">Editar evaluacion</a></li>
                    <li>3) <a class="hover:underline" href="#eliminar-evaluacion">Eliminar evaluacion</a></li>
                    <li>4) <a class="hover:underline" href="#agregar-archivo">Agregar archivo</a></li>
                    <li>5) <a class="hover:underline" href="#editar-archivo">Editar archivo</a></li>
                    <li>6) <a class="hover:underline" href="#eliminar-archivo">Eliminar archivo</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="agregar-evaluacion">
                        <template #titulo-sub-tutorial>
                            Agregar evaluacion
                        </template>

                        <template #informacion>
                            Al crear una evaluacion, se le cargara en la base de datos una entrega correspondiente a cada alumno que este anotado en ese momento en la division. Si ingresa un alumno nuevo luego de crear la evaluacion, no tendra ninguna entrega para realizar.
                            Debe apretar en "OK" luego de seleccionar la fecha y hora deseada.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/HjrH6M4yjHY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="editar-evaluacion">
                        <template #titulo-sub-tutorial>
                            Editar evaluacion
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
                            Eliminar evaluacion
                        </template>

                        <template #informacion>
                            Se eliminaran los archivos entregados por los alumnos, tus correcciones y los archivos cargados a la evaluacion.
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
                            Se puede agregar uno o mas archivos. Tambien se puede cambiar de archivo si se equivoco al subirlo o si se equivoco y en realidad no quiere agregar otro puede "eliminar el formulario" de ese nuevo archivo.
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