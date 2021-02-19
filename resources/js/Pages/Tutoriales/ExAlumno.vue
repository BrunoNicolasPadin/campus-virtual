<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Ex alumnos</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#agregar">Transformar a ex alumno</a></li>
                    <li>2) <a class="hover:underline" href="#editar">Editar ex alumno</a></li>
                    <li>3) <a class="hover:underline" href="#eliminar">Eliminar</a></li>
                    <li>4) <a class="hover:underline" href="#numeros">Números</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="agregar">
                        <template #titulo-sub-tutorial>
                            Transformar en ex alumno
                        </template>

                        <template #informacion>
                            Esto sirve mas que nada a la estadística. Solo pasará a no estar anotado en ninguna división automaticamente 
                            con lo cual no podrá ingresar a la división, solo podrá ingresar a todo lo que se encuentre en su perfil.
                        </template>

                        <template #contenido-video>
                            <video-embed class="w-screen" src="https://youtu.be/HjrH6M4yjHY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="editar">
                        <template #titulo-sub-tutorial>
                            Editar ex alumno
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/mEr8WG6JChc"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar">
                        <template #titulo-sub-tutorial>
                            Eliminar de la lista de ex alumnos (ATENCION ACA)
                        </template>

                        <template #informacion>
                            Solo saldrá de la lista. Si se equivocó de alumno tendrá un problema: al volver a anotarlo en la división correspondiente 
                            se creará una nueva libreta con todas las asignaturas de esa división, si el alumno ya tiene una libreta en la base de datos
                            con el mismo ciclo lectivo que esta actualmente activado, se borrara la ya existente y aparecerá una nueva en blanco.
                            Recomendación: antes de volver a anotarlo en la división correspondiente, anote o saque una captura de pantalla de la libreta para 
                            luego pasar las calificaciones nuevamente, no perderá nada más que tiempo. 
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/Gfgdj-kD8YY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="numeros">
                        <template #titulo-sub-tutorial>
                            Numeros
                        </template>

                        <template #informacion>
                            Se basa en los alumnos que abandonaron la institución nada más, no en los que cambiaron de institución.
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

        title: 'Gescol - Tutorial - Ex alumnos',
    }
</script>