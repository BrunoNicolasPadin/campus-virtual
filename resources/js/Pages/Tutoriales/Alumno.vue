<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Alumnos</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#registrarse">Registrarse como alumno</a></li>
                    <li>2) <a class="hover:underline" href="#eliminarte">Eliminarte como alumno</a></li>
                    <li>3) <a class="hover:underline" href="#anotarte">Anotarte en una institución</a></li>
                    <li>4) <a class="hover:underline" href="#eliminar-division">Eliminar alumno de una división</a></li>
                    <li>5) <a class="hover:underline" href="#eliminar">Eliminar alumno de mi institución</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="registrarse">
                        <template #titulo-sub-tutorial>
                            Registrarse como alumno
                        </template>

                        <template #informacion>
                            -No podrá registrarse como alumno nuevamente en la misma institución pero si con otro rol. <br>

                            -Si podrá registrarse en otra institución con el rol de alumno sin ningún problema.
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/lqtRVHzrX7A" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminarte">
                        <template #titulo-sub-tutorial>
                            Eliminarte como alumno
                        </template>

                        <template #informacion>
                            -Ingresar en "Cuentas". <br>
                            
                            -Deberás tener la cuenta activada que desee eliminar.
                        </template>

                        <template #contenido-video>
                            <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Tutoriales/Alumno/Eliminar.png'" target="_blank">
                                <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Tutoriales/Alumno/Eliminar.png'" class="border" alt="Eliminar" title="Eliminar" />
                            </a> <br>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="anotarte">
                        <template #titulo-sub-tutorial>
                            Anotarte en una institución
                        </template>

                        <template #informacion>
                            -Ingresar en "Buscador de colegios". <br>

                            -Escriba el nombre del colegio en el cual quiera anotarse y luego apriete en "Anotarse".
                        </template>

                        <template #contenido-video>
                            <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Tutoriales/Directivo/Anotarse.png'" target="_blank">
                                <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Tutoriales/Directivo/Anotarse.png'" class="border" alt="Anotarse" title="Anotarse" />
                            </a> <br>

                            <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Tutoriales/Directivo/Anotarse_2.png'" target="_blank">
                                <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Tutoriales/Directivo/Anotarse_2.png'" class="border" alt="Anotarse_2" title="Anotarse_2" />
                            </a> <br>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar-division">
                        <template #titulo-sub-tutorial>
                            Eliminar alumno de una división
                        </template>

                        <template #informacion>
                            -No podrá ingresar en la división a menos que sepa la clave de acceso y si la sabe usted debe cambiarla en "Divisiones -> Editar".
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/0b7nMYhLnm8" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar">
                        <template #titulo-sub-tutorial>
                            Eliminar alumno de mi institución
                        </template>

                        <template #informacion>
                            -Se eliminara todo de este alumno: entregas, inscripciones a mesas, libreta y deja de contar en las estadísticas. <br>

                            -Si solo desea eliminarlo como alumno de una división vea el video del anterior punto. <br>
                            
                            -Si el alumno tiene la clave de acceso y la sabe, podrá ingresar cuantas veces quiera a menos que cambie la clave de acceso.
                            No sucederá nada con todos los usuarios que ya están inscriptos en su institución al cambiar la clave.
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/trQvSxgJab8" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
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

        title: 'Gescol - Tutorial - Alumnos',
    }
</script>