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
                        <li><a href="#calendario">7) Calendario</a></li>
                        <li><a href="#asignaturas">8) Asignaturas y mesas</a></li>
                        <li><a href="#muro">9) Muro</a></li>
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
                <h1 class="text-2xl tracking-tight font-bold text-gray-900">
                    <span class="text-black" id="ciclos-lectivos">Ciclos lectivos:</span>
                </h1>

                <a :href="'storage/detalles/cicloLectivo.png'" target="_blank">
                    <img :src="'storage/detalles/CicloLectivo.png'" class="border" alt="Ciclo lectivo" title="Ciclo lectivo" />
                </a>

                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-left">
                <h1 class="text-2xl tracking-tight font-bold text-gray-900">
                    <span class="text-black" id="estructura">Estructura:</span>
                </h1>

                <a :href="'storage/detalles/Estructura.png'" target="_blank">
                    <img :src="'storage/detalles/Estructura.png'" class="border" alt="Estructura" title="Estructura" />
                </a>

                <a :href="'storage/detalles/EstructuraShow.png'" target="_blank">
                    <img :src="'storage/detalles/EstructuraShow.png'" class="border" alt="Estructura" title="Estructura" />
                </a>

                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-left">
                <h1 class="text-2xl tracking-tight font-bold text-gray-900">
                    <span id="evaluaciones-entregas-numeros">Evaluaciones, entregas y números:</span>
                </h1>

                <a :href="'storage/detalles/Evaluaciones.png'" target="_blank">
                    <img :src="'storage/detalles/Evaluaciones.png'" class="border" alt="Evaluaciones" title="Evaluaciones" />
                </a>

                <a :href="'storage/detalles/EvaluacionesShow.png'" target="_blank">
                    <img :src="'storage/detalles/EvaluacionesShow.png'" class="border" alt="Evaluaciones" title="Evaluaciones" />
                </a>

                <a :href="'storage/detalles/Entregas.png'" target="_blank">
                    <img :src="'storage/detalles/Entregas.png'" class="border" alt="Entregas" title="Entregas" />
                </a>

                <a :href="'storage/detalles/EntregasShow.png'" target="_blank">
                    <img :src="'storage/detalles/EntregasShow.png'" class="border" alt="Entregas" title="Entregas" />
                </a>

                <a :href="'storage/detalles/Numeros1.png'" target="_blank">
                    <img :src="'storage/detalles/Numeros1.png'" class="border" alt="Numeros" title="Numeros" />
                </a>

                <a :href="'storage/detalles/Numeros2.png'" target="_blank">
                    <img :src="'storage/detalles/Numeros2.png'" class="border" alt="Numeros" title="Numeros" />
                </a>

                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-left">
                <h1 class="text-2xl tracking-tight font-bold text-gray-900">
                    <span class="text-black" id="materiales">Materiales:</span>
                </h1>

                <a :href="'storage/detalles/Grupos.png'" target="_blank">
                    <img :src="'storage/detalles/Grupos.png'" class="border" alt="Grupos" title="Grupos" />
                </a>

                <a :href="'storage/detalles/GruposShow.png'" target="_blank">
                    <img :src="'storage/detalles/GruposShow.png'" class="border" alt="Grupos" title="Grupos" />
                </a>

                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-left">
                <h1 class="text-2xl tracking-tight font-bold text-gray-900">
                    <span class="text-black" id="libreta">Libreta:</span>
                </h1>

                <a :href="'storage/detalles/Libreta.png'" target="_blank">
                    <img :src="'storage/detalles/Libreta.png'" class="border" alt="Libreta" title="Libreta" />
                </a>
                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-left">
                <h1 class="text-2xl tracking-tight font-bold text-gray-900">
                    <span class="text-black" id="estadisticas">Estadísticas división, asignatura, alumno, abandonos y repeticiones:</span>
                </h1>

                <a :href="'storage/detalles/EstadisticasDivision.png'" target="_blank">
                    <img :src="'storage/detalles/EstadisticasDivision.png'" class="border" alt="Estadisticas Division" title="Estadisticas Division" />
                </a>

                <a :href="'storage/detalles/EstadisticasAsignatura.png'" target="_blank">
                    <img :src="'storage/detalles/EstadisticasAsignatura.png'" class="border" alt="Estadisticas Asignatura" title="Estadisticas Asignatura" />
                </a>

                <a :href="'storage/detalles/EstadisticasAlumno.png'" target="_blank">
                    <img :src="'storage/detalles/EstadisticasAlumno.png'" class="border" alt="Estadisticas Alumno" title="Estadisticas Alumno" />
                </a>

                <a :href="'storage/detalles/EstadisticasAbandonos.png'" target="_blank">
                    <img :src="'storage/detalles/EstadisticasAbandonos.png'" class="border" alt="Estadisticas Abandonos" title="Estadisticas Abandonos" />
                </a>

                <a :href="'storage/detalles/EstadisticasRepetidores.png'" target="_blank">
                    <img :src="'storage/detalles/EstadisticasRepetidores.png'" class="border" alt="Estadisticas Repetidores" title="Estadisticas Repetidores" />
                </a>

                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-left">
                <h1 class="text-2xl tracking-tight font-bold text-gray-900">
                    <span class="text-black" id="calendario">Calendario:</span>
                </h1>

                <a :href="'storage/detalles/Calendario.png'" target="_blank">
                    <img :src="'storage/detalles/Calendario.png'" class="border" alt="Calendario" title="Calendario" />
                </a>
                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-left">
                <h1 class="text-2xl tracking-tight font-bold text-gray-900">
                    <span class="text-black" id="asignaturas">Asignaturas y mesas para rendir:</span>
                </h1>

                <a :href="'storage/detalles/Asignaturas.png'" target="_blank">
                    <img :src="'storage/detalles/Asignaturas.png'" class="border" alt="Asignaturas" title="Asignaturas" />
                </a>

                <a :href="'storage/detalles/Mesas.png'" target="_blank">
                    <img :src="'storage/detalles/Mesas.png'" class="border" alt="Mesas" title="Mesas" />
                </a>

                <a :href="'storage/detalles/MesasShow.png'" target="_blank">
                    <img :src="'storage/detalles/MesasShow.png'" class="border" alt="Mesas" title="Mesas" />
                </a>

                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-left">
                <h1 class="text-2xl tracking-tight font-bold text-gray-900">
                    <span class="text-black" id="muro">Muro de la división, respuestas y archivos:</span>
                </h1>

                <a :href="'storage/detalles/Muro.png'" target="_blank">
                    <img :src="'storage/detalles/Muro.png'" class="border" alt="Muro" title="Muro" />
                </a>

                <a :href="'storage/detalles/MuroArchivos.png'" target="_blank">
                    <img :src="'storage/detalles/MuroArchivos.png'" class="border" alt="Muro Archivos" title="Muro Archivos" />
                </a>

                <a :href="'storage/detalles/MesasShow.png'" target="_blank">
                    <img :src="'storage/detalles/MuroRespuestas.png'" class="border" alt="Muro Respuestas" title="Muro Respuestas" />
                </a>

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
