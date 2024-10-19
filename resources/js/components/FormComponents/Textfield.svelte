<script>
    export let label;
    export let value;
    export let errors;
    export let type;
    export let required;

    // $: value = formatNumber(value);

    function formatNumber(value) {
        if (!value) return '';
        return value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function unformatNumber(value) {
        return value.replace(/\./g, '');
    }
    function handleInput(event) {
        const unformattedValue = unformatNumber(event.target.value);
        value = unformattedValue; // Asigna el valor sin puntos
        event.target.value = formatNumber(unformattedValue); // Muestra el valor con puntos
    }
</script>
<div class="mb-4 flex items-center ">
    <span class="mr-2">{label}</span>
    <div class="flex flex-col w-full">
        {#if type == 'number'}
            <input
                required={required}
                inputmode="numeric"
                value={formatNumber(value)}
                on:input={handleInput}
                class="input input-bordered w-full max-w-xs block" />
        {:else}
            <input 
                type="text" 
                bind:value={value} 
                required={required}
                class="input input-bordered w-full max-w-xs block" 
            />
        {/if}
        <!-- <input type={type != null ? type : 'text'} bind:value={value} class="input input-bordered w-full max-w-xs block" /> -->
        {#if errors != null && errors.message}
            <span class="mt-2 text-sm text-red-500 block">{errors.message}</span>
        {/if}
    </div>
</div>