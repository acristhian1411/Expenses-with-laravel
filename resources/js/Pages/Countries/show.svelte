<script>
    import { onMount } from 'svelte';
    import {blur} from 'svelte/transition';
    import axios from 'axios';
    import {Inertia} from '@inertiajs/inertia';
    export let appUrl
    export let id = 0;
    let tilltype = {};
    let audits = [];
    let error = null;
    let url = `${appUrl}/api/countries/`;

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
</script>
{#if error}
	<p>{error}</p>
{/if}
<div class="breadcrumbs text-md mb-4">
	<ul>
        <!-- svelte-ignore a11y-click-events-have-key-events -->
        <li><span class="cursor-pointer" on:click={()=>Inertia.visit("/")}>Inicio</span></li>
        <!-- svelte-ignore a11y-click-events-have-key-events -->
        <li><span class="cursor-pointer" on:click={()=>Inertia.visit("/countries")}>Paises</span></li>
	</ul>
</div>
{#if tilltype}
    <div transition:blur>
        <h1 class="text-xl font-bold">Descripcion:</h1>
        <p class="text-1xl">{tilltype.country_name}</p>
        <p class="text-1xl">{tilltype.country_code}</p>
    </div>
{/if}
{#if audits}
    <div transition:blur>
        <h1 class="text-xl font-bold mt-4">Detalles de cambios:</h1>
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
