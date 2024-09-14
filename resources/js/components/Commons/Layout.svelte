<script>
    import Sidebar from './Sidebar.svelte';
    import Headers from './Headers.svelte';
</script>
    <Headers/>
	<Sidebar/>
	<div class="p-4 sm:ml-64">
		<div class="mt-14 rounded-lg border-0 p-4 dark:border-gray-700">
			<slot />
		</div>
	</div>