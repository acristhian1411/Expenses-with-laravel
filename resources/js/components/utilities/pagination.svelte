<script>
	// @ts-nocheck

	import { createEventDispatcher } from 'svelte';
	const dispatch = createEventDispatcher();
	function close() {
		dispatch('close');
	}
	export let current_page;
	export let total_pages;
	export let items_per_page;

	function goToPage(algo) {
		dispatch('page', { value: algo });
	}

	function rowsPerPage(page) {
		dispatch('row', { value: page });
	}

	function goPrevious() {
		if (current_page > 1) {
			current_page = current_page - 1;
			dispatch('page', { value: current_page });
		}
	}

	function goNext() {
		if (current_page < total_pages) {
			current_page = current_page + 1;
			dispatch('page', { value: current_page });
		}
	}
</script>

<nav aria-label="Page navigation example">
	<div class="mb-4 flex items-center justify-between">
		<div class="flex items-center space-x-4">
			<label for="itemsPerPage">Registros por página:</label>
			<select
				id="itemsPerPage"
				class="rounded-md border border-gray-300 bg-gray-500 px-2 py-1 text-white hover:bg-white hover:text-gray-700"
				bind:value={items_per_page}
				on:change={(event) => rowsPerPage(event.target.value)}
			>
				<option value="5">5</option>
				<option value="10">10</option>
				<option value="20">20</option>
				<option value="50">50</option>
				<option value="100">100</option>
			</select>
		</div>

		<ul class="inline-flex h-10 -space-x-px text-base">
			<li>
				<button
					on:click={() => goPrevious()}
					class="join-item btn btn-outline"
					disabled={current_page == 1}>Previous</button
				>
			</li>

			{#each Array.from({ length: total_pages }, (_, index) => index + 1) as page}
				<li>
					<button
						on:click={() => {
							goToPage(page);
						}}
						class="join-item btn btn-outline {current_page === page ? 'btn-active' : ''}"
						>{page}</button
					>
				</li>
			{/each}

			<li>
				<button
					on:click={() => goNext()}
					class="join-item btn btn-outline"
					disabled={current_page == total_pages}>Next</button
				>
			</li>
		</ul>
	</div>
</nav>
