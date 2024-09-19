<script>
	// @ts-nocheck
	import axios from 'axios';
	// import {getToken} from '../../services/authservice'
	import { onMount } from 'svelte';
	import { createEventDispatcher } from 'svelte';

	const dispatch = createEventDispatcher();
	let id = 0;
	let till_type_desc = '';
	let city_code = '';
	let country_id = '';
	export let edit;
	export let item;
	let errors = null;
	let states = [];
	let state_selected ;
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
		axios.get(`/api/states`).then((response) => {
			states = response.data.data;
			if (edit == true) {
				state_selected = states.find(state => state.id === item.state_id);
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
		if (edit == true) {
			id = item.id;
			till_type_desc = item.till_type_desc;
		}
	});
	// http://127.0.0.1:5173/tilltypes
	function handleCreateObject() {
		
		axios
			.post(`/api/tilltypes`, {
				till_type_desc
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
			.put(`/api/tilltypes/${id}`, {
				till_type_desc
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
	<h3 class="mb-4 text-center text-2xl">Actualizar Tipo de Caja</h3>
{:else}
	<h3 class="mb-4 text-center text-2xl">Crear Tipo de Caja</h3>
{/if}
<!-- <form> -->
	<div class="mb-4 flex items-center">
		<span class="mr-2">Descripción</span>
		<input type="text" bind:value={till_type_desc} class="input input-bordered w-full max-w-xs " />
		{#if errors != null && errors.till_type_desc}
			<span class="text-red-500 text-sm">{errors.till_type_desc[0]}</span>
		{/if}
	</div>
	<button
		class="btn btn-primary"
		on:click={edit == true ? handleUpdateObject() : handleCreateObject()}>Guardar</button
	>
	<button class="btn btn-secondary" on:click={close}>Cancelar</button>
<!-- </form> -->
