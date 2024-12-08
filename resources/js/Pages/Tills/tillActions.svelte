<script>
    import { onMount } from 'svelte';
    import axios from 'axios';
    import { createEventDispatcher } from 'svelte';
    import {Textfield} from '@components/FormComponents';
    import { Alert } from '@components/Alerts';

    const dispatch = createEventDispatcher();
    export let type;
    export let tillId = 0;
    export let person_id = 0;
    export let amount = 0;
    export let errors = null;
    let alertMessage = '';
    let alertType = '';
    let openAlert = false;

    function OpenAlertMessage(event) {
        alertMessage = event.detail.message;
        alertType = event.detail.type;
    }

    function updateData(){
        dispatch('updateData');
    }

    function closeAlert() {
        openAlert = false;
        alertMessage = '';
        alertType = '';
    }

    function close() {
        dispatch('close');
    }

    function handleSubmit(event) {
        event.preventDefault();
        if(type == 'open'){
            axios.post(`/api/tills/${tillId}/open`, {
                till_id:tillId,
                td_amount:amount,
                person_id:person_id
            }).then((res) => {
                let detail = {
                    detail: {
                        type: 'success',
                        message: res.data.message
                    }
                };
                updateData();
                OpenAlertMessage(detail);
                close();
            }).catch((err) => {
                errors = err.response.data.details ? err.response.data.details : null;
                let detail = {
                    detail: {
                        type: 'error',
                        message: err.response.data.message
                    }
                };
                OpenAlertMessage(detail);
            });
        }else if(type == 'close'){
            axios.post(`/api/tills/${tillId}/close`, {
                till_id:tillId,
                td_amount:amount,
                person_id:person_id
            }).then((res) => {
                let detail = {
                    detail: {
                        type: 'success',
                        message: res.data.message
                    }
                };
                updateData();
                OpenAlertMessage(detail);
                close();
            }).catch((err) => {
                errors = err.response.data.details ? err.response.data.details : null;
                let detail = {
                    detail: {
                        type: 'error',
                        message: err.response.data.message
                    }
                };
                OpenAlertMessage(detail);
            });
        }
    }
    onMount(() => {
        
    })
</script>

{#if openAlert}
    <Alert {alertMessage} {alertType} on:close={closeAlert} />
{/if}

<h1 class="text-xl font-bold mt-4 text-center">
    {#if type == 'open'}
        Abrir caja
    {:else if type == 'close'}
        Cerrar caja
    {/if}
</h1>

{#if type == 'open'}
    <form on:submit|preventDefault={handleSubmit}>
        <div class="grid grid-cols-12 gap-4 mt-4 mb-4">
            <div class="col-span-4">
                <Textfield
                    label="Monto"
                    required={true}
                    type="number"
                    bind:value={amount}
                />
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Guardar</button>
    </form>
{:else if type == 'close'}
    <form on:submit|preventDefault={handleSubmit}>
        <div class="grid grid-cols-12 gap-4 mt-4 mb-4">
            <div class="col-span-6">
                <Textfield
                    label="Monto"
                    required={true}
                    type="number"
                    bind:value={amount}
                />
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Guardar</button>
    </form>
{/if}
