<template>
    <div class="container px-4 text-left">
        <span class="tracking-tight font-semibold text-indigo-800 text-4xl">
            <slot name="titulo-tutorial"></slot>
        </span>
        <span class="text-md tracking-tight font-semibold text-indigo-700">
            <ul>
                <slot name="lista-tutorial"></slot>
            </ul>
        </span>

        <hr class="my-5">

        <slot name="detalles" class="text-center"></slot>
    </div>
</template>