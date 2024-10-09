<script>

    // import {logout} from '../../services/authservice.js'
	import {Home,BoxesIcon } from '@components/Icons/';
	import {Inertia} from '@inertiajs/inertia';

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
				<details class="group">
					<summary class="cursor-pointer p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 rounded-lg flex items-center">
						<BoxesIcon />
						<span class="ml-3">Ubicaciones</span>
					</summary>
					<ul class="pl-5 space-y-2">
				{#if user != undefined && user.permissions != undefined && user.permissions.includes('countries.index')}
				<li>
					<!-- svelte-ignore a11y-click-events-have-key-events -->
					<span
						on:click={()=>goTo("/countries")}
						class="group flex items-center cursor-pointer rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
					>
						<BoxesIcon/>
						<span class="ml-3 flex-1 whitespace-nowrap">Paises</span>
					</span>
				</li>
				{/if}
				{#if user != undefined && user.permissions != undefined && user.permissions.includes('states.index')}
				<li>
					<!-- svelte-ignore a11y-click-events-have-key-events -->
					<span
						on:click={()=>goTo("/states")}
						class="group flex items-center cursor-pointer rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
					>
						<BoxesIcon/>
						<span class="ml-3 flex-1 whitespace-nowrap">Departamentos</span>
					</span>
				</li> 
				{/if}
				{#if user != undefined && user.permissions != undefined && user.permissions.includes('cities.index')}
				<li>
					<!-- svelte-ignore a11y-click-events-have-key-events -->
					<span
						on:click={()=>goTo("/cities")}
						class="group flex items-center cursor-pointer rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
					>
						<BoxesIcon/>
						<span class="ml-3 flex-1 whitespace-nowrap">Ciudades</span>
					</span>
				</li>
				{/if}
				</ul>
				</details>
			{/if}
			{#if user != undefined && user.permissions != undefined && user.permissions.includes('configuration.index')}
				<details class="group">
					<summary class="cursor-pointer p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 rounded-lg flex items-center">
						<BoxesIcon />
						<span class="ml-3">Configuraciones generales</span>
					</summary>
					<ul class="pl-5 space-y-2">
					{#if user != undefined && user.permissions != undefined && user.permissions.includes('tilltypes.index')}
					<li>
						<!-- svelte-ignore a11y-click-events-have-key-events -->
						<span
							on:click={()=>goTo("/tilltypes")}
							class="group flex items-center cursor-pointer rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
						>
							<BoxesIcon/>
							<span class="ml-3 flex-1 whitespace-nowrap">Tipos de cajas</span>
						</span>
					</li>
					{/if}
					{#if user != undefined && user.permissions != undefined && user.permissions.includes('ivatypes.index')}
					<li>
						<!-- svelte-ignore a11y-click-events-have-key-events -->
						<span
							on:click={()=>goTo("/ivatypes")}
							class="group flex items-center cursor-pointer rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
						>
							<BoxesIcon/>
							<span class="ml-3 flex-1 whitespace-nowrap">Tipos de IVA</span>
						</span>
					</li>
					{/if}
					{#if user != undefined && user.permissions != undefined && user.permissions.includes('categories.index')}
					<li>
						<!-- svelte-ignore a11y-click-events-have-key-events -->
						<span
							on:click={()=>goTo("/categories")}
							class="group flex items-center cursor-pointer rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
						>
							<BoxesIcon/>
							<span class="ml-3 flex-1 whitespace-nowrap">Categorias</span>
						</span>
					</li>
					{/if}
					{#if user != undefined && user.permissions != undefined && user.permissions.includes('persontypes.index')}
					<li>
						<!-- svelte-ignore a11y-click-events-have-key-events -->
						<span
							on:click={()=>goTo("/persontypes")}
							class="group flex items-center cursor-pointer rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
						>
							<BoxesIcon/>
							<span class="ml-3 flex-1 whitespace-nowrap">Tipo de Personas</span>
						</span>
					</li>
					{/if}
					</ul>
				</details>
			{/if}
			{#if user != undefined && user.permissions != undefined && user.permissions.includes('administration.index')}
				<details class="group">
					<summary class="cursor-pointer p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 rounded-lg flex items-center">
						<BoxesIcon />
						<span class="ml-3">Administración</span>
					</summary>
					<ul class="pl-5 space-y-2">
					{#if user != undefined && user.permissions != undefined && user.permissions.includes('paymenttypes.index')}
					<li>
						<!-- svelte-ignore a11y-click-events-have-key-events -->
						<span
							on:click={()=>goTo("/paymenttypes")}
							class="group flex items-center cursor-pointer rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
						>
							<BoxesIcon/>
							<span class="ml-3 flex-1 whitespace-nowrap">Tipo de pago</span>
						</span>
					</li>
					{/if}
					
					</ul>
				</details>
			{/if}
			{#if user != undefined && user.permissions != undefined && user.permissions.includes('users.index')}
				<details class="group">
					<summary class="cursor-pointer p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 rounded-lg flex items-center">
						<BoxesIcon />
						<span class="ml-3">Usuarios</span>
					</summary>
					<ul class="pl-5 space-y-2">

					{#if user != undefined && user.permissions != undefined && user.permissions.includes('roles.index')}
					<li>
						<!-- svelte-ignore a11y-click-events-have-key-events -->
						<span
							on:click={()=>goTo("/roles")}
							class="group flex items-center cursor-pointer rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
						>
							<BoxesIcon/>
							<span class="ml-3 flex-1 whitespace-nowrap">Roles</span>
						</span>
					</li>
					{/if}
					{#if user != undefined && user.permissions != undefined && user.permissions.includes('users.index')}
					<li>
						<!-- svelte-ignore a11y-click-events-have-key-events -->
						<span
							on:click={()=>goTo("/users")}
							class="group flex items-center cursor-pointer rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
						>
							<BoxesIcon/>
							<span class="ml-3 flex-1 whitespace-nowrap">Usuarios</span>
						</span>
					</li>
					{/if}
					</ul>
				</details>
			{/if}
			<li>
				<!-- svelte-ignore a11y-click-events-have-key-events -->
				<span
					on:click={()=>logout()}
					class="group flex items-center cursor-pointer rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
				>
					<BoxesIcon/>
					<span class="ml-3 flex-1 whitespace-nowrap">Cerrar sesión</span>
				</span>
			</li>
			
		</ul>
	</div>
</aside>