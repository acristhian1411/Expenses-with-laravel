<script>
    import { onMount } from 'svelte';
    import axios from 'axios';
    import {blur} from 'svelte/transition';
    export let appUrl
    export let id = 0;
    let tilltype = {};
    let audits = [];
    let error = null;
    let url = `${appUrl}/api/persontypes/`;

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
		<li><a href="/">Inicio</a></li>
		<li><a href="/persontypes">Tipos de personas</a></li>
	</ul>
</div>
{#if tilltype}
    <div transition:blur>
        <h1 class="text-xl font-bold">Descripcion:</h1>
        <p class="text-1xl">{tilltype.p_type_desc}</p>
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

