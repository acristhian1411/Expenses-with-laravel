<script>
    import { onMount } from 'svelte';
    import {blur} from 'svelte/transition';
    import axios from 'axios';
    import { Inertia } from '@inertiajs/inertia';
    export let appUrl
    export let id = 0;
    let tilltype = {};
    let audits = [];
    let error = null;
    let url = `${appUrl}/api/ivatypes/`;

    async function fetchData() {
        axios.get(`${url}${id}`).then((response) => {
            tilltype = response.data.data;
            audits = response.data.audits;
        }).catch((err) => {
            error = err.request.response;
        });
    }

    onMount(async () => {
        fetchData();
    });
    function goTo(route){
        Inertia.visit(route);
    }
</script>
{#if error}
	<p>{error}</p>
{/if}
<div class="breadcrumbs text-md mb-4">
	<ul>
        <!-- svelte-ignore a11y-click-events-have-key-events -->
         <li><span class="cursor-pointer" on:click={()=>goTo("/")}>Inicio</span></li>
         <!-- svelte-ignore a11y-click-events-have-key-events -->
         <li><span class="cursor-pointer" on:click={()=>goTo("/ivatypes")}>Tipos de IVA</span></li>
	</ul>
</div>
{#if tilltype}
    <div transition:blur>
        <h1 class="text-xl font-bold">Descripcion:</h1>
        <p class="text-1xl">{tilltype.iva_type_desc}</p>
        <p class="text-1xl font-bold">Porcentaje:</p>
        <p class="text-1xl">{tilltype.iva_type_percent}</p>
    </div>
{/if}
{#if audits}
    <div transition:blur>
        <h1 class="text-xl font-bold mt-4">Historial de cambios:</h1>
        <table class="table w-full">
            <thead>
                <tr>
                    <!-- <th>Id</th> -->
                    <th class="text-center text-lg">Usuario</th>
                    <th class="text-center text-lg">Evento</th>
                    <th class="text-center text-lg">Fecha</th>
                    <th class="text-center text-lg">Detalles</th>
                </tr>
            </thead>
            <tbody>
                {#each audits as audit}
                    <tr>
                        <td class="text-center">{audit.user?audit.user.name:''}</td>
                        <td class="text-center">{audit.event}</td>
                        <td class="text-center">{new Date(audit.created_at).toLocaleString()}</td>
                        <td class="text-center">
                            <strong>Valores antiguos:</strong> {JSON.stringify(audit.old_values)}<br>
                            <strong>Valores nuevos:</strong> {JSON.stringify(audit.new_values)}
                        </td>
    
                    </tr>
                {/each}
            </tbody>
        </table>
    </div>
{/if}
