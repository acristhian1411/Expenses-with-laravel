<script>
    import { onMount } from 'svelte';
    import axios from 'axios';
    import { formatNumber } from '@components/utilities/NumberFormat.js';
    import Form from './form.svelte';
    import {Modal} from '@components/utilities';

    export let till_id;
    export let person_id;
    export let origin;
    export let origin_amount;
    let transfers = [];
    let modalOpen = false;
    let error = null;
    
    function getTransfers(till_id) {
        axios.get(`/api/tillstransfers/${till_id}/history`).then((response) => {
            transfers = response.data.data;
        }).catch((err) => {
            error = err.request.response;
        });
    }

    function openModal() {
        modalOpen = true;
    }
    function closeModal() {
        modalOpen = false;
    }
    onMount(async () => {
        getTransfers(till_id);
    });
</script>
{#if modalOpen}
    <Modal on:close={closeModal}>
        <Form 
            {till_id} 
            {origin} 
            {origin_amount}
            {person_id}
            on:close={closeModal} 
        />
    </Modal>
{/if}
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Origen</th>
            <th>Destino</th>
            <th>Cantidad</th>
            <th>Observaciones</th>
            <th>
                <button class="btn btn-primary" on:click={() => openModal()}>
                    Agregar
                </button>
            </th>
        </tr>
    </thead>
    <tbody>
        {#each transfers as transfer}
            <tr>
                <td>{transfer.t_transfer_date}</td>
                <td>{transfer.origin_id}</td>
                <td>{transfer.destiny_id}</td>
                <td>{formatNumber(transfer.t_transfer_amount)}</td>
                <td>{transfer.t_transfer_obs}</td>
                <td>
                    <button class="btn btn-secondary" on:click={()=>alert('función en desarrollo')}>
                        Eliminar
                    </button>
            </tr>
        {/each}
</table>
