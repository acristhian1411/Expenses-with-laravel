
<script>
	// @ts-nocheck
	import { onMount } from 'svelte';
	import { inertia, page,router } from '@inertiajs/svelte';
	// import { isLoggedIn, getToken} from '../../services/authservice'
	// import {goto} from '$app/navigation';
	import axios from 'axios';
	import {Pagination, DeleteModal, Modal} from '@components/utilities/';
	import {Alert, ErrorAlert} from '@components/Alerts/';
	import {SearchIcon, SortIcon} from '@components/Icons/';
	import Form from './form.svelte';
	// import { appUrl } from '$env/static/public';
	export let user
    export let appUrl
	export let data;
	let countries = [];
	let error = null;
	let openAlert = false;
	let _new = false;
	let edit = false;
	let item = null;
	let search_param = '';
	let openDeleteModal = false;
	let alertMessage = '';
	let alertType = '';
	let id = 0;
	let orderBy = 'p_type_desc';
	let order = 'asc';
	let total_pages;
	let total_items;
	let current_page = 1;
	let items_per_page = '10';
	let url = `${appUrl}/api/countries?`;

	function updateData() {
		fetchData();
		closeModal();
	}

	function fetchData(page = current_page, rows = items_per_page) {
		current_page = data.currentPage;
		total_items = data.per_page;
		total_pages = data.last_page;
		countries = data.data;
	}

	function closeAlert() {
		openAlert = false;
	}

	function OpenAlertMessage(event) {
		console.log('details desde index',event.detail);
		openAlert = true;
		alertType = event.detail.type;
		alertMessage = event.detail.message;
	}

	function ClearError(){
		error = null;
	}

	function deleteRecord() {
		let token = '';
		let config = {
			headers: {
				authorization: `token: ${token}`,
			},
		}
		axios.delete(`/countries/${id}`).then((res) => {
			let detail = {
				detail: {
					type: 'delete',
					message: res.data.message
				}
			};
			OpenAlertMessage(detail);
			closeDeleteModal();
		});
	}
	function openEditModal(data) {
		edit = true;
		item = data;
		_new = false;
	}
	function closeModal() {
		edit = false;
		_new = false;
	}
	function openNewModal() {
		edit = false;
		item = null;
		_new = true;
	}
	function closeDeleteModal() {
		openDeleteModal = false;
		fetchData();
	}
	function sortData(param) {
		orderBy = param;
		if (order == 'asc') {
			order = 'desc';
		} else {
			order = 'asc';
		}
		axios.get('/countries?page='+current_page+'&per_page='+items_per_page+'&order='+order+'&order_by='+orderBy).then((response) => {
			countries = response.data.data;
			current_page = response.data.currentPage;
			total_items = response.data.per_page;
			total_pages = response.data.last_page;
		}).catch((err) => {
			let detail = {
				detail: {
					type: 'delete',
					message: err.response.data.message
				}
			};
		})
	}
	function OpenDeleteModal(data) {
		id = data;
		openDeleteModal = true;
	}
	function handleRowsPerPage(event) {
		items_per_page = event.detail.value;
		axios.get('/countries?page='+current_page+'&per_page='+items_per_page+'&order='+order+'&order_by='+orderBy).then((response) => {
			countries = response.data.data;
			current_page = response.data.currentPage;
			total_items = response.data.per_page;
			total_pages = response.data.last_page;
		}).catch((err) => {
			let detail = {
				detail: {
					type: 'delete',
					message: err.response.data.message
				}
			};
		});
	}
	function handlePage(event) {
		current_page = event.detail.value;
		axios.get('/countries?page='+current_page+'&per_page='+items_per_page+'&order='+order+'&order_by='+orderBy).then((response) => {
			countries = response.data.data;
			current_page = response.data.currentPage;
			total_items = response.data.per_page;
			total_pages = response.data.last_page;
		}).catch((err) => {
			let detail = {
				detail: {
					type: 'delete',
					message: err.response.data.message
				}
			};
		});
	}
	function search(event) {
		search_param = event.target.value;
		if (search_param == '') {
			url = `${appUrl}/api/countries?page=${current_page}&per_page=${items_per_page}&order=${order}&order_by=${orderBy}`;
		} else {
			url = `${appUrl}/api/countries?country_name=${search_param}&country_code=${search_param}&page=${current_page}&per_page=${items_per_page}&order=${order}&order_by=${orderBy}`;
		}
		axios.get(url).then((response) => {
			countries = response.data.data;
			current_page = response.data.currentPage;
			total_items = response.data.per_page;
			total_pages = response.data.last_page;
		}).catch((err) => {
			let detail = {
				detail: {
					type: 'delete',
					message: err.response.data.message
				}
			};
		});
	}
	onMount(async () => {
		// if(!isLoggedIn()){
		// 	goto('/login');
		// }
		fetchData();
	});
