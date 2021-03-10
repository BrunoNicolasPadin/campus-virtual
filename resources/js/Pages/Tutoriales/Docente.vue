<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Docentes</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#registrarse">Registrarse como docente</a></li>
                    <li>2) <a class="hover:underline" href="#eliminarte">Eliminarte como docente</a></li>
                    <li>3) <a class="hover:underline" href="#anotarte">Anotarte en una institución</a></li>
                    <li>4) <a class="hover:underline" href="#agregarte">Agregarte como docente de una o mas asignaturas</a></li>
                    <li>5) <a class="hover:underline" href="#eliminar">Eliminar docente de mi institución</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="registrarse">
                        <template #titulo-sub-tutorial>
                            Registrarse como docente
                        </template>

                        <template #informacion>
                            -No podrá registrarse como docente nuevamente en la misma institución pero si con otro rol. <br>

                            -Si podrá registrarse en otra institución con el rol de docente sin ningún problema.
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/CcMqWoB71G0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminarte">
                        <template #titulo-sub-tutorial>
                            Eliminarte como docente
                        </template>

                        <template #informacion>
                            -Ingresar en "Cuentas". <br>
                            
                            -Deberás tener la cuenta activada que desee eliminar.
                        </template>

                        <template #contenido-video>
                            <a :href="'../storage/Tutoriales/Docente/Eliminar.png'" target="_blank">
                                <img :src="'../storage/Tutoriales/Docente/Eliminar.png'" class="border" alt="Eliminar" title="Eliminar" />
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
                            <a :href="'../storage/Tutoriales/Directivo/Anotarse.png'" target="_blank">
                                <img :src="'../storage/Tutoriales/Directivo/Anotarse.png'" class="border" alt="Anotarse" title="Anotarse" />
                            </a> <br>

                            <a :href="'../storage/Tutoriales/Directivo/Anotarse_2.png'" target="_blank">
                                <img :src="'../storage/Tutoriales/Directivo/Anotarse_2.png'" class="border" alt="Anotarse_2" title="Anotarse_2" />
                            </a> <br>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="registrarse">
                        <template #titulo-sub-tutorial>
                            Agregarte como docente de una o mas asignaturas
                        </template>

                        <template #informacion>
                            -Podra acceder a cada división de cada asignatura en la que es docente. <br>
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/CcMqWoB71G0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar">
                        <template #titulo-sub-tutorial>
                            Eliminar docente de mi institución
                        </template>

                        <template #informacion>
                            -Esto lo elimina completamente de la institución, no se eliminará nada de la/s asignatura/s en las que fue docente. <br>
                            
                            -Si solo desea eliminarlo como docente de una asignatura debe ver el menu de la izquierda y apretar en "Asignatura" y luego en "Eliminar docente". <br>
                            
                            -Si el docente tiene la clave de acceso y la sabe, podrá ingresar cuantas veces quiera a menos que cambie la clave de acceso.
                            No sucederá nada con todos los usuarios que ya están inscriptos en su institución al cambiar la clave.
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/56jZ99IHFvs" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
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

        title: 'Gescol - Tutorial - Docentes',
    }
</script>