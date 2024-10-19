<script>
    import {formatNumber, unformatNumber} from '@components/utilities/NumberFormat.js';
	import { createEventDispatcher, onMount } from 'svelte';
    export let label;
    export let value;
    export let errors;
    export let type;
    export let required;
    export let customFN;
    const dispatch = createEventDispatcher();
    function handChange(event) {
        dispatch('custom', event);
    }
    
    onMount(() => {
        console.log(customFN);
    })

    // $: value = formatNumber(value);
    function handleInput(event) {
        const unformattedValue = unformatNumber(event.target.value);
        value = unformattedValue; // Asigna el valor sin puntos
        event.target.value = formatNumber(unformattedValue); // Muestra el valor con puntos
    }
    function handleCustomInput(event) {
        if (customFN) {
            const unformattedValue = unformatNumber(event.target.value);
            let value = unformattedValue;
            customFN(value); // Llama la función que se pasó como prop
        } else {
            handleInput(event); // Si no hay función personalizada, usa la predeterminada
        }
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
                on:input={handleCustomInput}
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