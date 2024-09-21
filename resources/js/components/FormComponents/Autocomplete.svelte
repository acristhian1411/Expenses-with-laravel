<script>
    import { onMount } from "svelte";

    export let errors;
    export let item_selected;
    export let searchTerm;
    export let showDropdown;
    export let loading;
    export let filterdItem;
    export let items

    $: searchTerm, filterCountries();

    function handleInput(event) {
        searchTerm = event.target.value;
        filterCountries();
        showDropdown = true; // Muestra el dropdown mientras se busca
    }
    function selectCountry(item) {
        item_selected = item;
        searchTerm = item.label;
        showDropdown = false; // Oculta el dropdown después de la selección
    }
    async function filterCountries() {
		loading = true; // Inicia el loader
		// Simula el tiempo de respuesta de una API
		await new Promise((resolve) => setTimeout(resolve, 1000)); 
		filterdItem = items.filter(item =>
		item.label.toLowerCase().includes(searchTerm.toLowerCase())
		);

		loading = false; // Desactiva el loader
    }

    onMount(() => {
        filterCountries();
    })

</script>

<div class="mb-4  items-start relative">
    <span class="mr-2">País</span>
    <input
        type="text"
        class="input input-bordered w-full max-w-xs"
        placeholder="Buscar país..."
        bind:value={searchTerm}
        on:input={handleInput}
        on:focus={() => showDropdown = true}
        on:blur={() => setTimeout(() => showDropdown = false, 200)} 
    />

    <!-- Dropdown de países filtrados -->
    {#if showDropdown && filterdItem.length > 0}
        <ul class="dropdown absolute top-full left-0 w-full max-w-xs bg-gray-500 border mt-1 z-10">
            {#if loading == true}
                <!-- Loader mientras se buscan los países -->
                <li class="p-2 text-center">
                <div class="loader">Cargando...</div>
                </li>
            {:else if filterdItem.length > 0}
                {#each filterdItem as item}
                <!-- svelte-ignore a11y-click-events-have-key-events -->
                <li
                    class="p-2 bg-black text-gray-800 hover:text-gray-500 hover:bg-gray-800 cursor-pointer"
                    on:click={() => selectCountry(item)}
                >
                    {item.label}
                </li>
                {/each}
            {:else}
        <!-- Mensaje si no hay resultados -->
                <li class="p-2 text-center text-gray-500">No se encontraron países</li>
            {/if}
        </ul>
    {/if}

    {#if errors != null && errors.message}
        <span class="text-red-500 text-sm">{errors.message}</span>
    {/if}
</div>

<style>
	.dropdown {
        max-height: 150px;
        overflow-y: auto;
	}

	.loader {
        border: 4px solid rgba(0, 0, 0, 0.1);
        border-left-color: #4fa94d;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        animation: spin 1s linear infinite;
        display: inline-block;
    }
    
	@keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
</style>