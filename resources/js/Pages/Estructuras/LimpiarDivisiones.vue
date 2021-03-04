<template>
    <app-layout>
        <template #header>
            <div class="flex">
                <div class="w-1/2">
                    <span class="font-semibold text-md text-gray-800 leading-tight">
                        <inertia-link class="hover:underline" :href="route('instituciones.show', institucion_id)">Perfil institucional</inertia-link> /
                        Limpiar divisiones
                    </span>
                </div>
                <div class="w-1/2">
                    <span class="float-right">
                        Seleccionar a todos: <input @click="seleccionarATodos()" v-model="todosCheckbox" type="checkbox">
                    </span>
                </div>
            </div>
        </template>

        <div class="py-6">
            <div class="container mx-auto">
                <form method="post" @submit.prevent="submit">
                    <button type="submit" class="float-right border border-blue-500 bg-blue-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 select-none hover:bg-blue-700 focus:outline-none focus:shadow-outline">
                        Limpiar
                    </button>
                </form>
            </div>
            
            <estructura-tabla>
                <template #tabla>

                    <table-head-estructura>
                        <template #th>

                            <table-head>
                                <template #th-titulo>
                                    #
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Nivel
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Orientación
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Curso
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    División
                                </template>
                            </table-head>

                            <table-head colspan="3">
                                <template #th-titulo>
                                    Seleccionar
                                </template>
                            </table-head>

                        </template>
                    </table-head-estructura>

                    <table-body>
                        <template #tr>
                            
                            <tr v-for="(division, index) in divisiones" :key="division.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ division.nivel_nombre }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <span v-if="division.orientacion_nombre">{{ division.orientacion_nombre }}</span>
                                        <span v-else >-</span>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ division.curso_nombre }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ division.division }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <input type="checkbox" :id="division.id" :value="division.id" v-model="form.division_id">
                                    </template>
                                </table-data>
                            </tr>
                        </template>
                    </table-body>
                </template>
            </estructura-tabla>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import EstructuraTabla from '@/Tabla/EstructuraTabla'
    import TableHeadEstructura from '@/Tabla/TableHeadEstructura'
    import TableHead from '@/Tabla/TableHead'
    import TableBody from '@/Tabla/TableBody'
    import TableData from '@/Tabla/TableData'

    export default {
        components: {
            AppLayout,
            EstructuraTabla,
            TableHeadEstructura,
            TableHead,
            TableBody,
            TableData,
        },

        title: 'Estructura',

        props:{ 
            institucion_id: String,
            divisiones: Array,
        },

        data() {
            return {
                form: {
                    division_id: [],
                },
                todosCheckbox: false,
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('limpiar-divisiones', this.institucion_id), this.form)
            },

            seleccionarATodos() {
                this.form.division_id = [];
                if (!this.todosCheckbox) {
                    for (let division in this.divisiones) {
                        this.form.division_id.push(this.divisiones[division].id);
                    }
                }
            }
        }
    }
</script>
