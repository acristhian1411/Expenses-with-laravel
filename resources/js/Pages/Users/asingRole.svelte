<script>
    import { onMount } from 'svelte';
    import { writable } from 'svelte/store';
    import axios from 'axios';

    // Estado para manejar el usuario y roles
    export let userId ; // Cambia esto por el ID del usuario que deseas modificar
    export let role; // Cambia esto por el ID del rol que deseas asignar
    let roles = [];
    let selectedRole = '';
    let message = '';

    // Cargar los roles disponibles
    onMount(async () => {
        selectedRole = role[0] ? role[0] : '';
        try {
            const response = await axios.get('/api/roles'); // Asegúrate de tener esta ruta en tu API
            roles = response.data.data;
        } catch (error) {
            console.error('Error al cargar roles:', error);
        }
    });

    // Función para asignar rol
    async function assignRole() {
        if (!selectedRole) {
            message = 'Por favor selecciona un rol.';
            return;
        }

        try {
            const response = await axios.post(`/api/users/${userId}/assign-role`, {
                role: selectedRole
            });
            message = response.data.message;
        } catch (error) {
            console.error('Error al asignar rol:', error);
            message = error.response?.data?.message || 'Ocurrió un error.';
        }
    }
</script>

<div class="p-4 max-w-md mx-auto">
    <h2 class="text-lg font-semibold mb-4">Asignar Rol al Usuario</h2>
    <label for="role" class="block mb-2">Seleccionar Rol:</label>
    <select id="role" bind:value={selectedRole} class="border border-gray-300 rounded p-2 w-full mb-4">
        <option value="">-- Selecciona un rol --</option>
        {#each roles as role}
            <option value={role.name}>{role.name}</option>
        {/each}
    </select>

    <button on:click={assignRole} class="bg-blue-500 text-white rounded p-2">
        Asignar Rol
    </button>

    {#if message}
        <p class="mt-4">{message}</p>
    {/if}
</div>

<style>
    /* Puedes agregar estilos adicionales aquí */
</style>
