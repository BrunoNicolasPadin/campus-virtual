<template>
    <div class="min-h-screen bg-blue-50 py-2">
        <nav class="bg-blue-50 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 my-2">
                    <div class="space-x-8 sm:my-5 sm:ml-10 sm:flex">
                        <inertia-link target="_blank" :href="route('inicio')" class="text-lg text-indigo-800 font-bold hover:underline">Inicio</inertia-link>
                        <inertia-link target="_blank" :href="route('tutoriales')" class="text-lg text-indigo-800 font-bold hover:underline">Tutoriales</inertia-link>
                    </div>
                </div>
            </div>
        </nav>

        <div class="py-1">
            
            <div class="container mx-auto px-4 sm:px-8 text-left">

                <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                    <span class="text-indigo-600">Detalles de los servicios</span>
                </h1>
                <span class="text-md tracking-tight font-bold text-gray-700">
                    <ul>
                        <li><a href="#ciclos-lectivos">1) Ciclos lectivos</a></li>
                        <li><a href="#estructura">2) Estructura</a></li>
                        <li><a href="#evaluaciones-entregas-numeros">3) Evaluaciones, entregas y numeros</a></li>
                        <li><a href="#materiales">4) Materiales</a></li>
                        <li><a href="#libreta">5) Libreta</a></li>
                        <li><a href="#estadisticas">6) Estadísticas</a></li>
                        <li><a href="#repitentes-exalumnos">7) Repitentes y ex alumnos</a></li>
                        <li><a href="#calendario">8) Calendario</a></li>
                        <li><a href="#asignaturas">9) Asignaturas y mesas</a></li>
                        <li><a href="#muro">10) Muro</a></li>
                    </ul>
                </span>

                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-center">
                <p class="mt-3 my-2 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl">
                    ¿Quiere adquirirlo? Vaya al formulario de contacto que se encuentra debajo y seleccione como asunto Quiero adquirir el servicio’ y 
                    escribanos para obtener el servicio, puede escribirnos también sus dudas que nosotros con gusto se la responderemos.
                </p>

                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-left">
                <h1 class="text-2xl tracking-tight font-semibold text-gray-900">
                    <span class="text-black" id="ciclos-lectivos">Ciclos lectivos:</span>
                </h1>

                <p class="my-4 text-gray-500 font-semibold text-lg">
                    -Puedes crear cuantos ciclos lectivos desees.
                </p>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/CicloLectivo.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/CicloLectivo.png'" class="border" alt="Ciclo lectivo" title="Ciclo lectivo" />
                </a>

                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-left">
                <h1 class="text-2xl tracking-tight font-bold text-gray-900">
                    <span class="text-black" id="estructura">Estructura:</span>
                </h1>

                <p class="my-4 text-gray-500 font-semibold text-lg">
                    -Puedes crear las divisiones que desees.
                </p>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/Estructura.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/Estructura.png'" class="border" alt="Estructura" title="Estructura" />
                </a>

                <p class="my-4 text-gray-500 font-semibold text-lg">
                    -Este es el menu principal de cada división desde el cual podrás acceder a todos lados.
                </p>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/EstructuraShow.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/EstructuraShow.png'" class="border" alt="Estructura" title="Estructura" />
                </a>

                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-left">
                <h1 class="text-2xl tracking-tight font-bold text-gray-900">
                    <span id="evaluaciones-entregas-numeros">Evaluaciones, entregas y números:</span>
                </h1>

                <p class="my-4 text-gray-500 font-semibold text-lg">
                    -Cada docente podrá agregar las evaluaciones (examen, trabajo practico o tarea) que desee.
                </p>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/Evaluaciones.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/Evaluaciones.png'" class="border" alt="Evaluaciones" title="Evaluaciones" />
                </a>

                <p class="my-4 text-gray-500 font-semibold text-lg">
                    -Este es el menu dentro de cada evaluación.
                </p>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/EvaluacionesShow.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/EvaluacionesShow.png'" class="border" alt="Evaluaciones" title="Evaluaciones" />
                </a>

                <p class="my-4 text-gray-500 font-semibold text-lg">
                    -El listado de entregas de los alumnos.
                </p>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/Entregas.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/Entregas.png'" class="border" alt="Entregas" title="Entregas" />
                </a>

                <p class="my-4 text-gray-500 font-semibold text-lg">
                    -Dentro de cada entrega se podrá calificar, subir entregas, correcciones y realizar comentarios.
                </p>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/EntregasShow.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/EntregasShow.png'" class="border" alt="Entregas" title="Entregas" />
                </a>

                <p class="my-4 text-gray-500 font-semibold text-lg">
                    -En cada evaluación, el docente y los directivos podrán acceder al apartado "números" y verán distintos listados que resumen el estado 
                    de las entregas y correcciones.
                </p>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/Numeros1.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/Numeros1.png'" class="border" alt="Numeros" title="Numeros" />
                </a><br><br>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/Numeros2.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/Numeros2.png'" class="border" alt="Numeros" title="Numeros" />
                </a>

                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-left">
                <h1 class="text-2xl tracking-tight font-bold text-gray-900">
                    <span class="text-black" id="materiales">Materiales:</span>
                </h1>

                <p class="my-4 text-gray-500 font-semibold text-lg">
                    -Podrá crear grupos de materiales y subir archivos (max. 20MB por archivo) para que los alumnos los puedan ver y descargar.
                </p>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/Grupos.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/Grupos.png'" class="border" alt="Grupos" title="Grupos" />
                </a><br><br>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/GruposShow.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/GruposShow.png'" class="border" alt="Grupos" title="Grupos" />
                </a>

                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-left">
                <h1 class="text-2xl tracking-tight font-bold text-gray-900">
                    <span class="text-black" id="libreta">Libreta:</span>
                </h1>

                <p class="my-4 text-gray-500 font-semibold text-lg">
                    -Cada alumno tiene una libreta por ciclo lectivo en el cual podras cargar las calificaciones.
                </p>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/Libreta.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/Libreta.png'" class="border" alt="Libreta" title="Libreta" />
                </a>
                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-left">
                <h1 class="text-2xl tracking-tight font-bold text-gray-900">
                    <span class="text-black" id="estadisticas">Estadísticas división, asignatura, alumno, abandonos y repeticiones:</span>
                </h1>

                <p class="my-4 text-gray-500 font-semibold text-lg">
                    -Cada división tiene su apartado para ver las estadísticas, en la cual se promedian todas las calificaciones de los alumnos, 
                    separadas por periodo (bimestre, trimestre, cuatrimestre) del ciclo lectivo seleccionado.
                </p>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/EstadisticasDivision.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/EstadisticasDivision.png'" class="border" alt="Estadisticas Division" title="Estadisticas Division" />
                </a>

                <p class="my-4 text-gray-500 font-semibold text-lg">
                    -Para las divisiones que se califican con "palabras" como: excelente, muy bien, no satisfactorio, aprobado, desaprobado, etc...
                </p>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/PalabrasDivision.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/PalabrasDivision.png'" class="border" alt="Estadisticas Division" title="Estadisticas Division" />
                </a>

                <p class="my-4 text-gray-500 font-semibold text-lg">
                    -Sucede lo mismo que para las estadísticas de la división pero solo con una asignatura y accedible nada mas para el/los docentes de 
                    la materia. También podrá ver las calificaciones de sus alumnos en su materia.
                </p>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/EstadisticasAsignatura.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/EstadisticasAsignatura.png'" class="border" alt="Estadisticas Asignatura" title="Estadisticas Asignatura" />
                </a>

                <p class="my-4 text-gray-500 font-semibold text-lg">
                    -Para las asignaturas que se califican con "palabras"
                </p>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/PalabrasAsignatura.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/PalabrasAsignatura.png'" class="border" alt="Estadisticas Asignatura" title="Estadisticas Asignatura" />
                </a>

                <p class="my-4 text-gray-500 font-semibold text-lg">
                    -Los alumnos podrán ver su promedio por periodo.
                </p>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/EstadisticasAlumno.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/EstadisticasAlumno.png'" class="border" alt="Estadisticas Alumno" title="Estadisticas Alumno" />
                </a>

                <p class="my-4 text-gray-500 font-semibold text-lg">
                    -Para los alumnos que las calificaciones en la libreta son con palabras
                </p>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/PalabrasAlumno.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/PalabrasAlumno.png'" class="border" alt="Estadisticas Alumno" title="Estadisticas Alumno" />
                </a>

                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-left">
                <h1 class="text-2xl tracking-tight font-bold text-gray-900">
                    <span class="text-black" id="repitentes-exalumnos">Repitentes y ex alumnos:</span>
                </h1>

                <p class="my-4 text-gray-500 font-semibold text-lg">
                    -Podrás cargar en una lista los alumnos que repitieron, terminaron el colegio, se cambiaron de escuela o se graduaron. <br><br>
                </p>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/Repitentes.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/Repitentes.png'" class="border" alt="Repitentes" title="Repitentes" />
                </a><br><br>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/ExAlumnos.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/ExAlumnos.png'" class="border" alt="Ex Alumnos" title="Ex Alumnos" />
                </a>

                <p class="my-4 text-gray-500 font-semibold text-lg">
                    -Tendrás acceso a estadísticas para ex alumnos que abandonaron el colegio y de repitentes.
                </p>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/EstadisticasAbandonos.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/EstadisticasAbandonos.png'" class="border" alt="Estadisticas Abandonos" title="Estadisticas Abandonos" />
                </a><br><br>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/EstadisticasRepetidores.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/EstadisticasRepetidores.png'" class="border" alt="Estadisticas Repetidores" title="Estadisticas Repetidores" />
                </a>

                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-left">
                <h1 class="text-2xl tracking-tight font-bold text-gray-900">
                    <span class="text-black" id="calendario">Calendario:</span>
                </h1>

                <p class="my-4 text-gray-500 font-semibold text-lg">
                    -Todos contarán con un calendario especial para cada tipo de cuenta.
                </p>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/Calendario.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/Calendario.png'" class="border" alt="Calendario" title="Calendario" />
                </a>
                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-left">
                <h1 class="text-2xl tracking-tight font-bold text-gray-900">
                    <span class="text-black" id="asignaturas">Asignaturas y mesas para rendir:</span>
                </h1>

                <p class="my-4 text-gray-500 font-semibold text-lg">
                    -Le podrás informar a tus alumnos que materias se llevan, las mesas que hay para que puedan inscribirse y lo mismo que en cada 
                    evaluación: subir su entrega, recibir correcciones, comentarios y la calificación.
                </p>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/Asignaturas.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/Asignaturas.png'" class="border" alt="Asignaturas" title="Asignaturas" />
                </a><br><br>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/Mesas.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/Mesas.png'" class="border" alt="Mesas" title="Mesas" />
                </a><br><br>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/MesasShow.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/MesasShow.png'" class="border" alt="Mesas" title="Mesas" />
                </a><br><br>

                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-left">
                <h1 class="text-2xl tracking-tight font-bold text-gray-900">
                    <span class="text-black" id="muro">Muro de la división, respuestas y archivos:</span>
                </h1>

                <p class="my-4 text-gray-500 font-semibold text-lg">
                    -Cada división contará con un muro en el cual podrán publicar todos lo que desean y asi agilizar la comunicación.
                </p>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/Muro.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/Muro.png'" class="border" alt="Muro" title="Muro" />
                </a><br><br>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/MuroArchivos.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/MuroArchivos.png'" class="border" alt="Muro Archivos" title="Muro Archivos" />
                </a><br><br>

                <a :href="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/MesasShow.png'" target="_blank">
                    <img :src="'https://gescol.s3-sa-east-1.amazonaws.com/Detalles/MuroRespuestas.png'" class="border" alt="Muro Respuestas" title="Muro Respuestas" />
                </a><br><br>

                <hr class="my-5">
            </div>
        </div>

        <div class="my-2 container mx-auto px-4 sm:px-8 text-center">
            <p class="mt-3 my-2 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl">
                ¿Quiere adquirirlo? Vaya al formulario de contacto que se encuentra debajo y seleccione como asunto ‘Adquirir servicio’ y 
                escriba de que desea ponerse en contacto con nosotros para poder obtener el servicio y también escrita las preguntas que tiene sobre 
                el producto.
            </p>

            <hr class="my-5">
        </div>

        <div class="py-5">
                <div class="lg:text-center">
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Contacto
                    </p>
                </div>
                <flash-messages></flash-messages>
                <div class="pt-6 pb-8 px-4 sm:px-8 my-2 mb-4">
                    <estructura-form>
                        <template #formulario>
                            <form method="post" @submit.prevent="submit">
                                
                                <div class="-mx-3 md:flex mb-6">
                                    <div class="md:w-full px-3 mb-6 md:mb-0">
                                        
                                        <label-form>
                                            <template #label-value>
                                                Email
                                            </template>
                                        </label-form>
                                        
                                        <input-form required type="email" v-model="form.email" />
                                        
                                        <info>
                                            <template #info>
                                                Es obligatorio.
                                            </template>
                                        </info>
                                    </div>
                                </div>
                                <div class="-mx-3 md:flex mb-6">
                                    <div class="md:w-full px-3">
                                        
                                        <label-form>
                                            <template #label-value>
                                                Motivo
                                            </template>
                                        </label-form>
                                        
                                        <select 
                                        required
                                        v-model="form.asunto"
                                        class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3">
                                            <option disabled value="">-</option>
                                            <option value="Adquirir servicio">Quiero adquirir el servicio</option>
                                            <option value="Problema">Tengo un problema</option>
                                            <option value="Error">Encontré un error</option>
                                            <option value="Nueva idea">Tengo una idea para el sitio</option>
                                            <option value="Cambiar forma de pago">Quiero cambiar la forma/metodo de pago</option>
                                            <option value="Problema para pagar">No tengo dinero ahora mismo</option>
                                            <option value="Cambios en la cantidad de alumnos">Aumento/Reducción en cantidad de alumnos</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                        
                                        <info>
                                            <template #info>
                                                Es obligatorio.
                                            </template>
                                        </info>
                                    </div>
                                </div>

                                <div class="-mx-3 md:flex mb-6">
                                    <div class="md:w-full px-3">
                                        <label-form>
                                            <template #label-value>
                                                Mensaje
                                            </template>
                                        </label-form>
                                        
                                        <textarea
                                            required
                                            class="appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                            cols="30" 
                                            rows="5" v-model="form.mensaje"></textarea>
                                        
                                        <info>
                                            <template #info>
                                                Es obligatorio.
                                            </template>
                                        </info>
                                    </div>
                                </div>

                                <guardar></guardar>
                                <span class="text-black text-md">
                                    o enviar un mensaje a <span class="underline">3413154714</span>.
                                </span>
                            </form>
                        </template>
                    </estructura-form>

                    <hr class="my-5">
                </div>
            </div>
    </div>
</template>

<script>
    import EstructuraForm from '@/Formulario/EstructuraForm.vue'
    import LabelForm from '@/Formulario/LabelForm.vue'
    import InputForm from '@/Formulario/InputForm.vue'
    import Info from '@/Formulario/Info.vue'
    import Guardar from '@/Botones/Guardar.vue'
    import FlashMessages from '@/Shared/FlashMessages.vue'

    export default {
        components: {
            EstructuraForm,
            LabelForm,
            InputForm,
            Info,
            Guardar,
            FlashMessages,
        },

        title: 'Gescol - Detalles de los servicios',

        data() {
            return {
                form: {
                    email: null,
                    asunto: null,
                    mensaje: null,
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('contacto.enviar_email'), this.form)
            },
        },
    }
</script>
