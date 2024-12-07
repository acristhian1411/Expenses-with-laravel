<script>
    import { onMount } from 'svelte';
    import axios from 'axios';
    import {Textfield, Autocomplete} from '@components/FormComponents';

    export let payment_type_id;
    let errors = null;
    let proof_payments = [
        {id: 0, proof_payment_desc: ''},
    ];

    function addProofPayment(item) {
        let details = proof_payments
        details.push(item);
        proof_payments = details;
    }

    function removeProofPayment(item) {
        let newItem = proof_payments
        let itemIdx = newItem.findIndex(x => x.id === item.id);
        newItem.splice(itemIdx, 1);
        proof_payments = newItem;
    }


    function handleSubmit(event) {
        event.preventDefault();

        console.log('submitted',payment_type_id);
    }
</script>
<form on:submit|preventDefault={handleSubmit}>
    <div class="grid grid-cols-12 gap-4">    
        {#each proof_payments as item, i (item.id)}    
            <div class="col-span-12">
                <Textfield
                    label="Comprobante"
                    required={true}
                    type="text"
                    bind:value={item.proof_payment_desc}
                />
                {#if i == proof_payments.length - 1}
                    <button class="btn btn-primary" type="button" on:click={() => addProofPayment({
                        id: i+1,
                        proof_payment_desc: ''
                    })}>
                        Agregar
                    </button>
                    {#if proof_payments.length > 1}
                        <button class="btn btn-secondary" type="button" on:click={() => removeProofPayment(item)}>
                            Eliminar
                        </button>
                    {/if}
                {/if}
            </div>
        {/each}
</form>