
<script>
    import axios from 'axios';
    import { onMount } from 'svelte';
    import {formatNumber, unformatNumber} from '@components/utilities/NumberFormat.js';
    import { createEventDispatcher } from 'svelte';
    import {Textfield, Autocomplete} from '@components/FormComponents';
    import {Modal} from '@components/utilities';
	import {Alert} from '@components/Alerts/';
    import DetailsTable from './DetailsTable.svelte';
    import { Grid, GridItem } from '@components/utilities';
    import Form from '@pages/Providers/form.svelte';

    export let edit;
    export let item;
    export let token = '';
    const dispatch = createEventDispatcher();
    
    let providers = [];
    let paymentTypes = [];
    let paymentTypesSelected = [];
    let searchTermPaymentTypes = '';
    let showDropdownPaymentTypes = false;
    let loadingPaymentTypes = false;
    let proofPaymentTypes = [];
    let providersSelected = [];
    let searchTermProviders = '';
    let showDropdownProviders = false;
    let loading = false;
    let purchaseDetails = [];
    let id = 0;
    let errors = null;
    let config = {
        headers: {
            authorization: `token: ${token}`,
        },
    };
    let showProviderForm
    let modal = false;
    let openAlert = false;
    let alertMessage = '';
	let alertType = '';
    $: purchaseDetails ;

    let date = new Date();

    // Variables dinámicas para cada campo
    let person_id = '';
    let purchase_date = date.toISOString().slice(0, 10);
    let purchase_status = '';
    let purchase_number = '';



    function getPaymentTypes() {
        axios.get(`/api/paymenttypes`).then((response) => {
            paymentTypes = response.data.data;
        }).catch((err) => {
            let detail = {
                detail: {
                    type: 'delete',
                    message: err.response.data.message
                }
            };
        });
    }

    function searchProvividers(event) {
        let search = event.detail;
        axios.get(`/api/persons-search-by-type/1?search=${search}`).then((response) => {
            providers = response.data.data.map(x => ({label: x.person_fname + ' ' + x.person_lastname, value: x.id}));
        }).catch((err) => {
            let detail = {
                detail: {
                    type: 'delete',
                    message: err.response.data.message
                }
            };
        });
    }

    function getProviders() {
        axios.get(`/api/persons?p_type_id=1`).then((response) => {
            providers = response.data.data;
        }).catch((err) => {
            let detail = {
                detail: {
                    type: 'delete',
                    message: err.response.data.message
                }
            };
        });
    }

    function close() {
        dispatch('close');
    }

    function closeAlert() {
        openAlert = false;
    }
    function openAlerts(message,type) {
        openAlert = true;
        alertType = type;
        alertMessage = message;
    }

    function selectProvider(item) {
        providersSelected = item.detail;
        searchTermProviders = item.detail.label;
    }

    function OpenAlertMessage(event) {
        dispatch('message', event.detail);
    }

    function OpenProviderForm() {
        showProviderForm = true;
    }
    function CloseProviderForm() {
        showProviderForm = false;
    }

    onMount(() => {
        getPaymentTypes();
        getProviders();
        if (edit == true) {
            id = item.id;
            person_id = item.person_id;
            purchase_date = item.purchase_date;
            purchase_status = item.purchase_status;
        }
    });

    function OpenModal() {
        modal = true;
    }

    function CloseModal() {
        modal = false;
    }

    async function handleCreateObject() {
        try {
            const res = await axios.post(`/api/storePurchase`, { 
                person_id: providersSelected.value, 
                purchase_date, 
                purchase_number,
                purchase_details: purchaseDetails.map(x => ({product_id: x.id, pd_qty: x.quantity, pd_amount: x.product_selling_price}))
            });

            openAlerts(res.data.message,'success');
        } catch (err) {
            errors = err.response.data.details ? err.response.data.details : null;
            
            openAlerts(err.response.data.message,'delete');
        }
    }

    async function handleUpdateObject() {
        try {
            const res = await axios.put(`/api/purchases/${id}`, { person_id, purchase_date, purchase_status }, config);

            let detail = {
                detail: {
                    type: 'success',
                    message: res.data.message
                }
            };
            OpenAlertMessage(detail);
            close();
        } catch (err) {
            errors = err.response.data.details ? err.response.data.details : null;
            let detail = {
                detail: {
                    type: 'error',
                    message: err.response.data.message
                }
            };
            OpenAlertMessage(detail);
        }
    }

    function addDetail(item) {
        let details = purchaseDetails
        if(details.filter(x => x.id === item.id).length > 0) {
            let itemIdx = details.findIndex(x => x.id === item.id);
            if(details[itemIdx].quantity == item.quantity){
                details[itemIdx].quantity = parseInt(details[itemIdx].quantity) + 1;
            }else{
                details[itemIdx].quantity = item.quantity;
            }
        }else{
            details.push(item);
        }
        purchaseDetails = details;
    }

    function removeDetail(item) {
        let newItem = purchaseDetails
        let itemIdx = newItem.findIndex(x => x.id === item.id);
        newItem.splice(itemIdx, 1);
        purchaseDetails = newItem;
    }

