<template>
    <div class="container mx-auto px-4 sm:px-8">
		<div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-2 overflow-x-auto">
			<div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
				<table class="min-w-full leading-normal">
					<slot name="tabla"></slot>
				</table>
			</div>
		</div>
	</div>
</template>