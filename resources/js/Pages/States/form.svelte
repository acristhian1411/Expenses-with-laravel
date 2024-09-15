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
	let config = {
		headers: {
			authorization: `token: ${token}`,
		},
	}
	function close() {
		dispatch('close');
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
				country_id
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
</script>

{#if edit == true}
	<h3 class="mb-4 text-center text-2xl">Actualizar Departamento</h3>
{:else}
	<h3 class="mb-4 text-center text-2xl">Crear Departamento</h3>
{/if}
<!-- <form> -->
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
	<button
		class="btn btn-primary"
		on:click={edit == true ? handleUpdateObject() : handleCreateObject()}>Guardar</button
	>
	<button class="btn btn-secondary" on:click={close}>Cancelar</button>
<!-- </form> -->
