<template>
    <label class="block uppercase tracking-wide text-white text-md font-bold mb-2">
        <slot name="label-value"></slot>
    </label>
</template>

<script>
    export default {
        props: ['value']
    }
</script>
