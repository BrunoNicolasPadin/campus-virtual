<template>
    <div class="antialiased bg-blue-50 mx-auto px-4 sm:px-8 py-5">
        <nav class="bg-blue-50 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 my-2">
                    <div v-if="autenticado" class="space-x-8 sm:my-5 sm:ml-10 sm:flex">
                        <inertia-link :href="route('dashboard')" class="text-lg text-indigo-800 font-bold hover:underline">Campus</inertia-link>
                    </div>
                    <div v-else>
                        <inertia-link :href="route('login.formulario')" class="text-lg text-indigo-800 font-bold hover:underline">Ingresar</inertia-link>
                        <inertia-link :href="route('registrarse.formulario')" class="ml-4 text-lg text-indigo-800 font-bold hover:underline">Registrarse</inertia-link>
                    </div>
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <div class="ml-3 relative">
                            <jet-dropdown align="right" width="48">
                                <template #trigger>
                                    <button v-if="$page.jetstream.managesProfilePhotos" class="flex text-lg border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                        <img class="h-8 w-8 rounded-full object-cover" :src="$page.user.profile_photo_url" :alt="$page.user.name" />
                                    </button>

                                    <button v-else class="flex items-center text-lg font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                        <div>{{ $page.user.name }}</div>

                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </template>

                                <template #content>
                                    <!-- Account Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Configuracion
                                    </div>

                                    <jet-dropdown-link :href="route('profile.show')">
                                        Perfil
                                    </jet-dropdown-link>

                                    <jet-dropdown-link :href="route('api-tokens.index')" v-if="$page.jetstream.hasApiFeatures">
                                        API Tokens
                                    </jet-dropdown-link>

                                    <div class="border-t border-gray-100"></div>

                                    <!-- Authentication -->
                                    <form @submit.prevent="logout">
                                        <jet-dropdown-link as="button">
                                            Salir
                                        </jet-dropdown-link>
                                    </form>
                                </template>
                            </jet-dropdown>
                        </div>
                    </div>

                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div v-if="autenticado" :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="flex items-center px-4">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" :src="$page.user.profile_photo_url" :alt="$page.user.name" />
                        </div>

                        <div class="ml-3">
                            <div class="font-medium text-base text-gray-800">{{ $page.user.name }}</div>
                            <div class="font-medium text-lg text-gray-500">{{ $page.user.email }}</div>
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <jet-responsive-nav-link :href="route('profile.show')" :active="route().current('profile.show')">
                            Perfil
                        </jet-responsive-nav-link>

                        <jet-responsive-nav-link :href="route('api-tokens.index')" :active="route().current('api-tokens.index')" v-if="$page.jetstream.hasApiFeatures">
                            API Tokens
                        </jet-responsive-nav-link>

                        <!-- Authentication -->
                        <form method="POST" @submit.prevent="logout">
                            <jet-responsive-nav-link as="button">
                                Salir
                            </jet-responsive-nav-link>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <div class="antialiased bg-blue-50 container mx-auto px-4 sm:px-8 ">
            <div class="w-full mx-auto">
                <div class="relative z-10 pb-8 sm:pb-16 md:pb-20 lg:max-w-full lg:w-full lg:pb-28 xl:pb-10">
                    <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-5 sm:px-6 md:mt-5 lg:mt-5 lg:px-8 xl:mt-5">
                        <div class="text-center">
                            <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                                <span class="block xl:inline">Modernizá tu colegio</span>
                                <span class="block text-indigo-600 xl:inline">con Gescol</span>
                            </h1>
                            <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl">
                                Conectá a tus directivos, docentes, alumnos, padres y madres en un solo lugar y permití que accedan a la información relacionada a 
                                los exámenes, tareas, trabajos prácticos, libretas de calificaciones, estadísticas y más, todo cuando ellos lo deseen.
                            </p>
                        </div>
                    </main>
                </div>
            </div>

            <div class="py-5">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="lg:text-center">
                        <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                            Servicios a $10 + IVA por alumno
                        </p>
                    </div>
            
                    <div class="mt-10">
                        <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    <!-- Heroicon name: globe-alt -->
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <dt class="text-lg leading-6 font-bold text-indigo-600">
                                        Evaluaciones
                                    </dt>
                                    <dd class="mt-2 text-base text-gray-500">
                                        Los docentes podrán crear exámenes, tareas y trabajos prácticos; los alumnos realizar entregas, 
                                        que serán corregidas y calificadas por los docentes, subiendo la entrega corregida si así desean. 
                                        También los alumnos tendrán la posibilidad de resolver sus dudas con los docentes en los comentarios.
                                    </dd>
                                </div>
                            </div>
            
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                        <!-- Heroicon name: scale -->
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <dt class="text-lg leading-6 font-bold text-indigo-600">
                                        Materiales
                                    </dt>
                                    <dd class="mt-2 text-base text-gray-500">
                                        Los docente podrán subir archivos PDFs, WORDs, PowerPoint, imágenes, videos, etc... 
                                        para que los alumnos puedan descargarlos y los tengan en un solo lugar. 
                                        Los podrán dejar allí para que los nuevos alumnos también accedan a ellos y así evitar que el docente 
                                        los tenga que volver a subir.
                                    </dd>
                                </div>
                            </div>

                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    <!-- Heroicon name: globe-alt -->
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <dt class="text-lg leading-6 font-bold text-indigo-600">
                                        Libretas
                                    </dt>
                                    <dd class="mt-2 text-base text-gray-500">
                                        Cada alumno contará con una libreta en la que los directivos subirán las notas de la libreta 
                                        para cada periodo (bimestre, trimestre, cuatrimestre) junto con la nota final en cada materia.
                                    </dd>
                                </div>
                            </div>
            
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                        <!-- Heroicon name: scale -->
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <dt class="text-lg leading-6 font-bold text-indigo-600">
                                        Padres
                                    </dt>
                                    <dd class="mt-2 text-base text-gray-500">
                                        Los padres vincularan su cuenta a la de su/s hijo/s y verán lo mismo que ellos así no se les escapa nada.
                                    </dd>
                                </div>
                            </div>

                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    <!-- Heroicon name: globe-alt -->
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <dt class="text-lg leading-6 font-bold text-indigo-600">
                                        Calendario
                                    </dt>
                                    <dd class="mt-2 text-base text-gray-500">
                                        Poseerá un calendario con las fechas de los exámenes, trabajos prácticos, tareas y mesas para rendir.
                                    </dd>
                                </div>
                            </div>
            
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                        <!-- Heroicon name: scale -->
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <dt class="text-lg leading-6 font-bold text-indigo-600">
                                        Estadísticas
                                    </dt>
                                    <dd class="mt-2 text-base text-gray-500">
                                        Accederá a estadísticas por ciclo lectivo dentro de cada división, asignatura y alumno por bimestre/trimestre/cuatrimestre. 
                                        Cantidad de alumnos que repiten o abandonan, dividido por ciclo lectivo y división.
                                    </dd>
                                </div>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-center">
                <!-- <div class="rounded-full px-4 py-2 border border-indigo-500">
                    <span class="text-2xl font-bold text-indigo-500">Precio: $10 por alumno</span>
                </div> <br> -->

                <button type="button" class="border border-indigo-500 bg-indigo-500 text-white rounded-full px-4 py-2 transition duration-500 ease select-none hover:bg-indigo-700 focus:outline-none focus:shadow-outline">
                    <inertia-link :href="route('suscripciones.detalles')">¿Quiere ver imágenes de lo descripto? Apriete aquí</inertia-link>
                </button>
                <!-- <button type="button" class="border border-green-500 bg-green-500 text-white rounded-full px-4 py-2 transition duration-500 ease select-none hover:bg-green-700 focus:outline-none focus:shadow-outline">
                    <inertia-link :href="route('tutoriales')">Tutoriales</inertia-link>
                </button> -->

                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-center">
                <!-- <div class="rounded-full px-4 py-2 border border-indigo-500">
                    <span class="text-2xl font-bold text-indigo-500">Precio: $10 por alumno</span>
                </div> <br> -->

                <p class="mt-3 my-2 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl">
                    ¿Quiere adquirirlo? Vaya al formulario de contacto que se encuentra debajo y seleccione como asunto Quiero adquirir el servicio’ y 
                    escribanos para obtener el servicio, puede escribirnos también sus dudas que nosotros con gusto se la responderemos.
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

            <div class="py-5">
                <div class="lg:text-center">
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Nosotros
                    </p>
                </div>
                <div class="pt-6 pb-8 px-4 sm:px-8 my-2 mb-4">
                    <p class="mt-3 text-gray-900 leading-loose">
                        Gescol surge de mi interés por la educación y de que esta mejore, ya que es muy importante para el progreso de un país. 
                        También surge de mi experiencia en el colegio y en la universidad. <br>

                        Cuando iba a la escuela no teníamos ninguna página de internet donde enterarnos de las fechas de las evaluaciones, 
                        enviar nuestros trabajos prácticos, recibir las correcciones, hacer preguntas al profesor, descargar material y 
                        demás cosas que hubiesen hecho mas fácil y organizada nuestra vida en el colegio, algo que seguramente todos deseamos para 
                        nosotros, nuestros alumnos, amigos, hijos, docentes y etc… <br>

                        Luego en la universidad había un “campus virtual” pero tenía (tiene) un diseño espantoso, se caía cuando nos queríamos inscribir 
                        en alguna materia, demasiados tramites y procesos no estaban digitalizados, sumado a que pocos docentes lo utilizaban y tiene todo lo que, 
                        en la misma universidad te enseñan, un sistema NO debe tener. <br>
                        
                        Teniendo todo esto en mente pensaba en los bien que le haría a los colegios y sus miembros al tener un servicio como Gescol, 
                        un sitio web en el cual podrán ir digitalizando poco a poco los procesos que hoy en día hacen en papel o en tablas Excel y 
                        facilitarle la vida a todas las personas que forman una institución educativa.
                    </p>

                    <hr class="my-5">
                </div>
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
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import JetNavLink from '@/Jetstream/NavLink'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'
    import FlashMessages from '@/Shared/FlashMessages.vue'

    export default {
        components: {
            JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,
            EstructuraForm,
            LabelForm,
            InputForm,
            Info,
            Guardar,
            FlashMessages,
        },

        props: {
            autenticado: Boolean,
        },

        title: 'Gescol - Inicio',

        data() {
            return {
                form: {
                    email: null,
                    asunto: null,
                    mensaje: null,
                },
                showingNavigationDropdown: false,
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('contacto.enviar_email'), this.form)
            },

            switchToTeam(team) {
                this.$inertia.put(route('current-team.update'), {
                    'team_id': team.id
                }, {
                    preserveState: false
                })
            },

            logout() {
                axios.post(route('logout').url()).then(response => {
                    window.location = '/';
                })
            },
        },
    }
</script>
