<template>
    <textarea cols="30" rows="5" class="appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3" :value="value" ></textarea>
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

