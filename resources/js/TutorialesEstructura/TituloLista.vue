<template>
    <div class="container px-4 text-left">
        <h1 class="tracking-tight font-extrabold text-gray-900 text-4xl">
            <span class="text-indigo-600">
                <slot name="titulo-tutorial"></slot>
            </span>
        </h1>
        <span class="text-md tracking-tight font-bold text-indigo-800">
            <ul>
                <slot name="lista-tutorial"></slot>
            </ul>
        </span>

        <hr class="my-5">

        <slot name="detalles" class="text-center"></slot>
    </div>
</template>