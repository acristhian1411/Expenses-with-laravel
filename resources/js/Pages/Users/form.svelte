<script>
	// @ts-nocheck
	import axios from 'axios';
	// import {getToken} from '../../services/authservice'
	import { onMount } from 'svelte';
	import { createEventDispatcher } from 'svelte';
	import {Textfield} from '@components/FormComponents';

	const dispatch = createEventDispatcher();
	let id = 0;
	let name = '';
	let email = '';
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
			name = item.name;
			email = item.email;
		}

	});
	function handleCreateObject() {
		
		axios
			.post(`/users`, {
				name,
				email
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
			.put(`/users/${id}`, {
				name,
				email
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
	<h3 class="mb-4 text-center text-2xl">Actualizar Usuario</h3>
{:else}
	<h3 class="mb-4 text-center text-2xl">Crear Usuario</h3>
{/if}
<!-- <form> -->
	<Textfield 
		label="Nombre" 
		bind:value={name} 
		errors={errors?.name ? {message:errors.name[0]} : null} 
	/>
	<Textfield 
		label="Correo" 
		bind:value={email} 
		errors={errors?.email ? {message:errors.email[0]} : null} 
	/>
	<button
		class="btn btn-primary"
		on:click={edit == true ? handleUpdateObject() : handleCreateObject()}>Guardar</button
	>
	<button class="btn btn-secondary" on:click={close}>Cancelar</button>
<!-- </form> -->
