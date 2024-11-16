
<script>
    import axios from 'axios';
    import { onMount } from 'svelte';
    import { createEventDispatcher } from 'svelte';
    import {Textfield} from '@components/FormComponents';
    export let edit;
    export let item;
    export let token = '';
    const dispatch = createEventDispatcher();
    
    let id = 0;
    let errors = null;
    let config = {
        headers: {
            authorization: `token: ${token}`,
        },
    };
    
    // Variables dinámicas para cada campo
    let person_id = '';
let purchase_date = '';
let purchase_status = '';

    function close() {
        dispatch('close');
    }

    function OpenAlertMessage(event) {
        dispatch('message', event.detail);
    }

    onMount(() => {
        if (edit == true) {
            id = item.id;
            person_id = item.person_id;
            purchase_date = item.purchase_date;
            purchase_status = item.purchase_status;
        }
    });

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
</script>

<h3 class="mb-4 text-center text-2xl">{#if edit == true}Actualizar Purchases{:else}Nueva Compra{/if}</h3>
<form on:submit|preventDefault={edit == true ? handleUpdateObject() : handleCreateObject()}>

    <Textfield
        label="Person_id"
        required={true}
        bind:value={person_id}
        errors={errors?.person_id ? {message:errors.person_id[0]} : null}
    />

    <Textfield
        label="Purchase_date"
        required={true}
        bind:value={purchase_date}
        errors={errors?.purchase_date ? {message:errors.purchase_date[0]} : null}
    />

    <Textfield
        label="Purchase_status"
        required={true}
        bind:value={purchase_status}
        errors={errors?.purchase_status ? {message:errors.purchase_status[0]} : null}
    />

    <button class="btn btn-primary" type="submit">Guardar</button>
    <button class="btn btn-secondary" on:click={close}>Cancelar</button>
</form>
