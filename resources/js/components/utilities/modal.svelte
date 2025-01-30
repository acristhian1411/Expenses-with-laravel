<script>
	import { createEventDispatcher } from 'svelte';
	const dispatch = createEventDispatcher();
	function close() {
		dispatch('close');
	}
	function handleKeyDown(event) {
		if (event.key === 'Escape') {
			close();
		}
	}
</script>

<!-- svelte-ignore a11y-no-noninteractive-element-interactions -->
<dialog id="my_modal_3" class="modal modal-open" on:keydown={handleKeyDown}>
	<div class="modal-box max-w-none w-auto max-h-[90vh], overflow-y-auto">
		<form method="dialog">
			<button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" on:click={close}
				>✕</button
			>
		</form>
		<slot />
	</div>
</dialog>
