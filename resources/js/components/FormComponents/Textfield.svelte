<script>
    export let label;
    export let value;
    export let errors;
</script>
<div class="mb-4 flex items-center ">
    <span class="mr-2">{label}</span>
    <div class="flex flex-col w-full">
        <input type="text" bind:value={value} class="input input-bordered w-full max-w-xs block" />
        {#if errors != null && errors.message}
            <span class="mt-2 text-sm text-red-500 block">{errors.message}</span>
        {/if}
    </div>
</div>