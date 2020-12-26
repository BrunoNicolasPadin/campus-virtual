<template>
    <div>
        <input ref="file" type="file" class="hidden" @change="change">
        <div v-if="!value" class="p-2">
            <button type="button" class="px-6 py-4 bg-gray-500 hover:bg-gray-700 rounded-sm text-md font-medium text-white" @click="browse">
                Seleccionar archivo
            </button>
        </div>
        <div v-else class="flex items-center justify-between p-2">
            <div class="flex-1 pr-1">
                {{ value.name }} <span class="text-white text-xs">({{ filesize(value.size) }})</span>
            </div>
            <button type="button" class="px-6 py-3 bg-gray-500 hover:bg-gray-700 rounded-sm text-xs font-medium text-white" @click="remove">
                Eliminar
            </button>
        </div>
  </div>
</template>

<script>
export default {
  props: {
    value: File,
  },
  watch: {
    value(value) {
      if (!value) {
        this.$refs.file.value = ''
      }
    },
  },
  methods: {
    filesize(size) {
      var i = Math.floor(Math.log(size) / Math.log(1024))
      return (size / Math.pow(1024, i) ).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i]
    },
    browse() {
      this.$refs.file.click()
    },
    change(e) {
      this.$emit('input', e.target.files[0])
    },
    remove() {
      this.$emit('input', null)
    },
  },
}
</script>