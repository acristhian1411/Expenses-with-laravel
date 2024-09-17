<script>
    import { onMount } from 'svelte';
    import axios from 'axios';
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
		<li><a href="/">Inicio</a></li>
		<li><a href="/countries">Paises</a></li>
	</ul>
</div>
{#if tilltype}
	<h1 class="text-xl font-bold">Descripcion:</h1>
	<p class="text-1xl">{tilltype.country_name}</p>
	<p class="text-1xl">{tilltype.country_code}</p>
{/if}
{#if audits}
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
{/if}

<style>
    td {
        padding-right: 5px;
        padding-left: 5px;
        padding-top: 5px;
        padding-bottom: 5px;
        border-radius: 10px;
        border-color: #4d3f3f;
        gap: 5px;
        border-bottom: 1px solid #ddd;
        vertical-align: top;
        font-size: 14px;
        line-height: 1.5;

    }
</style>