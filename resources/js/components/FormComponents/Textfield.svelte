<script>
    import {formatNumber, unformatNumber} from '@components/utilities/NumberFormat.js';
	import { createEventDispatcher, onMount } from 'svelte';
    export let label;
    export let value;
    export let errors;
    export let type;
    export let required;
    export let customFN;
    export let mask;
    export let id
    export let onChange; // Callback para cambios en el valor
    const dispatch = createEventDispatcher();
    function handChange(event) {
        dispatch('custom', event);
    }    
    onMount(() => {
    })
    function handleInput(event) {
        if (mask) {    
            const rawValue = event.target.value.replace(/\D/g, ""); // Eliminar caracteres no numéricos
            let maskedValue = "";
            let maskIndex = 0;
            for (let i = 0; i < rawValue.length && maskIndex < mask.length; i++) {
                if (mask[maskIndex] === "9") {
                maskedValue += rawValue[i];
                maskIndex++;
                } else {
                maskedValue += mask[maskIndex];
                maskIndex++;
                i--; // Reintentar con el mismo carácter
                }
            }
            event.target.value = maskedValue;
            value = maskedValue;
            if (onChange) onChange(maskedValue)
        }else{
        const unformattedValue = unformatNumber(event.target.value);
        value = unformattedValue; // Asigna el valor sin puntos
        if (onChange) onChange(event.target.value); 
            event.target.value = formatNumber(unformattedValue); // Muestra el valor con puntos
        }
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
<div class="max-w-sm space-y-3">
    <div class="relative">
        {#if type == 'number'}
            <input
                required={required}
                inputmode="numeric"
                value={formatNumber(value)}
                on:input={handleCustomInput}
                placeholder=""
                id="hs-floating-input-email-value" class="peer p-4 block w-full border-gray-200 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none
                focus:pt-6
                focus:pb-2
                [&:not(:placeholder-shown)]:pt-6
                [&:not(:placeholder-shown)]:pb-2
                autofill:pt-6
                autofill:pb-2" 
            />
        {:else if type == 'date'}
            <input 
                type='date'
                bind:value={value} 
                required={required}
                id="hs-floating-input-email-value" class="peer p-4 block w-full border-gray-200 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none
                focus:pt-6
                focus:pb-2
                [&:not(:placeholder-shown)]:pt-6
                [&:not(:placeholder-shown)]:pb-2
                autofill:pt-6
                autofill:pb-2"  
            />
        {:else if type == 'password'}
            <input 
                type='password'
                bind:value={value} 
                required={required}
                id="hs-floating-input-email-value" class="peer p-4 block w-full border-gray-200 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none
                focus:pt-6
                focus:pb-2
                [&:not(:placeholder-shown)]:pt-6
                [&:not(:placeholder-shown)]:pb-2
                autofill:pt-6
                autofill:pb-2"
            />
        {:else if type == 'text' && mask != null}
            <input 
                type='text'
                required={required}
                on:input={handleInput}
                placeholder={mask}
                id="hs-floating-input-email-value" class="peer p-4 block w-full border-gray-200 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none
                focus:pt-6
                focus:pb-2
                [&:not(:placeholder-shown)]:pt-6
                [&:not(:placeholder-shown)]:pb-2
                autofill:pt-6
                autofill:pb-2" 
            />
        {:else}
            <input 
                type='text'
                bind:value={value} 
                required={required}
                id={id}
                on:input={(event) => handleInput(event, onChange)} 
                class="peer p-4 block w-full border-gray-200 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none
                focus:pt-6
                focus:pb-2
                [&:not(:placeholder-shown)]:pt-6
                [&:not(:placeholder-shown)]:pb-2
                autofill:pt-6
                autofill:pb-2" 
            />
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
        <!-- <input type={type != null ? type : 'text'} bind:value={value} class="input input-bordered w-full max-w-xs block" /> -->
        {#if errors != null && errors.message}
            <span class="mt-2 text-sm text-red-500 block">{errors.message}</span>
        {/if}
    </div>
</div>