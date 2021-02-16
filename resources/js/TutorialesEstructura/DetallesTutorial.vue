<template>
    <div class="container px-4 text-left">
        <span class="tracking-tight font-bold text-2xl">
            <span class="text-indigo-900">
                <slot name="titulo-sub-tutorial"></slot>
            </span>
        </span>

        <p class="text-black text-md font-bold">
            <slot name="informacion"></slot>
        </p>

        <div class="text-center">
            <slot name="contenido-video"></slot>
        </div>

        <hr class="my-5">
    </div>
</template>