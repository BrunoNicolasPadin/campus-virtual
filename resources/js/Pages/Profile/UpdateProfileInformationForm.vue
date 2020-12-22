<template>
    <jet-form-section @submitted="updateProfileInformation">
        <template #title>
            Datos del perfil
        </template>

        <template #description>
            Actualiza tu información.
        </template>

        <template #form>
            <!-- Profile Photo -->
            <div class="col-span-6 sm:col-span-4" v-if="$page.jetstream.managesProfilePhotos">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            ref="photo"
                            @change="updatePhotoPreview">

                <jet-label for="photo" value="Photo" />

                <!-- Current Profile Photo -->
                <div class="mt-2" v-show="! photoPreview">
                    <img :src="user.profile_photo_url" alt="Current Profile Photo" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" v-show="photoPreview">
                    <span class="block rounded-full w-20 h-20"
                          :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <jet-secondary-button class="mt-2 mr-2" type="button" @click.native.prevent="selectNewPhoto">
                    Select A New Photo
                </jet-secondary-button>

                <jet-secondary-button type="button" class="mt-2" @click.native.prevent="deletePhoto" v-if="user.profile_photo_path">
                    Remove Photo
                </jet-secondary-button>

                <jet-input-error :message="form.error('photo')" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Nombre" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
                <jet-input-error :message="form.error('name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                <jet-input-error :message="form.error('email')" class="mt-2" />
            </div>

            <!-- Tipo de cuenta -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="tipo" value="Tipo" />
                <select required v-model="form.tipo" class="form-select mt-1 block w-full">
                    <option value="">-</option>
                    <option value="Institución">Institución</option>
                    <option value="Persona">Persona</option>
                </select>
                <jet-input-error :message="form.error('tipo')" class="mt-2" />
            </div>

            <!-- Pais -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="pais" value="Pais" />
                <jet-input id="pais" type="text" class="mt-1 block w-full" v-model="form.pais" />
                <jet-input-error :message="form.error('pais')" class="mt-2" />
            </div>

            <!-- Provincia -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="provincia" value="Provincia" />
                <jet-input id="provincia" type="text" class="mt-1 block w-full" v-model="form.provincia" />
                <jet-input-error :message="form.error('provincia')" class="mt-2" />
            </div>

            <!-- Ciudad -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="ciudad" value="Ciudad" />
                <jet-input id="ciudad" type="text" class="mt-1 block w-full" v-model="form.ciudad" />
                <jet-input-error :message="form.error('ciudad')" class="mt-2" />
            </div>

            <!-- Direccion -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="direccion" value="Direccion" />
                <jet-input id="direccion" type="text" class="mt-1 block w-full" v-model="form.direccion" />
                <jet-input-error :message="form.error('direccion')" class="mt-2" />
            </div>

            <!-- Celular -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="celular" value="Celular" />
                <jet-input id="celular" type="text" class="mt-1 block w-full" v-model="form.celular" />
                <jet-input-error :message="form.error('celular')" class="mt-2" />
            </div>

            <!-- Telefono -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="telefono" value="Telefono" />
                <jet-input id="telefono" type="text" class="mt-1 block w-full" v-model="form.telefono" />
                <jet-input-error :message="form.error('telefono')" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Guardado.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Guardar
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
        },

        props: ['user'],

        data() {
            return {
                form: this.$inertia.form({
                    '_method': 'PUT',
                    name: this.user.name,
                    email: this.user.email,
                    tipo: this.user.tipo,
                    pais: this.user.pais,
                    provincia: this.user.provincia,
                    ciudad: this.user.ciudad,
                    direccion: this.user.direccion,
                    celular: this.user.celular,
                    telefono: this.user.telefono,
                    photo: null,
                }, {
                    bag: 'updateProfileInformation',
                    resetOnSuccess: false,
                }),

                photoPreview: null,
            }
        },

        methods: {
            updateProfileInformation() {
                if (this.$refs.photo) {
                    this.form.photo = this.$refs.photo.files[0]
                }

                this.form.post(route('user-profile-information.update'), {
                    preserveScroll: true
                });
            },

            selectNewPhoto() {
                this.$refs.photo.click();
            },

            updatePhotoPreview() {
                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };

                reader.readAsDataURL(this.$refs.photo.files[0]);
            },

            deletePhoto() {
                this.$inertia.delete(route('current-user-photo.destroy'), {
                    preserveScroll: true,
                }).then(() => {
                    this.photoPreview = null
                });
            },
        },
    }
</script>
