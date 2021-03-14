<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Instituciones</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#registrarse">Crear institución</a></li>
                    <li>2) <a class="hover:underline" href="#editar">Editar</a></li>
                    <li>3) <a class="hover:underline" href="#eliminar">Eliminar</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="registrarse">
                        <template #titulo-sub-tutorial>
                            Crear institución
                        </template>

                        <template #informacion>
                            -Recomendación: anotar la clave de acceso para no olvidarsela. <br>
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/zSnPtw3crIM" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="editar">
                        <template #titulo-sub-tutorial>
                            Editar
                        </template>

                        <template #informacion>
                            -En "Perfil institucional". <br>
                        </template>

                        <template #contenido-video>
                            <a :href="'../storage/Tutoriales/Institucion/Editar_1.png'" target="_blank">
                                <img :src="'../storage/Tutoriales/Institucion/Editar_1.png'" class="border" alt="Editar 1" title="Editar 1" />
                            </a> <br>

                            <a :href="'../storage/Tutoriales/Institucion/Editar_2.png'" target="_blank">
                                <img :src="'../storage/Tutoriales/Institucion/Editar_2.png'" class="border" alt="Editar 2" title="Editar 2" />
                            </a> <br>

                            <a :href="'../storage/Tutoriales/Institucion/Editar_3.png'" target="_blank">
                                <img :src="'../storage/Tutoriales/Institucion/Editar_3.png'" class="border" alt="Editar 3" title="Editar 3" />
                            </a> <br>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar">
                        <template #titulo-sub-tutorial>
                            Eliminar
                        </template>

                        <template #informacion>
                            -En "Perfil institucional". <br>

                            -Si lo hace se borrara absolutamente todo y no se podrá recuperar. <br>
                        </template>

                        <template #contenido-video>
                            <a :href="'institucion/Eliminar.png'" target="_blank">
                                <img :src="'institucion/Eliminar.png'" class="border" alt="Eliminar institucion" title="Eliminar institucion" />
                            </a>
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

        title: 'Gescol - Tutorial - Instituciones',
    }
</script>