<script>
    import { onMount } from "svelte";
	/** What should we call the user? */
    export let errors;
    export let item_selected;
    export let searchTerm;
    export let showDropdown;
    export let loading;
    export let filterdItem;
    export let items
    export let label

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
<!--
@component
Here's some documentation for this component.
It will show up on hover.

- You can use markdown here.
- You can also use code blocks here.
- Usage:
  ```js
  <main name="Autocomplete">
    ```
  -->
<main>
    <div class="max-w-sm space-y-3">
        <div class="relative">
            <input
                type="text"
                id="hs-floating-input-email-value" class="peer p-4 block w-full border-gray-200 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none
                focus:pt-6
                focus:pb-2
                [&:not(:placeholder-shown)]:pt-6
                [&:not(:placeholder-shown)]:pb-2
                autofill:pt-6
                autofill:pb-2"
                placeholder="Buscar..."
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
                        <li class="p-2 text-center text-gray-500">No se encontro registros</li>
                    {/if}
                </ul>
            {/if}

            <label for="hs-floating-input-email-value" class="absolute top-0 start-0 p-4 h-full text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent  origin-[0_0] peer-disabled:opacity-50 peer-disabled:pointer-events-none
            peer-focus:scale-90
            peer-focus:translate-x-0.5
            peer-focus:-translate-y-1.5
            peer-focus:text-gray-500
            peer-[:not(:placeholder-shown)]:scale-90
            peer-[:not(:placeholder-shown)]:translate-x-0.5
            peer-[:not(:placeholder-shown)]:-translate-y-1.5
            peer-[:not(:placeholder-shown)]:text-gray-500">{label}</label>

            {#if errors != null && errors.message}
                <span class="text-red-500 text-sm">{errors.message}</span>
            {/if}
        </div>

    </div>
</main>
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