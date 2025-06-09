<script>
    import Sidebar from './Sidebar.svelte';
    import Headers from './Headers.svelte';
	import Login from '../../Pages/Login/index.svelte';
    import { sidebarOpen } from './sidebar.js';
	
	export let user;
	let isOpen
	
	sidebarOpen.subscribe(value => {
		isOpen = value;
	});

</script>
<svelte:head>
    <title>Inicio</title>
</svelte:head>
{#if user}
    <Headers user={user}/>
	<Sidebar user={user}/>
	<div class={`p-4 transition-all ${isOpen ? 'sm:ml-64' : 'ml-0'}`}>
		<div class="mt-14 rounded-lg border-0 p-4 dark:border-gray-700">
			<slot />
		</div>
	</div>
{:else}
	<Headers user={user}/>
	<div class={`p-4 transition-all ${isOpen ? 'sm:ml-64' : 'ml-0'}`}>
		<div class="mt-14 rounded-lg border-0 p-4 dark:border-gray-700">
			<Login />
		</div>
		
	</div>
{/if}