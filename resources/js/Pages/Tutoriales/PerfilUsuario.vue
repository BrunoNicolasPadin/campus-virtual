<template>
    <estructura>
        <template #contenido>
            <titulo-lista>
                <template #titulo-tutorial>Perfil de usuario</template>

                <template #lista-tutorial>
                    <li>1) <a class="hover:underline" href="#editar">Editar nombre y agregar datos</a></li>
                    <li>2) <a class="hover:underline" href="#eliminar">Eliminar</a></li>
                </template>

                <template #detalles>
                    <detalles-tutorial id="editar">
                        <template #titulo-sub-tutorial>
                            Editar
                        </template>

                        <template #contenido-video>
                            <div class="text-center relative" style="padding-top: 56.25%">
                                <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/bPLz8uX7XA4" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </template>
                    </detalles-tutorial>

                    <detalles-tutorial id="eliminar">
                        <template #titulo-sub-tutorial>
                            Eliminar
                        </template>

                        <template #informacion>
                            -Está debajo de todo en "Perfil". <br>

                            -Se elimina complemtamente el usuario y se deberá crear otro nuevamente. <br>
                        </template>

                        <template #contenido-video>
                            <a :href="'../storage/Tutoriales/Usuario/Eliminar.png'" target="_blank">
                                <img :src="'../storage/Tutoriales/Usuario/Eliminar.png'" class="border" alt="Eliminar" title="Eliminar" />
                            </a> <br>
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

        title: 'Gescol - Tutorial - Perfil de usuario',
    }
</script>