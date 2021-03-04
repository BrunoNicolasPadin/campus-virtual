<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('instituciones.show', institucion.id)">{{ institucion.user.name }}</inertia-link> /
                Editar
            </span>
        </template>

        <div class="py-6">

            <estructura-form>
                <template #formulario>
                    <form method="post" @submit.prevent="submit">
                        
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        Número
                                    </template>
                                </label-form>
                                
                                <input-form type="text" v-model="form.numero" />
                                
                                <info>
                                    <template #info>
                                        No es obligatorio.
                                    </template>
                                </info>
                            </div>

                            <div class="md:w-1/2 px-3">
                                
                                <label-form>
                                    <template #label-value>
                                        Fundación
                                    </template>
                                </label-form>
                                
                                <input-form type="text" v-model="form.fundacion" />
                                
                                <info>
                                    <template #info>
                                        No es obligatorio.
                                    </template>
                                </info>
                            </div>
                        </div>

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3">
                                <label-form>
                                    <template #label-value>
                                        Historia
                                    </template>
                                </label-form>
                                
                                <textarea
                                    class="appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                    cols="30" 
                                    rows="5" v-model="form.historia"></textarea>
                                
                                <info>
                                    <template #info>
                                        No es obligatorio.
                                    </template>
                                </info>
                            </div>
                        </div>

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Plan de estudio
                                    </template>
                                </label-form>
                                
                                <file-input v-model="form.planDeEstudio" type="file" />
                                
                                <info>
                                    <template #info>
                                        No es obligatorio. Solo puede subir uno.
                                    </template>
                                </info>
                            </div>
                        </div>

                        <!-- <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Clave de acceso actual
                                    </template>
                                </label-form>
                                
                                <input-form type="password" v-model="form.claveDeAccesoActual" />
                                
                                <info>
                                    <template #info>
                                        Es obligatorio solo si quiere cambiar la clave de acceso.
                                    </template>
                                </info>
                            </div>
                        </div> -->

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Clave de acceso nueva
                                    </template>
                                </label-form>
                                
                                <input-form type="password" v-model="form.claveDeAccesoNueva" />
                                
                                <info>
                                    <template #info>
                                        Es obligatorio solo si quiere cambiar la clave de acceso y debe tener entre 8 y 32 caracteres. Es la clave que deberan ingresar los alumnos, docentes, padres y directivos para poder anotarse en tu instituto.
                                    </template>
                                </info>
                            </div>

                            <div class="md:w-1/2 px-3">
                                
                                <label-form>
                                    <template #label-value>
                                        Confirmar clave de acceso nueva
                                    </template>
                                </label-form>
                                
                                <input-form type="password" v-model="form.claveDeAccesoNuevaConfirmation" />
                                
                                <info>
                                    <template #info>
                                        Vuelva a ingresar la clave de acceso.
                                    </template>
                                </info>
                            </div>
                        </div>

                        <guardar></guardar>

                    </form>
                </template>
            </estructura-form>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import EstructuraForm from '@/Formulario/EstructuraForm.vue'
    import LabelForm from '@/Formulario/LabelForm.vue'
    import InputForm from '@/Formulario/InputForm.vue'
    import Info from '@/Formulario/Info.vue'
    import Guardar from '@/Botones/Guardar.vue'
    import FileInput from '@/Formulario/FileInput.vue'
    

    export default {
        components: {
            AppLayout,
            EstructuraForm,
            LabelForm,
            InputForm,
            Info,
            Guardar,
            FileInput,
       },

        props: {
            errors: Object,
            institucion: Object,
        },

        title: 'Editar institucion',

        data() {
            return {
                form: {
                    numero: this.institucion.numero,
                    fundacion: this.institucion.fundacion,
                    historia: this.institucion.historia,
                    planDeEstudio: null,
                    boolPlanDeEstudio: null,
                    /* claveDeAccesoActual: null, */
                    claveDeAccesoNueva: null,
                    claveDeAccesoNuevaConfirmation: null,
                },
            }
        },

        methods: {
            submit() {
                var data = new FormData();
                data.append('numero', this.form.numero);
                data.append('fundacion', this.form.fundacion);
                data.append('historia', this.form.historia);
                if (this.form.planDeEstudio == null) {
                    this.form.boolPlanDeEstudio = false;
                }
                else { this.form.boolPlanDeEstudio = true; }
                data.append('boolArchivo', this.form.boolPlanDeEstudio);
                data.append('archivo', this.form.planDeEstudio);
                /* data.append('claveDeAccesoActual', this.form.claveDeAccesoActual); */
                data.append('claveDeAccesoNueva', this.form.claveDeAccesoNueva);
                data.append('claveDeAccesoNuevaConfirmation', this.form.claveDeAccesoNuevaConfirmation);
                data.append('_method', 'put');

                this.$inertia.post(this.route('instituciones.update', this.institucion.id), data)
            },
        },
    }
</script>
