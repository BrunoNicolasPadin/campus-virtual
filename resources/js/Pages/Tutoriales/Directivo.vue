<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Directivos</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#registrarse">Registrarse como directivo</a></li>
                    <li>2) <a class="hover:underline" href="#eliminarte">Eliminarte como directivo</a></li>
                    <li>3) <a class="hover:underline" href="#anotarte">Anotarse en una institución</a></li>
                    <li>4) <a class="hover:underline" href="#eliminar">Eliminar directivo de mi institución</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="registrarse">
                        <template #titulo-sub-tutorial>
                            Registrarse como directivo
                        </template>

                        <template #informacion>
                            -No podrá registrarse como directivo nuevamente en la misma institución pero si con otro rol. <br>

                            -Si podrá registrarse en otra institución con el rol de directivo sin ningún problema.
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/qMDHh5ke9Mg" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminarte">
                        <template #titulo-sub-tutorial>
                            Eliminarse como directivo
                        </template>

                        <template #informacion>
                            -Ingresar en "Cuentas". <br>
                            
                            -Deberás tener la cuenta activada que desee eliminar.
                        </template>

                        <template #contenido-video>
                            <a :href="'../storage/Tutoriales/Directivo/Eliminar.png'" target="_blank">
                                <img :src="'../storage/Tutoriales/Directivo/Eliminar.png'" class="border" alt="Eliminar" title="Eliminar" />
                            </a> <br>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="anotarte">
                        <template #titulo-sub-tutorial>
                            Anotarse en una institución
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

                    <detalles-tutorial id="eliminar">
                        <template #titulo-sub-tutorial>
                            Eliminar directivo de mi institución
                        </template>

                        <template #informacion>
                            Si el directivo tiene la clave de acceso y la sabe, podrá ingresar cuantas veces quiera a menos que usted cambie la clave de acceso. <br>
                            No sucederá nada con todos los usuarios que ya están inscriptos en su institución si la cambia.
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/YFkSjJ-Si7M" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
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

        title: 'Gescol - Tutorial - Directivos',
    }
</script>