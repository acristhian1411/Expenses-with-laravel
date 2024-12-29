<script>
    import axios from 'axios';
    import { onMount } from 'svelte';
    import { formatNumber,unformatNumber } from '@components/utilities/NumberFormat.js';
    import {Textfield, Autocomplete} from '@components/FormComponents';

    export let till_id;
    export let origin;
    export let person_id;
    export let origin_amount;
    let og_amount_to_transfer = 0;
    let transfer_obs = '';
    let tills = [];
    let tillSelected ;
    let searchTill = '';
    let errors = null;

    function getTills() {
        axios.get(`/api/tills?till_status=true`).then((response) => {
            tills = response.data.data.filter(till => till.id != till_id);
        }).catch((err) => {
            errors = err.request.response;
        });
    }

    function handleSubmit(event) {
        event.preventDefault();
        axios.post(`/api/tills/${till_id}/transfer`, {
            person_id: person_id,
            destiny_id: tillSelected.value,
            t_transfer_amount: og_amount_to_transfer,
            t_transfer_obs: transfer_obs
        }).then((response) => {
            console.log(response);
        }).catch((err) => {
            errors = err.request.response;
        });
    }

    onMount(async () => {
        getTills();
    });

</script>
<h1 align="center" class="text-xl font-bold mt-4 mb-4">Transferencias</h1>
<form on:submit={handleSubmit}>
    <div class="grid grid-cols-2 gap-3 mb-2">
        <div>
            <div class="flex flex-col items-start">
                <div class="text-md mt-1">
                    <p>Caja de origen: {origin.till_name}</p>
                </div>
                <div class="text-md mt-1">
                    <p>Monto Actual: {formatNumber(origin_amount)}</p>  
                </div>
            </div>
        </div>
        <div >
            <Autocomplete
                errors={errors}
                label="Caja destino"
                bind:item_selected={tillSelected}
                items={tills.map(x => ({label: x.till_name, value: x.id}))}
                searchTerm={searchTill}
                showDropdown={false}
                loading={false}
                filterdItem={tills}
            />
        </div>
    </div>
    <div class="text-md mt-1">
        <Textfield
            label="Monto a transferir"
            type="number"
            bind:value={og_amount_to_transfer}
            errors={errors?.amount ? {message:errors.amount[0]} : null}
        />
    </div>
    <div class="text-md mt-1">
        <Textfield
            label="Observaciones"
            type="text"
            bind:value={transfer_obs}
            errors={errors?.transfer_obs ? {message:errors.transfer_obs[0]} : null}
        />
    </div>
    <button class="btn btn-primary mt-4" type="submit">Transferir</button>
</form>