</script>

{#if error}
	<ErrorAlert message={error} on:clearError={ClearError} />
{/if}
<h3 class="mb-4 text-center text-2xl">Paises</h3>
<div class="flex justify-center">
	<label class="input input-bordered flex items-center gap-2">
		<input type="text" class="grow" placeholder="Search" on:change={search} />
		<SearchIcon />
	</label>
</div>
{#if openAlert}
	<Alert {alertMessage} {alertType} on:close={closeAlert} />
{/if}
{#if openDeleteModal}
	<dialog class="modal modal-open">
		<DeleteModal on:close={closeDeleteModal} on:confirm={deleteRecord} />
	</dialog>
{/if}
{#if _new == true}
	<Modal on:close={() => updateData()}>
		<Form {edit} on:message={OpenAlertMessage} on:close={() => updateData()} />
	</Modal>
{/if}
{#if edit == true}
	<Modal on:close={() => updateData()}>
		<Form {edit} {item} on:message={OpenAlertMessage} on:close={() => updateData()} />
	</Modal>
{/if}
{#if data}
	<div class="overflow-x-auto">
		<table class="table w-full">
			<thead>
				<tr>
					<th class="text-center text-lg">
						
						<div class="flex items-center">
							id
							<button on:click={() => sortData('id')}
								><SortIcon/></button
							>
						</div>
					</th>
					<th class="text-center text-lg">
						<div class="flex items-center justify-center">
							Descripcion
							<button on:click={() => sortData('country_name')}
								><SortIcon/></button
							>
						</div>
					</th>
					<th class="text-center text-lg">
						<div class="flex items-center justify-center">
							Codigo
							<button on:click={() => sortData('country_code')}
								><SortIcon/></button
							>
						</div>
					</th>
					{#if user.permissions != undefined && user.permissions.includes('countries.create')}
						<th>
							<button class="btn btn-primary" on:click={() => (_new = true)}>Agregar</button>
						</th>
					{/if}
				</tr>
			</thead>
			<tbody>
				{#each countries as country, i (country.id)}
					<tr class="hover">
						<td>{country.id}</td>
						<td class="text-center">{country.country_name}</td>
						<td class="text-center">{country.country_code}</td>
						{#if user.permissions != undefined && user.permissions.includes('countries.show')}
							<td>
								<button class="btn btn-info" use:inertia={{ href: `/countries/${country.id}` }}>Mostrar</button>
							</td>
						{/if}
						{#if user.permissions != undefined && user.permissions.includes('countries.update')}
							<td>
								<button class="btn btn-warning" on:click={() => openEditModal(country)}>Editar</button>
							</td>
						{/if}
						{#if user.permissions != undefined && user.permissions.includes('countries.destroy')}
							<td>
								<button class="btn btn-secondary" on:click={() => OpenDeleteModal(country.id)}
									>Eliminar</button
								>
							</td>
						{/if}
					</tr>
				{/each}
			</tbody> 
		</table>
		<Pagination
			current_page={current_page?current_page:1}
			{total_pages}
			{items_per_page}
			on:page={handlePage}
			on:row={handleRowsPerPage}
		/>
	</div>
{/if}
