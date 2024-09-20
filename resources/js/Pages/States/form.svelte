<script>
	// @ts-nocheck
	import axios from 'axios';
	// import {getToken} from '../../services/authservice'
	import { onMount } from 'svelte';
	import { createEventDispatcher } from 'svelte';

	const dispatch = createEventDispatcher();
	let id = 0;
	let state_name = '';
	let country_id = '';
	export let edit;
	export let item;
	let errors = null;
	let countries = [];
	let country_selected ;
	let token = '';
	let searchTerm = '';
	let showDropdown = false;
	let loading = false;
	let filteredCountries = [];
	let config = {
		headers: {
			authorization: `token: ${token}`,
		},
	}
	function close() {
		dispatch('close');
	}
	function fetchCountries(searchTerm) {
		loading = true;
		filteredCountries = countries.filter((country) => {
			return country.country_name.toLowerCase().includes(searchTerm.toLowerCase());
		});
		loading = false;
	}
	async function filterCountries() {
		loading = true; // Inicia el loader

		// Simula el tiempo de respuesta de una API
		await new Promise((resolve) => setTimeout(resolve, 1000)); 

		filteredCountries = countries.filter(country =>
		country.country_name.toLowerCase().includes(searchTerm.toLowerCase())
		);

		loading = false; // Desactiva el loader
  }
	function getCountries() {
		axios.get(`/api/countries`).then((response) => {
			countries = response.data.data;
			if (edit == true) {
				country_selected = countries.find(country => country.id === item.country_id);
			}
		}).catch((err) => {
			// errors = err.response.data.details ? err.response.data.details : null;
			let detail = {
				detail: {
					type: 'delete',
					message: err.response.data.message
				}
			};
		});
	}

	function OpenAlertMessage(event) {
		dispatch('message', event.detail);
	}

	onMount(() => {
		getCountries();
		if (edit == true) {
			id = item.id;
			state_name = item.state_name;
			country_id = item.country_id;
		}
	});
	// http://127.0.0.1:5173/tilltypes
	function handleCreateObject() {
		
		axios
			.post(`/api/states`, {
				state_name,
				country_id: country_selected.id
			},config)
			.then((res) => {
				let detail = {
					detail: {
						type: 'success',
						message: res.data.message
					}
				};
				OpenAlertMessage(detail);
				close();
			}).catch((err) => {
				errors = err.response.data.details ? err.response.data.details : null;
				let detail = {
					detail: {
						type: 'delete',
						message: err.response.data.message
					}
				};
				OpenAlertMessage(detail);
			});
	}
	function handleUpdateObject() {
		axios
			.put(`/api/states/${id}`, {
				state_name,
				country_id: country_selected.id
			},config)
			.then((res) => {
				let detail = {
					detail: {
						type: 'success',
						message: res.data.message
					}
				};
				OpenAlertMessage(detail);
				close();
			}).catch((err) => {
				errors = err.response.data.details ? err.response.data.details : null;
				let detail = {
					detail: {
						type: 'delete',
						message: err.response.data.message
					}
				};
				OpenAlertMessage(detail);
			});
	}
	function handleSelectChange(event) {
    searchTerm = event.target.value;
  }
    // Escucha los cambios en el input
	function handleInput(event) {
    searchTerm = event.target.value;
    filterCountries();
    showDropdown = true; // Muestra el dropdown mientras se busca
  }

  // Maneja la selección de un país desde la lista desplegable
  function selectCountry(country) {
    country_selected = country;
    searchTerm = country.country_name;
    showDropdown = false; // Oculta el dropdown después de la selección
  }
</script>

{#if edit == true}
	<h3 class="mb-4 text-center text-2xl">Actualizar Departamento</h3>
{:else}
	<h3 class="mb-4 text-center text-2xl">Crear Departamento</h3>
{/if}
<!-- <form> -->
 {console.log(country_selected)}
	<div class="mb-4 flex items-center">
		<span class="mr-2">Descripción</span>
		<input type="text" bind:value={state_name} class="input input-bordered w-full max-w-xs " />
		{#if errors != null && errors.state_name}
			<span class="text-red-500 text-sm">{errors.state_name[0]}</span>
		{/if}
	</div>
	<div class="mb-4 flex items-center">
		<span class="mr-2">Pais</span>
		<select
			id="account_pid"
			class="select select-bordered w-full max-w-xs"
			bind:value={country_selected}
		>
			{#each countries as country}
					<option value={country}>
							{country.country_name}
					</option>
			{/each}
		</select>
		{#if errors != null && errors.country_id}
			<span class="text-red-500 text-sm">{errors.country_id[0]}</span>
		{/if}
	</div>

	<div class="mb-4  items-start relative">
		<span class="mr-2">País</span>
	  
		<input
		  type="text"
		  class="input input-bordered w-full max-w-xs"
		  placeholder="Buscar país..."
		  bind:value={searchTerm}
		  on:input={handleInput}
		  on:focus={() => showDropdown = true}
		  on:blur={() => setTimeout(() => showDropdown = false, 200)} 
		/>
	  
		<!-- Dropdown de países filtrados -->
		{#if showDropdown && filteredCountries.length > 0}
		  <ul class="dropdown absolute top-full left-0 w-full max-w-xs bg-gray-300 border mt-1 z-10">
			{#if loading}
			<!-- Loader mientras se buscan los países -->
			<li class="p-2 text-center">
			  <div class="loader">Cargando...</div>
			</li>
		  {:else if filteredCountries.length > 0}
			{#each filteredCountries as country}
			  <!-- svelte-ignore a11y-click-events-have-key-events -->
			  <li
				class="p-2 hover:bg-gray-200 cursor-pointer"
				on:click={() => selectCountry(country)}
			  >
				{country.country_name}
			  </li>
			{/each}
		  {:else}
			<!-- Mensaje si no hay resultados -->
			<li class="p-2 text-center text-gray-500">No se encontraron países</li>
		  {/if}
		  </ul>
		{/if}
	  
		{#if errors != null && errors.country_id}
		  <span class="text-red-500 text-sm">{errors.country_id[0]}</span>
		{/if}
	  </div>
	  
	<button
		class="btn btn-primary"
		on:click={edit == true ? handleUpdateObject() : handleCreateObject()}>Guardar</button
	>
	<button class="btn btn-secondary" on:click={close}>Cancelar</button>
<!-- </form> -->
<style>
	.dropdown {
	  max-height: 150px;
	  overflow-y: auto;
	}

	.loader {
    border: 4px solid rgba(0, 0, 0, 0.1);
    border-left-color: #4fa94d;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    animation: spin 1s linear infinite;
    display: inline-block;
  }
	@keyframes spin {
    0% {
      transform: rotate(0deg);
    }
    100% {
      transform: rotate(360deg);
    }
  }
  </style>