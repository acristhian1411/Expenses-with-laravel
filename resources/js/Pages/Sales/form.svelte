<script>
    import axios from 'axios';
    import { SearchIcon} from '@components/Icons/';
    import { onMount } from 'svelte';
    import {formatNumber, unformatNumber} from '@components/utilities/NumberFormat.js';
    import { createEventDispatcher } from 'svelte';
    import {Textfield, Autocomplete, SearchPersons} from '@components/FormComponents';
    import {Modal} from '@components/utilities';
	import {Alert} from '@components/Alerts/';
    import DetailsTable from './DetailsTable.svelte';
    import { Grid, GridItem } from '@components/utilities';
    import Form from '@pages/Clients/form.svelte';

    // cosas que se optienen por props
    export let user
    export let edit;
    export let item;
    export let token = '';
    
    const dispatch = createEventDispatcher();
    let tillsSelected = [];
    let tills = [];
    let tillsSearchTerm = '';
    let Clients = [];
    let paymentTypes = [];
    let paymentTypesSelected ;
    let searchTermPaymentTypes = '';
    let showDropdownPaymentTypes = false;
    let loadingPaymentTypes = false;
    let proofPaymentTypes = [];
    let proofPaymentTypesSelected;
    let ClientsSelected = [];
    let searchTermClients = '';
    let showDropdownClients = false;
    let showPersonSearchForm = false;
    let loading = false;
    let saleDetails = [];
    let id = 0;
    let errors = null;
    let config = {
        headers: {
            authorization: `token: ${token}`,
        },
    };
    let showClientForm
    let modal = false;
    let openAlert = false;
    let alertMessage = '';
	let alertType = '';
    $: saleDetails ;
    $: paymentTypesSelected, filterProofPaymentTypes();
    let date = new Date();

    // Variables dinámicas para cada campo
    let person_id = '';
    let sale_date = date.toISOString().slice(0, 10);
    let sale_status = '';
    let sale_number = '';

    // region Cajas
    /**
     * Función para obtener las cajas por usuario
     * @param {void}
     * @returns {void}
     */
    function getTillsByUser(){
        axios.get(`/api/tills/${user.person_id}/byPerson`).then((response) => {
            tills = response.data.data;
            if (tills.length === 1) {
                tillsSelected = {
                    value: tills[0].id,
                    label: tills[0].till_name
                };
                tillsSearchTerm = tills[0].till_name;
            }
        }).catch((err) => {
            let detail = {
                detail: {
                    type: 'delete',
                    message: err.response.data.message
                }
            };
            OpenAlertMessage(detail);
        });
    }
    // end region

    // region Tipos de pago
    /**
     * Función para obtener los tipos de pago
     * @param {void}
     * @returns {void}
     */
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
    // end region

    // region Clientes
    /**
     * Función para obtener los Clientes
     * @param {void}
     * @returns {void}
     */
    function getClients() {
        axios.get(`/api/persons?p_type_id=2`).then((response) => {
            Clients = response.data.data;
        }).catch((err) => {
            let detail = {
                detail: {
                    type: 'delete',
                    message: err.response.data.message
                }
            };
        });
    }

    /**
     * Función para buscar los Clientes por nombre
     * @param {event} event
     * @returns {void}
     */
    function searchClients(event) {
        let search = event.detail;
        axios.get(`/api/persons-search-by-type/2?search=${search}`).then((response) => {
            Clients = response.data.data.map(x => ({label: x.person_fname + ' ' + x.person_lastname, value: x.id}));
        }).catch((err) => {
            let detail = {
                detail: {
                    type: 'delete',
                    message: err.response.data.message
                }
            };
        });
    }

    /**
     * Función para seleccionar el Cliente
     * @param {event} item
     * @returns {void} 
     */
    function selectClient(item) {
        ClientsSelected = item.detail.person.id;
        searchTermClients = item.detail.label;
    }
    // end region

    // region Alertas
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
    // end region
    

    function OpenAlertMessage(event) {
        dispatch('message', event.detail);
    }

    function OpenClientForm() {
        showClientForm = true;
    }
    function CloseClientForm() {
        showClientForm = false;
    }

    onMount(() => {
        getPaymentTypes();
        getClients();
        getTillsByUser();
        if (edit == true) {
            id = item.id;
            person_id = item.person_id;
            sale_date = item.sale_date;
            sale_status = item.sale_status;
        }
    });

    function OpenModal() {
        modal = true;
    }

    function CloseModal() {
        modal = false;
    }

    function OpenPersonSearchForm() {
        showPersonSearchForm = true;
    }

    function ClosePersonSearchForm() {
        showPersonSearchForm = false;
    }

    function filterProofPaymentTypes(event) {
        if(paymentTypesSelected != null){
            proofPaymentTypes = paymentTypes.filter(x => x.id == paymentTypesSelected.value)[0].proof_payments.map(x => ({
                label: x.proof_payment_desc, 
                value: x.id,
                td_pr_desc: ''
            }))
        }
    }

    async function handleCreateObject() {
        try {
            const res = await axios.post(`/api/storesale`, { 
                user_id: user.id,
                till_id: tillsSelected.value,
                person_id: ClientsSelected, 
                sale_date, 
                sale_number,
                sale_details: saleDetails.map(x => ({product_id: x.id, sd_qty: x.quantity, sd_amount: x.product_selling_price})),
                proofPayments: proofPaymentTypes
            });
            openAlerts(res.data.message,'success');
        } catch (err) {
            errors = err.response.data.details ? err.response.data.details : null;
            
            openAlerts(err.response.data.message,'delete');
        }
    }

    async function handleUpdateObject() {
        try {
            const res = await axios.put(`/api/sales/${id}`, { person_id, sale_date, sale_status }, config);
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
        let details = saleDetails
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
        saleDetails = details;
    }

    function removeDetail(item) {
        let newItem = saleDetails
        let itemIdx = newItem.findIndex(x => x.id === item.id);
        newItem.splice(itemIdx, 1);
        saleDetails = newItem;
    }

</script>
{#if showPersonSearchForm == true}
    <Modal on:close={() => ClosePersonSearchForm()}>
        <SearchPersons 
            label="Cliente"
            type=2
            on:selectPerson={selectClient}
            on:close={() => ClosePersonSearchForm()}
        />
    </Modal>
{/if}
{#if showClientForm == true}
    <Modal on:close={() => CloseClientForm()}>
        <Form 
            on:ClientSelected={selectClient}
            from={'sales'}
            edit={false}
            on:message={OpenAlertMessage} 
            on:close={() => CloseClientForm()} />
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
<h3 class="mb-4 text-center text-2xl">{#if edit == true}Actualizar Venta{:else}Nueva Venta{/if}</h3>
<form on:submit|preventDefault={edit == true ? handleUpdateObject() : handleCreateObject()}>
    <div class="grid grid-cols-12 ">
        <div class="col-span-3 pr-2">
            <Textfield
                errors={errors?.client ? errors.client[0] : []}
                label="Cliente"
                type="text"
                bind:value={searchTermClients}
                required={true}
            />
        </div>
        <div class="col-span-2 flex gap-3 items-center mb-2">
            <div class="tooltip " data-tip="Buscar cliente">
                <button  class="btn btn-primary" type="button" on:click={OpenPersonSearchForm}>
                    <SearchIcon/>
                </button>
            </div>
            <div class="tooltip " data-tip="Agregar cliente">
                <button class="btn btn-primary" type="button" on:click={OpenClientForm}>
                    +
                </button>
            </div>
        </div>
        <div class="col-span-3 mr-4">
            <Textfield
                label="Num. Factura"
                required={true}
                type="text"
                mask="999-999-9999999"
                bind:value={sale_number}
                errors={errors?.sale_number ? {message:errors.sale_number[0]} : null}
            />
        </div>
        <div class="col-span-4 gap-0">
            <Textfield
                label="Fecha"
                required={true}
                type="date"
                bind:value={sale_date}
                errors={errors?.sale_date ? {message:errors.sale_date[0]} : null}
            />
        </div> 
    </div>
    <div class="grid grid-cols-12 mt-4 gap-4">
        <div class="col-span-4">
            <Autocomplete
                errors={errors}
                label="Caja"
                bind:item_selected={tillsSelected}
                items={tills.map(x => ({label: x.till_name, value: x.id}))}
                searchTerm={tillsSearchTerm}
                showDropdown={showDropdownPaymentTypes}
                loading={loadingPaymentTypes}
                filterdItem={tills}
            />

        </div>
        <div class="col-span-4">
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
        {#if paymentTypesSelected && paymentTypesSelected.value != 1 } 
            {#each proofPaymentTypes as item}
                <div class="col-span-4">
                    <Textfield
                        label={item.label}
                        bind:value={item.td_pr_desc}
                        errors={errors?.td_pr_desc ? {message:errors.td_pr_desc[0]} : null}
                    />
                </div>
            {/each}
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
                        <div class="tooltip " data-tip="Agregar productos al carrito">
                            <button type="button" class="btn btn-primary" on:click={() => (
                                OpenModal()
                            )}>Agregar</button>
                        </div>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            {#each saleDetails as item, i (item.id)}
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
            {#if saleDetails.length > 0}
                <tr>
                    <td colspan="4">Total</td>
                    
                    <td  class="text-center">
                        <span>
                            {formatNumber(saleDetails.reduce((acc, curr) => acc + (curr.product_selling_price * curr.quantity), 0).toFixed(2))}
                        </span>
                    </td>
                </tr>
            {/if}
        </tbody>
    </table>


    <button class="btn btn-primary" type="submit">Guardar</button>
    <button class="btn btn-secondary" on:click={close}>Cancelar</button>
</form>
