<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Repitentes</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#agregar">Hacer repetir a un alumno y ver números</a></li>
                    <li>2) <a class="hover:underline" href="#eliminar">Eliminar repitente</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="agregar">
                        <template #titulo-sub-tutorial>
                            Hacer repetir a un alumno
                        </template>

                        <template #informacion>
                            -Esto sirve más que nada para la estadística. <br>

                             -La división en la que estará anotado será la misma que acaba de repetir, si desea que sea otra, desde el perfil del alumno 
                             vaya a "Cambiar de curso" y seleccione la división e ingrese la clave correspondiente. En el caso de no acordarse la clave, 
                             vaya a la división del alumno, en el apartado "Alumnos - Ver" encontrara un botón que dice "Hacerlos pasar", seleccione 
                             solo a ese alumno y listo.<br>

                            -Debe hacerlo una vez activado el nuevo ciclo lectivo en el que cursara, no antes. En el caso de haberlo hecho contáctese 
                            con nosotros para solucionar el problema. <br>
                        </template>

                        <template #contenido-video>
                            <video-embed src="https://youtu.be/HjrH6M4yjHY"></video-embed>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar">
                        <template #titulo-sub-tutorial>
                            Eliminar de la lista de repitentes
                        </template>

                        <template #informacion>
                            -En el caso de haber equivocado de repitente deberá eliminarlo y ponerlo en la división que le corresponde.
                            En el primer punto, a partir de "si desea que sea otra," se explica como hacerlo.
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

        title: 'Gescol - Tutorial - Repitentes',
    }
</script>