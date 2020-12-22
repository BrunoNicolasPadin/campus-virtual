<template>
    <input class="appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3" :value="value" @input="$emit('input', $event.target.value)" ref="input">
</template>

<script>
    export default {
        props: ['value'],

        methods: {
            focus() {
                this.$refs.input.focus()
            }
        }
    }
</script>

