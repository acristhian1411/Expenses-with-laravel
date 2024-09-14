<script>
	import { createEventDispatcher } from 'svelte';
	export let alertMessage;
	export let alertType;
	const dispatch = createEventDispatcher();
	function close() {
		dispatch('close');
	}
	setTimeout(close, 5000);
</script>

{#if alertType == 'success'}
	<!-- svelte-ignore a11y-click-events-have-key-events -->
	<!-- svelte-ignore a11y-no-noninteractive-element-interactions -->
	<div
		role="alert"
		class="alert alert-success fixed left-1/3 right-1/3 top-12 z-50 w-1/3"
		on:click={close}
	>
		<svg
			xmlns="http://www.w3.org/2000/svg"
			class="h-6 w-6 shrink-0 stroke-current"
			fill="none"
			viewBox="0 0 24 24"
			><path
				stroke-linecap="round"
				stroke-linejoin="round"
				stroke-width="2"
				d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
			/></svg
		>
		<span>{alertMessage}</span>
	</div>
{/if}
{#if alertType == 'delete'}
	<!-- svelte-ignore a11y-click-events-have-key-events -->
	<!-- svelte-ignore a11y-no-noninteractive-element-interactions -->
	<div
		role="alert"
		class="alert alert-error fixed left-1/3 right-1/3 top-12 z-50 w-1/3"
		on:click={close}
	>
		<svg
			xmlns="http://www.w3.org/2000/svg"
			class="h-6 w-6 shrink-0 stroke-current"
			fill="none"
			viewBox="0 0 24 24"
			><path
				stroke-linecap="round"
				stroke-linejoin="round"
				stroke-width="2"
				d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
			/></svg
		>
		<span>
			{alertMessage}
		</span>
	</div>
{/if}
