<script>
	// @ts-nocheck
	import axios from 'axios';
	// import {getToken} from '../../services/authservice'
	import { onMount } from 'svelte';
	import { createEventDispatcher } from 'svelte';
	import {Textfield} from '@components/FormComponents';
    import { bind } from 'svelte/internal';
	import Form from '@pages/ProofPayments/form.svelte';

	const dispatch = createEventDispatcher();
	let id = 0;
	let payment_type_desc = '';
	export let edit;
	export let item;
	let errors = null;
	let token = '';
	let parentFormRef;
  	let childFormRef;
	function close() {
		dispatch('close');
	}

	function OpenAlertMessage(event) {
		dispatch('message', event.detail);
	}

	onMount(() => {

		if (edit == true) {
			id = item.id;
			payment_type_desc = item.payment_type_desc;
		}
	});
	// http://127.0.0.1:5173/tilltypes
	function handleCreateObject(event) {
		event.preventDefault();
		axios
			.post(`/paymenttypes`, {
				payment_type_desc,
			})
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
	function handleUpdateObject(event) {
		event.preventDefault();
		console.log('childFormRef',childFormRef);
		childFormRef?.submitForm();
		// Envía el formulario del padre
		// parentFormRef?.requestSubmit();
		axios
			.put(`/paymenttypes/${id}`, {
				payment_type_desc,
			})
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
	<h3 class="mb-4 text-center text-2xl">Actualizar Tipos de pago</h3>
{:else}
	<h3 class="mb-4 text-center text-2xl">Crear Tipos de pago</h3>
{/if}
<form bind:this={parentFormRef} on:submit|preventDefault={edit == true ? handleUpdateObject : handleCreateObject}>
	<Textfield
		errors={errors?.payment_type_desc ? {message:errors.payment_type_desc[0]} : null}
		bind:value={payment_type_desc} 
		label="Descripción"
	/>
	{#if edit == true}
		<div class="mt-4 mb-4">
			<Form 
				payment_type_id={id} 
				bind:this={childFormRef}
				on:message={OpenAlertMessage}
			/>
		</div>
	{/if}
	<button
		class="btn btn-primary"
		type="submit"
	>
		Guardar
	</button>
	<button class="btn btn-secondary" on:click={close}>Cancelar</button>
</form>
