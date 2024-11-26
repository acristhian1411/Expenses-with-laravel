
<script>
    import axios from 'axios';
    import { onMount } from 'svelte';
    import { createEventDispatcher } from 'svelte';
    import {Textfield, Autocomplete} from '@components/FormComponents';
    import {Modal} from '@components/utilities';
    import DetailsTable from './DetailsTable.svelte';
    import { Grid } from '@components/utilities';
    export let edit;
    export let item;
    export let token = '';
    const dispatch = createEventDispatcher();
    
    let providers = [];
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
    let modal = false;
    
    $: purchaseDetails ;

    let date = new Date();

    // Variables dinámicas para cada campo
    let person_id = '';
    let purchase_date = date.toISOString().slice(0, 10);
    let purchase_status = '';

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

    function OpenAlertMessage(event) {
        dispatch('message', event.detail);
    }

    onMount(() => {
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
            const res = await axios.post(`/api/purchases`, { person_id, purchase_date, purchase_status }, config);

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
        let newItem = purchaseDetails
        if(newItem.filter(x => x.id === item.id).length > 0) {
            let itemIdx = newItem.findIndex(x => x.id === item.id);
            newItem[itemIdx].quantity = newItem[itemIdx].quantity + 1;
        }else{
            newItem.push(item);
        }
        purchaseDetails = newItem;
    }

</script>
{#if modal == true}
    <Modal on:close={() => CloseModal()}>
        <DetailsTable {edit}  on:close={() => CloseModal()} />
    </Modal>
{/if}
<h3 class="mb-4 text-center text-2xl">{#if edit == true}Actualizar Purchases{:else}Nueva Compra{/if}</h3>
<form on:submit|preventDefault={edit == true ? handleUpdateObject() : handleCreateObject()}>
    <Grid columns={2} gap={3}>
        <Autocomplete
            errors={errors}
            label="Proveedor"
            bind:item_selected={providersSelected}
            items={providers.map(x => ({label: x.person_fname + ' ' + x.person_lastname, value: x.id}))}
            searchTerm={searchTermProviders}
            showDropdown={showDropdownProviders}
            loading={loading}
            filterdItem={providers}
        />
        
        <Textfield
            label="Fecha"
            required={true}
            type="date"
            bind:value={purchase_date}
            errors={errors?.purchase_date ? {message:errors.purchase_date[0]} : null}
        />
    </Grid>
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
                            addDetail({
                                id: 1,
                                quantity: 1,
                                iva: 10,
                                product_name: 'Producto 1',
                                purchase_amount: 100,
                            }),
                            OpenModal()
                        )}>Agregar</button>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            {#each purchaseDetails as item, i (item.id)}
                <tr class="hover">
                    <td>{item.quantity}</td>
                    <td class="text-center">{item.product_name}</td>
                    <td class="text-center">{item.iva}</td>
                    <td class="text-center">{item.purchase_amount}</td>
                    <td class="text-center">{parseInt(item.purchase_amount)*item.quantity}</td>
                </tr>
            {/each}
            {#if purchaseDetails.length > 0}
                <tr>
                    <td>Total</td>
                    <td>
                        <span class="text-right">
                            {purchaseDetails.reduce((acc, curr) => acc + (curr.purchase_amount * curr.quantity), 0).toFixed(2)}
                    </td>
                    <td  class="text-right">
                        <span>
                            {purchaseDetails.reduce((acc, curr) => acc + (curr.purchase_amount * curr.quantity), 0).toFixed(2)}
                        </span>
                    </td>
                </tr>
            {/if}
        </tbody>
    </table>


    <button class="btn btn-primary" type="submit">Guardar</button>
    <button class="btn btn-secondary" on:click={close}>Cancelar</button>
</form>
