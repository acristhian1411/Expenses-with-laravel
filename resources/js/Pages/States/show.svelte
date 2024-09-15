<script>
    import { onMount } from 'svelte';
    import axios from 'axios';
    export let appUrl
    export let id = 0;
    let tilltype = {};
    let error = null;
    let url = `${appUrl}/api/states/`;

    async function fetchData() {
        axios.get(`${url}${id}`).then((response) => {
            tilltype = response.data.data;
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
		<li><a href="/states">Departamentos</a></li>
	</ul>
</div>
{#if tilltype}
	<h1 class="text-xl font-bold">Descripcion:</h1>
	<p class="text-1xl">{tilltype.state_name}</p>
    <h1 class="text-xl font-bold">Pais:</h1>
	<p class="text-1xl">{tilltype.country_name}</p>
{/if}