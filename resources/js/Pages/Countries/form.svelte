<script>
	// @ts-nocheck
	import axios from 'axios';
	// import {getToken} from '../../services/authservice'
	import { onMount } from 'svelte';
	import { createEventDispatcher } from 'svelte';

	const dispatch = createEventDispatcher();
	let id = 0;
	let country_name = '';
	let country_code = '';
	export let edit;
	export let item;
	let errors = null;
	let token = '';
	let config = {
		headers: {
			authorization: `token: ${token}`,
		},
	}
	function close() {
		dispatch('close');
	}

	function OpenAlertMessage(event) {
		dispatch('message', event.detail);
	}

	onMount(() => {

		if (edit == true) {
			id = item.id;
			country_name = item.country_name;
			country_code = item.country_code;
		}
	});
	// http://127.0.0.1:5173/tilltypes
	function handleCreateObject() {
		
		axios
			.post(`/api/countries`, {
				country_name,
				country_code
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
			.put(`/api/countries/${id}`, {
				country_name,
				country_code
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
	<h3 class="mb-4 text-center text-2xl">Actualizar Pais</h3>
{:else}
	<h3 class="mb-4 text-center text-2xl">Crear Pais</h3>
{/if}
<!-- <form> -->
	<div class="mb-4 flex items-center">
		<span class="mr-2">Descripción</span>
		<input type="text" bind:value={country_name} class="input input-bordered w-full max-w-xs " />
		{#if errors != null && errors.country_name}
			<span class="text-red-500 text-sm">{errors.country_name[0]}</span>
		{/if}
	</div>
	<div class="mb-4 flex items-center">
		<span class="mr-2">Código</span>
		<input type="text" bind:value={country_code} class="input input-bordered w-full max-w-xs" />
		{#if errors != null && errors.country_code}
			<span class="text-red-500 text-sm">{errors.country_code[0]}</span>
		{/if}
	</div>
	<button
		class="btn btn-primary"
		on:click={edit == true ? handleUpdateObject() : handleCreateObject()}>Guardar</button
	>
	<button class="btn btn-secondary" on:click={close}>Cancelar</button>
<!-- </form> -->
