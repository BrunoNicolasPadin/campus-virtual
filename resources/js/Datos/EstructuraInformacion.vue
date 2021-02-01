<template>
    <div class="container mx-auto px-4 sm:px-8 my-6">
		<div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200">
			<div class="px-4 py-5 sm:px-6">
				<h3 class="text-lg leading-6 font-medium text-gray-900">
					<slot name="cabecera-info"></slot>
				</h3>
			</div>

			<div class="border-t border-gray-200">
				<dl>
					<slot name="dl-contenido"></slot>
				</dl>
			</div>
		</div>
	</div>
</template>

<script>

    export default {
        
    }
</script>