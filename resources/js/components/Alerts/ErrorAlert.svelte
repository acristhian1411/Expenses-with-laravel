<script>
	import { createEventDispatcher } from 'svelte';
    
    export let message;
	const dispatch = createEventDispatcher();

    function ClearError(event) {
		dispatch('clearError');
	}

</script>
<div
		class="relative rounded border border-red-400 bg-red-100 px-4 py-2 text-red-700"
		role="alert"
	>
		<strong class="font-bold">Error:</strong>
		<span class="block sm:inline">{message}</span>
		<!-- svelte-ignore a11y-click-events-have-key-events -->
		<!-- svelte-ignore a11y-no-static-element-interactions -->
		<span class="absolute bottom-0 right-0 top-0 px-4 py-3" on:click={() => (ClearError())}>
			<svg
				class="h-6 w-6 fill-current text-red-500"
				role="button"
				xmlns="http://www.w3.org/2000/svg"
				viewBox="0 0 20 20"
			>
				<title>Close</title>
				<path
					d="M14.348 14.849c-.469.469-1.229.469-1.697 0L10 11.819l-2.651 3.029c-.469.469-1.228.469-1.697 0-.469-.469-.469-1.228 0-1.697l2.756-3.15L5.652 5.151c-.469-.469-.469-1.229 0-1.697.469-.469 1.228-.469 1.697 0l3.65 4.17 3.65-4.17c.469-.469 1.228-.469 1.697 0 .469.469.469 1.228 0 1.697l-2.756 3.15 2.756 3.15c.469.469.469 1.228 0 1.697z"
				/>
			</svg>
		</span>
	</div>