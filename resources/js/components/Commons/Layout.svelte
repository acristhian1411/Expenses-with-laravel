<script>
    import Sidebar from './Sidebar.svelte';
    import Headers from './Headers.svelte';
	import Login from '../../Pages/Login/index.svelte';
    import { onMount } from 'svelte';
	export let user;
	
</script>
{#if user}
    <Headers user={user}/>
	<Sidebar user={user}/>
	<div class="p-4 sm:ml-64">
		<div class="mt-14 rounded-lg border-0 p-4 dark:border-gray-700">
			<slot />
		</div>
	</div>
{:else}
	<Headers user={user}/>
	<div class="p-4 sm:ml-64">
		<div class="mt-14 rounded-lg border-0 p-4 dark:border-gray-700">
			<Login />
		</div>
		
	</div>
{/if}