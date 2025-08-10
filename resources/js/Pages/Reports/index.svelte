<script>
    import axios from 'axios'
    import { onMount } from 'svelte';
    import {formatNumber, unformatNumber} from '@components/utilities/NumberFormat.js';
    let startDate = new Date().toISOString().slice(0, 10);
    let endDate = new Date().toISOString().slice(0, 10);
    let type = 'ventas'; 
    let providers = []
    let selectedEntity = '';
    let entities = [];
    let report = []
  
    function getClients(){
        axios.get('/api/persons?p_type_id=2').then((response) => {
            entities = response.data.data;
        });
    }

    function getProviders(){
        axios.get('/api/persons?p_type_id=1').then((response) => {
            providers = response.data.data;
        });
    }

    function getReport(){
        let url = ''
        if(type == 'ventas'){
            url = '/api/sales/report'
        }else{
            url = '/api/purchases/report'
        }
        axios.get(url, {
            params: {
                start_date: startDate,
                end_date: endDate,
                type,
                entity: selectedEntity,
                from_view: true
            }
        }).then((response) => {
            report = response.data.data;
        });
    }

    function exportarPDF() {
      let url = '';
      if(type == 'ventas'){
        url = '/api/sales/report/pdf'
      }else{
        url = '/api/purchases/report/pdf'
      }
      const params = new URLSearchParams({
        start_date: startDate,
        end_date: endDate,
        type,
        entity: selectedEntity,
        from_view: false
      });
  
      window.open(`${url}?${params.toString()}`, '_blank');
    }

    onMount(() => {
        getClients();
        getProviders();
    });

  </script>
  
  <svelte:head>
    <title>Reportes de ventas y compras</title>
  </svelte:head>
  
  <h1 align="center" class="text-4xl font-bold mb-8">Reportes</h1>
  
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div>
      <!-- svelte-ignore a11y-label-has-associated-control -->
      <label class="block text-sm font-medium mb-1">Fecha desde</label>
      <input type="date" bind:value={startDate} class="w-full border rounded px-2 py-1" />
    </div>
    <div>
      <!-- svelte-ignore a11y-label-has-associated-control -->
      <label class="block text-sm font-medium mb-1">Fecha hasta</label>
      <input type="date" bind:value={endDate} class="w-full border rounded px-2 py-1" />
    </div>
    <div>
      <!-- svelte-ignore a11y-label-has-associated-control -->
      <label class="block text-sm font-medium mb-1">Tipo de reporte</label>
      <select bind:value={type} class="w-full border rounded px-2 py-1">
        <option value="ventas">Ventas</option>
        <option value="compras">Compras</option>
      </select>
    </div>
    <div>
      <!-- svelte-ignore a11y-label-has-associated-control -->
      <label class="block text-sm font-medium mb-1">Cliente/Proveedor</label>
      <select bind:value={selectedEntity} class="w-full border rounded px-2 py-1">
        <option value="">Todos</option>
        {#if type == 'ventas'}
            {#each entities as entity}
            <option value={entity}>{entity.person_fname} {entity.person_lastname}</option>
            {/each}
        {/if}
        {#if type == 'compras'}
            {#each providers as provider}
            <option value={provider}>{provider.person_fname} {provider.person_lastname}</option>
            {/each}
        {/if}
      </select>
    </div>
  </div>
  
  <div class="flex justify-end mb-4 gap-2">
    <button on:click={getReport} class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
      Generar Reporte
    </button>
    <button on:click={exportarPDF} class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
      Exportar PDF
    </button>
  </div>
  
  <!-- Ejemplo de tabla de resultados -->
  <div class="overflow-x-auto border rounded shadow">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-500 text-left">
        <tr>
          <th class="px-4 py-2">Fecha</th>
          <th class="px-4 py-2">Cliente</th>
          <th class="px-4 py-2">N° de factura</th>
          <th class="px-4 py-2">Monto</th>
        </tr>
      </thead>
      <tbody>
        {#each report as item}
            <tr class="hover:bg-gray-500">
            <td class="px-4 py-2">{item.date}</td>
            <td class="px-4 py-2">{item.person_fname} {item.person_lastname}</td>
            <td class="px-4 py-2">{item.number}</td>
            <td class="px-4 py-2 text-right">{formatNumber(item.total)}</td>
            </tr>
        {/each}

        {#if report.length == 0}
            <tr>
                <td colspan="4" class="px-4 py-2 text-center">No hay datos</td>
            </tr>
        {:else}
            <tr>
                <td colspan="3" class="px-4 py-2 text-center">Total:</td>
                <td class="px-4 py-2 text-center">{formatNumber(report.reduce((total, item) => total + item.total, 0))}</td>
            </tr>
        {/if}
      </tbody>
    </table>
  </div>
  