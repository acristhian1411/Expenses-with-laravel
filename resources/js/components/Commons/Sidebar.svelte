<script>
    // import {logout} from '../../services/authservice.js'
    import BoxesIcon from '../Icons/BoxesIcon.svelte';
    import ChartIcon from '../Icons/ChartIcon.svelte';
</script>
<aside
	id="logo-sidebar"
	class="fixed left-0 top-0 z-40 h-screen w-64 -translate-x-full border-r border-gray-200 bg-white pt-20 transition-transform dark:border-gray-700 dark:bg-gray-800 sm:translate-x-0"
	aria-label="Sidebar"
>
	<div class="h-full overflow-y-auto bg-white px-3 pb-4 dark:bg-gray-800">
		<ul class="space-y-2 font-medium">
			<li>
				<a
					href="/"
					class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
				>
					<ChartIcon/>
					<span class="ml-3">Inicio</span>
				</a>
			</li>
			<li>
				<a
					href="/tilltypes"
					class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
				>
					<BoxesIcon/>
					<span class="ml-3 flex-1 whitespace-nowrap">Tipos de Cajas</span>
				</a>
			</li>
			<li>
				<a
					href="/accountplans"
					class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
				>
					<BoxesIcon/>
					<span class="ml-3 flex-1 whitespace-nowrap">Planes de cuentas</span>
				</a>
			</li>
			<li>
				<a
					href="/persontypes"
					class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
				>
					<BoxesIcon/>
					<span class="ml-3 flex-1 whitespace-nowrap">Tipo de Personas</span>
				</a>
			</li>
			<li>
				<a
					href="/persons"
					class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
				>
					<BoxesIcon/>
					<span class="ml-3 flex-1 whitespace-nowrap">Personas</span>
				</a>
			</li>
			<li>
				<a
					href="/tills"
					class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
				>
					<BoxesIcon/>
					<span class="ml-3 flex-1 whitespace-nowrap">Cajas</span>
				</a>
			</li>
			<li>
				<span class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
					<BoxesIcon/>
					<!-- svelte-ignore a11y-click-events-have-key-events -->
					<!-- svelte-ignore a11y-no-static-element-interactions -->
					<span class="ml-3 flex-1 whitespace-nowrap" on:click={()=>{
						alert('Esta funcionalidad no esta disponible');
					}}>Salir</span>
				</span>
			</li>
		</ul>
	</div>
</aside>