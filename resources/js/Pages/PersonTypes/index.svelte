<script>
    import { onMount } from 'svelte';
    import axios from 'axios';
    let personsTypes = [];
    let error

    function getPersonsTypes() {
        axios.get('/api/persontypes').then((response) => {
            personsTypes = response.data.data;
        })
        .catch(error => {
            error = error
        })
    }
    onMount(() => {
        getPersonsTypes()
    })
</script>
{#if error}
    <div class="alert alert-danger">
        {error}
    </div>
{/if}
<div class="container">


<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Tipo de persona
                </th>
                <th colspan="3" scope="col" class="px-6 py-3">
                    actions
                </th>
            </tr>
        </thead>
        <tbody>
            {#each personsTypes as personType}
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {personType.p_type_desc}
                    </th>
                    <td class="px-6 py-4">
                        editar
                    </td>
                    <td class="px-6 py-4">
                        mostrar
                    </td>
                    <td class="px-6 py-4 text-right">
                        eliminar
                    </td>
                </tr>
                {/each}
        </tbody>
    </table>
</div>

   
</div>
