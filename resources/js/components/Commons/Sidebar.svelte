<script>

    // import {logout} from '../../services/authservice.js'
	import {Home,BoxesIcon, ExitIcon, ConfigIcon, FinanceIcon, LocationIcon, UserIcon, ReportIcon, ProductIcon} from '@components/Icons/';
	import {Inertia} from '@inertiajs/inertia';
    import DropdownMenu from './DropdownMenu.svelte';
	import {locationItems,configItems,adminItems,userItems,reportsItems, productsItems} from './MenuItems.js';

	export let user;

	function goTo(route){
		Inertia.visit(route);
	}

	function logout() {
		Inertia.post('/logout');
		// Inertia.visit('/');
	}

</script>
<aside
	id="logo-sidebar"
	class="fixed left-0 top-0 z-40 h-screen w-64 -translate-x-full border-r border-gray-200 bg-white pt-20 transition-transform dark:border-gray-700 dark:bg-gray-800 sm:translate-x-0"
	aria-label="Sidebar"
>
	<div class="h-full overflow-y-auto bg-white px-3 pb-4 dark:bg-gray-800">
		<ul class="space-y-2 font-medium">
			<li>
				<!-- svelte-ignore a11y-click-events-have-key-events -->
				<span
					on:click={()=>goTo("/")}
					class="group flex items-center cursor-pointer rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
				>
					<Home/>
					<span class="ml-3">Inicio</span>
				</span>
			</li>
			{#if user != undefined && user.permissions != undefined && user.permissions.includes('locations.index')}
				<DropdownMenu title="Ubicaciones" icon={LocationIcon} items={locationItems(user)}/>
			{/if}
			{#if user != undefined && user.permissions != undefined && user.permissions.includes('configuration.index')}
				<DropdownMenu title="Configuraciones generales" icon={ConfigIcon} items={configItems(user)}/>
			{/if}
			{#if user != undefined && user.permissions != undefined && user.permissions.includes('products.sidebar')}
				<DropdownMenu title="Productos" icon={ProductIcon} items={productsItems(user)}/>
			{/if}
			{#if user != undefined && user.permissions != undefined && user.permissions.includes('administration.index')}
				<DropdownMenu title="Administración" icon={FinanceIcon} items={adminItems(user)}/>
			{/if}
			{#if user != undefined && user.permissions != undefined && user.permissions.includes('reports.index')}
				<DropdownMenu title="Reportes" icon={ReportIcon} items={reportsItems(user)}/>
			{/if}
			{#if user != undefined && user.permissions != undefined && user.permissions.includes('users.index')}
				<DropdownMenu title="Usuarios" icon={UserIcon} items={userItems(user)}/>
			{/if}
			<li>
				<!-- svelte-ignore a11y-click-events-have-key-events -->
				<span
					on:click={()=>logout()}
					class="group flex items-center cursor-pointer rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
				>
					<ExitIcon/>
					<span class="ml-3 flex-1 whitespace-nowrap">Cerrar sesión</span>
				</span>
			</li>
			
		</ul>
	</div>
</aside>