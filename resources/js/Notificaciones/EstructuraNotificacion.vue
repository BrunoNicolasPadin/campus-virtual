<template>
    <div class="flex justify-center my-12 sm:my-0">
        <div class="w-full px-6 py-3 shadow-2xl flex flex-col items-center border-t
                sm:m-4 sm:rounded-lg sm:flex-row sm:border bg-blue-600 border-blue-600 text-white">
            <div class="w-10/12">
                <slot name="mensaje"></slot>
            </div>
            <div class="w-2/12 mt-2 sm:mt-0 sm:ml-4 justify-end">
                <button @click="marcarComoLeido()" class="px-3 py-2 hover:bg-blue-700 transition ease-in-out duration-300"> Marcar como leida </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        methods: {
            marcarComoLeido(id) {
                alert(id);
            },
        }
    }
</script>