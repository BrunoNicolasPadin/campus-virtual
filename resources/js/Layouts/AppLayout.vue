<template>
    <div class="h-auto bg-blue-50">
        <nav class="h-auto bg-blue-100 border-b border-gray-100">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <inertia-link :href="route('dashboard')">
                                <jet-application-mark class="block h-9 w-auto" />
                            </inertia-link>
                        </div>

                        <!-- Navigation Links -->
                        
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <jet-nav-link :href="route('inicio')" :active="route().current('inicio')">
                                Inicio
                            </jet-nav-link>
                            <jet-nav-link :href="route('topNav.divisiones')" :active="route().current('divisiones.index')">
                                Divisiones
                            </jet-nav-link>
                            <jet-nav-link :href="route('roles.mostrarCuentas')" :active="route().current('roles.mostrarCuentas')">
                                Cuentas
                            </jet-nav-link>
                            <jet-nav-link :href="route('buscador_de_instituciones')" :active="route().current('buscador_de_instituciones')">
                                Buscador de colegios
                            </jet-nav-link>
                            <div class="hidden sm:flex sm:items-center sm:ml-6">
                                <div class="ml-3 relative">
                                    <jet-dropdown align="right">
                                        <template #trigger>
                                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                                <div>Institucional</div>

                                                <div class="ml-1">
                                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </button>
                                        </template>

                                        <template #content>
                                             <jet-dropdown-link :href="route('topNav.calendario')" :active="route().current('calendario.mostrar')">
                                                Calendario
                                            </jet-dropdown-link>
                                            <jet-dropdown-link :href="route('topNav.ciclos_lectivos')" :active="route().current('ciclos-lectivos.index')">
                                                Ciclos lectivos
                                            </jet-dropdown-link>
                                            <jet-dropdown-link :href="route('topNav.roles')" :active="route().current('roles.index')">
                                                Roles
                                            </jet-dropdown-link>
                                            <jet-dropdown-link :href="route('topNav.institucion')" :active="route().current('instituciones.show')">
                                                Perfil institucional
                                            </jet-dropdown-link>
                                        </template>
                                    </jet-dropdown>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <div class="ml-3 relative">
                            <jet-dropdown align="right" width="48">
                                <template #trigger>
                                    <button v-if="$page.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                        <img class="h-8 w-8 rounded-full object-cover" :src="$page.user.profile_photo_url" :alt="$page.user.name" />
                                    </button>

                                    <button v-else class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
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

                                    <!-- Team Management -->
                                    <template v-if="$page.jetstream.hasTeamFeatures">
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Manage Team
                                        </div>

                                        <!-- Team Settings -->
                                        <jet-dropdown-link :href="route('teams.show', $page.user.current_team)">
                                            Team Settings
                                        </jet-dropdown-link>

                                        <jet-dropdown-link :href="route('teams.create')" v-if="$page.jetstream.canCreateTeams">
                                            Create New Team
                                        </jet-dropdown-link>

                                        <div class="border-t border-gray-100"></div>

                                        <!-- Team Switcher -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Switch Teams
                                        </div>

                                        <template v-for="team in $page.user.all_teams">
                                            <form @submit.prevent="switchToTeam(team)" :key="team.id">
                                                <jet-dropdown-link as="button">
                                                    <div class="flex items-center">
                                                        <svg v-if="team.id == $page.user.current_team_id" class="mr-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                        <div>{{ team.name }}</div>
                                                    </div>
                                                </jet-dropdown-link>
                                            </form>
                                        </template>

                                        <div class="border-t border-gray-100"></div>
                                    </template>

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

                    <!-- Hamburger -->
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

            <!-- Responsive Navigation Menu -->
            <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <jet-responsive-nav-link :href="route('inicio')" :active="route().current('inicio')">
                        Inicio
                    </jet-responsive-nav-link>
                    <jet-responsive-nav-link :href="route('topNav.divisiones')" :active="route().current('divisiones.index')">
                        Divisiones
                    </jet-responsive-nav-link>
                    <jet-responsive-nav-link :href="route('buscador_de_instituciones')" :active="route().current('buscador_de_instituciones')">
                        Buscador de colegios
                    </jet-responsive-nav-link>
                    <jet-responsive-nav-link :href="route('roles.mostrarCuentas')" :active="route().current('roles.mostrarCuentas')">
                        Cuentas
                    </jet-responsive-nav-link>
                    <div class="flex items-center px-4">
                        <div class="ml-3">
                            <div class="font-medium text-base text-gray-800">Institucional</div>
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <jet-responsive-nav-link :href="route('topNav.calendario')" :active="route().current('calendario.mostrar')">
                            Calendario
                        </jet-responsive-nav-link>
                        <jet-responsive-nav-link :href="route('topNav.ciclos_lectivos')" :active="route().current('ciclos-lectivos.index')">
                            Ciclos lectivos
                        </jet-responsive-nav-link>
                        <jet-responsive-nav-link :href="route('topNav.roles')" :active="route().current('roles.index')">
                            Roles
                        </jet-responsive-nav-link>
                        <jet-responsive-nav-link :href="route('topNav.institucion')" :active="route().current('instituciones.show')">
                            Perfil institucional
                        </jet-responsive-nav-link>
                    </div>
                </div>

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="flex items-center px-4">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" :src="$page.user.profile_photo_url" :alt="$page.user.name" />
                        </div>

                        <div class="ml-3">
                            <div class="font-medium text-base text-gray-800">{{ $page.user.name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.user.email }}</div>
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

                        <!-- Team Management -->
                        <template v-if="$page.jetstream.hasTeamFeatures">
                            <div class="border-t border-gray-200"></div>

                            <div class="block px-4 py-2 text-xs text-gray-400">
                                Manage Team
                            </div>

                            <!-- Team Settings -->
                            <jet-responsive-nav-link :href="route('teams.show', $page.user.current_team)" :active="route().current('teams.show')">
                                Team Settings
                            </jet-responsive-nav-link>

                            <jet-responsive-nav-link :href="route('teams.create')" :active="route().current('teams.create')">
                                Create New Team
                            </jet-responsive-nav-link>

                            <div class="border-t border-gray-200"></div>

                            <!-- Team Switcher -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                Switch Teams
                            </div>

                            <template v-for="team in $page.user.all_teams">
                                <form @submit.prevent="switchToTeam(team)" :key="team.id">
                                    <jet-responsive-nav-link as="button">
                                        <div class="flex items-center">
                                            <svg v-if="team.id == $page.user.current_team_id" class="mr-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <div>{{ team.name }}</div>
                                        </div>
                                    </jet-responsive-nav-link>
                                </form>
                            </template>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        <header class="h-auto bg-blue-100 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <slot name="header"></slot>
            </div>
        </header>

        <!-- Page Content -->
        <main class="h-auto">
            <flash-messages></flash-messages>
            <slot></slot>
        </main>

        <!-- Modal Portal -->
        <portal-target name="modal" multiple>
        </portal-target>

        <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@iconscout/unicons@3.0.6/css/line.css"> -->

        <footer class="bg-gray-800 pt-10 sm:mt-10 pt-10 h-screen">
            <div class="max-w-6xl m-auto text-gray-800 flex flex-wrap justify-left">
                <!-- Col-1 -->
                <div class="p-5 w-1/2 sm:w-4/12 md:w-3/12">
                    <!-- Col Title -->
                    <div class="text-xs uppercase text-gray-400 font-medium mb-6">
                        Para instituciones
                    </div>

                    <!-- Links -->
                    <inertia-link :href="route('tutoriales.como_empezar')" class="my-3 block text-gray-300 hover:text-gray-100 text-sm font-medium duration-700">
                        ¿Cómo empezar?
                    </inertia-link>
                    <inertia-link :href="route('tutoriales.nuevo_ciclo_lectivo')" class="my-3 block text-gray-300 hover:text-gray-100 text-sm font-medium duration-700">
                        ¿Está por comenzar un ciclo lectivo nuevo? Sigue estos pasos
                    </inertia-link>
                    <inertia-link :href="route('tutoriales.institucion')" class="my-3 block text-gray-300 hover:text-gray-100 text-sm font-medium duration-700">
                        Institución
                    </inertia-link>
                    <inertia-link :href="route('tutoriales.ciclo_lectivo')" class="my-3 block text-gray-300 hover:text-gray-100 text-sm font-medium duration-700">
                        Ciclos lectivos
                    </inertia-link>
                    <inertia-link :href="route('tutoriales.estructura')" class="my-3 block text-gray-300 hover:text-gray-100 text-sm font-medium duration-700">
                        Estructuras
                    </inertia-link>
                    <inertia-link :href="route('tutoriales.asignatura')" class="my-3 block text-gray-300 hover:text-gray-100 text-sm font-medium duration-700">
                        Asignaturas
                    </inertia-link>
                </div>

                <!-- Col-2 -->
                <div class="p-5 w-1/2 sm:w-4/12 md:w-3/12">
                    <!-- Col Title -->
                    <div class="text-xs uppercase text-gray-400 font-medium mb-6">
                        Roles
                    </div>

                    <!-- Links -->
                    <inertia-link :href="route('tutoriales.usuario')" class="my-3 block text-gray-300 hover:text-gray-100 text-sm font-medium duration-700">
                        Perfil de usuario
                    </inertia-link>
                    <inertia-link :href="route('tutoriales.directivo')" class="my-3 block text-gray-300 hover:text-gray-100 text-sm font-medium duration-700">
                        Directivos
                    </inertia-link>
                    <inertia-link :href="route('tutoriales.docente')" class="my-3 block text-gray-300 hover:text-gray-100 text-sm font-medium duration-700">
                        Docentes
                    </inertia-link>
                    <inertia-link :href="route('tutoriales.alumno')" class="my-3 block text-gray-300 hover:text-gray-100 text-sm font-medium duration-700">
                        Alumnos
                    </inertia-link>
                    <inertia-link :href="route('tutoriales.padre')" class="my-3 block text-gray-300 hover:text-gray-100 text-sm font-medium duration-700">
                        Padres, madres y tutores
                    </inertia-link>
                    <inertia-link :href="route('tutoriales.repitente')" class="my-3 block text-gray-300 hover:text-gray-100 text-sm font-medium duration-700">
                        Repitentes
                    </inertia-link>
                    <inertia-link :href="route('tutoriales.exalumno')" class="my-3 block text-gray-300 hover:text-gray-100 text-sm font-medium duration-700">
                        Ex alumnos
                    </inertia-link>
                </div>

                <!-- Col-3 -->
                <div class="p-5 w-1/2 sm:w-4/12 md:w-3/12">
                    <!-- Col Title -->
                    <div class="text-xs uppercase text-gray-400 font-medium mb-6">
                        Para docentes y alumnos
                    </div>

                    <!-- Links -->
                    <inertia-link :href="route('tutoriales.evaluacion')" class="my-3 block text-gray-300 hover:text-gray-100 text-sm font-medium duration-700">
                        Evaluaciones
                    </inertia-link>
                    <!-- <inertia-link :href="route('tutoriales.correccion')" class="my-3 block text-gray-300 hover:text-gray-100 text-sm font-medium duration-700">
                        Correcciones
                    </inertia-link>
                    <inertia-link :href="route('tutoriales.entrega')" class="my-3 block text-gray-300 hover:text-gray-100 text-sm font-medium duration-700">
                        Entregas
                    </inertia-link> -->
                    <inertia-link :href="route('tutoriales.material')" class="my-3 block text-gray-300 hover:text-gray-100 text-sm font-medium duration-700">
                        Materiales
                    </inertia-link>
                    <inertia-link :href="route('tutoriales.mesa')" class="my-3 block text-gray-300 hover:text-gray-100 text-sm font-medium duration-700">
                        Mesa/Rendir
                    </inertia-link>
                    <inertia-link :href="route('tutoriales.muro')" class="my-3 block text-gray-300 hover:text-gray-100 text-sm font-medium duration-700">
                        Muro
                    </inertia-link>
                </div>

                <!-- Col-3 -->
                <div class="p-5 w-1/2 sm:w-4/12 md:w-3/12">
                    <!-- Col Title -->
                    <div class="text-xs uppercase text-gray-400 font-medium mb-6">
                        Números y calendario
                    </div>

                    <!-- Links -->
                    <inertia-link :href="route('tutoriales.libreta')" class="my-3 block text-gray-300 hover:text-gray-100 text-sm font-medium duration-700">
                        Libretas
                    </inertia-link>
                    <inertia-link :href="route('tutoriales.estadistica')" class="my-3 block text-gray-300 hover:text-gray-100 text-sm font-medium duration-700">
                        Estadísticas y números
                    </inertia-link>
                    <inertia-link :href="route('tutoriales.calendario')" class="my-3 block text-gray-300 hover:text-gray-100 text-sm font-medium duration-700">
                        Calendario
                    </inertia-link>
                </div>
            </div>

            <!-- Copyright Bar -->
            <div class="pt-2">
                <div class="flex pb-5 px-3 m-auto pt-5 
                    border-t border-gray-500 text-gray-400 text-sm 
                    flex-col md:flex-row max-w-6xl">
                    <div class="mt-2">
                        © Copyright 2020 - 2021 | Gescolonline. All Rights Reserved.
                    </div>

                    <!-- 
                    <div class="md:flex-auto md:flex-row-reverse mt-2 flex-row flex">
                        <a href="#" class="w-6 mx-1">
                            <i class="uil uil-facebook-f"></i>
                        </a>
                        <a href="#" class="w-6 mx-1">
                            <i class="uil uil-twitter-alt"></i>
                        </a>
                        <a href="#" class="w-6 mx-1">
                            <i class="uil uil-youtube"></i>
                        </a>
                        <a href="#" class="w-6 mx-1">
                            <i class="uil uil-linkedin"></i>
                        </a>
                        <a href="#" class="w-6 mx-1">
                            <i class="uil uil-instagram"></i>
                        </a>
                    </div> -->
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
    import JetApplicationMark from '@/Jetstream/ApplicationMark'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import JetNavLink from '@/Jetstream/NavLink'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'
    import FlashMessages from '@/Shared/FlashMessages.vue'

    export default {
        components: {
            JetApplicationMark,
            JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,
            FlashMessages,
        },

        data() {
            return {
                showingNavigationDropdown: false,
            }
        },

        methods: {
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
        }
    }
</script>
