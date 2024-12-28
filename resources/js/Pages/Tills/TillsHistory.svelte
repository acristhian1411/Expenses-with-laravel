<script>
    import { onMount } from 'svelte';
    import axios from 'axios';
    import {formatNumber} from '@components/utilities/NumberFormat';
    import {Textfield, Autocomplete} from '@components/FormComponents';

    let date = new Date();
    let fullDate = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();

    export let till_id
    let tills = [];
    let fromDate = fullDate;
    let toDate = fullDate;
    let errors = null;

    function getHistory(id,from = '',to = ''){
        axios.get(`/api/tilldetails/${id}/history`,{
            params: {
                from: from,
                to: to
            }
        }).then((response) => {
            tills = response.data.data;
        }).catch((err) => {
            console.log(err);
        });
    }

    onMount(async () => {
        getHistory(till_id);
    });

</script>

<h1 align="center" class='mb-3 mt-3 text-2xl'>Historial de caja</h1>

<div class="grid grid-cols-3 gap-4">
    <div>
        <Textfield 
            label="Fecha de inicio" 
            type="date"
            bind:value={fromDate}
            error={errors && errors.fromDate}
        />
    </div>
    <div>
        <Textfield 
            label="Fecha fin" 
            type="date"
            bind:value={toDate}
            error={errors && errors.toDate}
        />
    </div>
    <div>
        <button class="btn btn-primary" on:click={getHistory(till_id,fromDate,toDate)}>Filtrar</button>
    </div>
</div>

<table class="table w-full">
    <thead>
        <tr>
            <th class="text-center text-lg">ID</th>
            <th class="text-center text-lg">Descripcion</th>
            <th class="text-center text-lg">Fecha</th>
            <th class="text-center text-lg">Tipo</th>
            <th class="text-center text-lg">Monto</th>
        </tr>
    </thead>
    <tbody>
        {#each tills as till}
            <tr class="hover">
                <td class="text-center">{till.id}</td>
                <td class="text-center">{till.td_desc}</td>
                <td class="text-center">{till.created_at}</td>
                <td class="text-center">{till.td_type == true ? 'Ingreso' : 'Egreso'}</td>
                <td class="text-center">{formatNumber(till.td_amount)}</td>
            </tr>
        {/each}
    </tbody>
</table>