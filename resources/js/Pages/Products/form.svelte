<script>
	// @ts-nocheck
	import axios from 'axios';
	// import {getToken} from '../../services/authservice'
	import { onMount } from 'svelte';
	import { createEventDispatcher } from 'svelte';
	import {Textfield, Autocomplete} from '@components/FormComponents';

	const dispatch = createEventDispatcher();
	let id = 0;
	let product_name = '';
	let product_desc = '';
	let product_cost_price = '';
	let product_quantity = '';
	let product_selling_price = '';
	let category_id = '';
	let iva_type_id = '';
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
			// if (edit == true) {
			// 	state_selected = states.find(state => state.id === item.state_id);
			// }
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
			product_name = item.product_name;
			product_desc = item.product_desc;
			category_id = item.category_id;
		}
	});
	// http://127.0.0.1:5173/tilltypes
	function handleCreateObject() {
		
		axios
			.post(`/api/cities`, {
				product_name,
				product_desc,
				state_id: state_selected?.id? state_selected.id : null
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
			.put(`/api/cities/${id}`, {
				product_name,
				product_desc,
				state_id: state_selected?.id? state_selected.id : null
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
	<h3 class="mb-4 text-center text-2xl">Actualizar Producto</h3>
{:else}
	<h3 class="mb-4 text-center text-2xl">Crear Producto</h3>
{/if}
<!-- <form> -->
    <Textfield 
		label="Nombre" 
		bind:value={product_name} 
		errors={errors?.product_name ? {message:errors.product_name[0]} : null} 
	/>
	<Textfield 
		label="Descripcion" 
		bind:value={product_desc} 
		errors={errors?.product_desc ? {message:errors.product_desc[0]} : null} 
	/>
	<Textfield 
		label="Precio de costo" 
		type="number"
		bind:value={product_cost_price} 
		min="0"
		errors={errors?.product_cost_price ? {message:errors.product_cost_price[0]} : null} 
	/>
	<Textfield 
		label="Cantidad" 
		type="number"
		min="0"
		bind:value={product_quantity} 
		errors={errors?.product_quantity ? {message:errors.product_quantity[0]} : null} 
	/>
	<div class="mb-4 flex items-center">
		<span class="mr-2">Departamento</span>
		<select
			id="account_pid"
			class="select select-bordered w-full max-w-xs"
			bind:value={state_selected}
		>
			{#each states as state}
					<option value={state}>
							{state.state_name}
					</option>
			{/each}
		</select>
		{#if errors != null && errors.state_id}
			<span class="text-red-500 text-sm">{errors.state_id[0]}</span>
		{/if}
	</div>
	<button
		class="btn btn-primary"
		on:click={edit == true ? handleUpdateObject() : handleCreateObject()}>Guardar</button
	>
	<button class="btn btn-secondary" on:click={close}>Cancelar</button>
<!-- </form> -->