</script>
{#if showProviderForm == true}
    <Modal on:close={() => CloseProviderForm()}>
        <Form 
            on:providerSelected={selectProvider}
            from={'purchases'}
            edit={false}
            on:message={OpenAlertMessage} 
            on:close={() => CloseProviderForm()} />
    </Modal>
{/if}
{#if modal == true}
    <Modal on:close={() => CloseModal()}>
        <DetailsTable 
            {edit}  
            on:close={() => CloseModal()} 
            on:checked={(event) => addDetail(event.detail)}
            on:remove={(event) => removeDetail(event.detail)}
        />
    </Modal>
{/if}
{#if openAlert}
	<Alert {alertMessage} {alertType} on:close={closeAlert} />
{/if}
<h3 class="mb-4 text-center text-2xl">{#if edit == true}Actualizar Purchases{:else}Nueva Compra{/if}</h3>
<form on:submit|preventDefault={edit == true ? handleUpdateObject() : handleCreateObject()}>
    <div class="grid grid-cols-12  ">
        <div class="col-span-3">
            <Autocomplete
                errors={errors}
                searchFromApi={true}
                label="Proveedor"
                on:customSearch={searchProvividers}
                bind:item_selected={providersSelected}
                items={providers.map(x => ({label: x.person_fname + ' ' + x.person_lastname, value: x.id}))}
                searchTerm={searchTermProviders}
                showDropdown={showDropdownProviders}
                loading={loading}
                filterdItem={providers}
            />
        </div>
        <div class="col-span-1 gap-4">
            <button class="btn btn-primary" type="button" on:click={OpenProviderForm}>+</button>
        </div>
        <div class="col-span-4 mr-4" >
            <Textfield
                label="Num. Factura"
                required={true}
                type="text"
                mask="999-999-9999999"
                bind:value={purchase_number}
                errors={errors?.purchase_number ? {message:errors.purchase_number[0]} : null}
            />
        </div>
        <div class="col-span-4 gap-0">
            <Textfield
                label="Fecha"
                required={true}
                type="date"
                bind:value={purchase_date}
                errors={errors?.purchase_date ? {message:errors.purchase_date[0]} : null}
            />
        </div> 
    </div>    
    <div class="grid grid-cols-12 mt-4 gap-4">
        <div class="col-span-6">
            <Autocomplete
                errors={errors}
                label="Tipo de Pago"
                bind:item_selected={paymentTypesSelected}
                items={paymentTypes.map(x => ({label: x.payment_type_desc, value: x.id}))}
                searchTerm={searchTermPaymentTypes}
                showDropdown={showDropdownPaymentTypes}
                loading={loadingPaymentTypes}
                filterdItem={paymentTypes}
            />
        </div>
        {#if paymentTypesSelected } 
            <div class="col-span-6">
                <Autocomplete
                    errors={errors}
                    label="Comprobante"
                    bind:item_selected={proofPaymentTypes}
                    items={paymentTypes.map(x => ({label: x.payment_type, value: x.id}))}
                    searchTerm={searchTermPaymentTypes}
                    showDropdown={showDropdownPaymentTypes}
                    loading={loadingPaymentTypes}
                    filterdItem={paymentTypes}
                />
            </div>
        {/if}
    </div>
    <table class="table w-full">
        <thead>
            <tr>
                <th class="text-center text-lg">
                    <div class="flex items-center justify-center">
                        Cant
                    </div>
                </th>
                <th class="text-center text-lg">
                    <div class="flex items-center justify-center">
                        Producto
                    </div>
                </th>
                <th class="text-center text-lg">
                    <div class="flex items-center justify-center">
                        Iva
                    </div>
                </th>
                <th class="text-center text-lg">
                    <div class="flex items-center justify-center">P. Unitario</div>
                </th>
                <th class="text-center text-lg">
                    <div class="flex items-center justify-center">
                        Total
                    </div>
                </th>
                <th class="text-center text-lg">
                    <div class="flex items-center justify-center">
                        <button type="button" class="btn btn-primary" on:click={() => (
                            OpenModal()
                        )}>Agregar</button>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            {#each purchaseDetails as item, i (item.id)}
                <tr class="hover">
                    <td>
                        <Textfield
                            label=''
                            type='number'
                            bind:value={item.quantity}
                            errors={errors?.quantity ? {message:errors.quantity[0]} : null}
                        />

                    </td>
                    <td class="text-center">{item.product_name}</td>
                    <td class="text-center">{item.iva_type_percent}</td>
                    <td class="text-center">
                        <Textfield
                            label=''
                            type='number'
                            bind:value={item.product_selling_price}
                            errors={errors?.product_selling_price ? {message:errors.product_selling_price[0]} : null}
                        />
                    </td>
                    <td class="text-center">{formatNumber((parseInt(item.product_selling_price)*item.quantity))}</td>
                </tr>
            {/each}
            {#if purchaseDetails.length > 0}
                <tr>
                    <td colspan="4">Total</td>
                    
                    <td  class="text-center">
                        <span>
                            {formatNumber(purchaseDetails.reduce((acc, curr) => acc + (curr.product_selling_price * curr.quantity), 0).toFixed(2))}
                        </span>
                    </td>
                </tr>
            {/if}
        </tbody>
    </table>


    <button class="btn btn-primary" type="submit">Guardar</button>
    <button class="btn btn-secondary" on:click={close}>Cancelar</button>
</form>
