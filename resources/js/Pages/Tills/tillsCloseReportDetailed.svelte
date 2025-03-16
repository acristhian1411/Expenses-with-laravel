<script>
    import {formatNumber } from '@components/utilities/NumberFormat.js';
    import { onMount } from 'svelte';

    export let id;
    let errors = null;
    let cierreCaja;

    function getTillData(){
        axios.get(`/api/tills/${id}/closeReportDetailed`).then((response) => {
            cierreCaja = response.data;
        }).catch((err) => {
            errors = err.response.data.details ? err.response.data.details : null;
        });
    }

    onMount(async () => {
        getTillData();
    });

</script>
  
  {#if errors}
    <p>
      {errors}
    </p>
  {/if}

{#if cierreCaja}
  <div class="p-6 bg-base-200 rounded-lg shadow-md space-y-6">
    <h2 class="text-2xl font-bold mb-4">Detalles del Cierre de Caja</h2>
  
    <!-- Tabla de Ingresos -->
    <div>
      <h3 class="text-xl font-semibold mb-3">Ingresos</h3>
      <div class="overflow-x-auto">
        <table class="table w-full">
          <thead>
            <tr>
              <th class="text-left">Fecha</th>
              <th class="text-left">Cliente</th>
              <th class="text-left">Monto</th>
              <th class="text-left">Descripción</th>
            </tr>
          </thead>
          <tbody>
            {#if cierreCaja.incomes.length > 0}
              {#each cierreCaja.incomes as income}
                <tr>
                  <td>{income.fecha}</td>
                  <td>{income.cliente}</td>
                  <td class="text-green-500">Gs. {formatNumber(income.monto)}</td>
                  <td>{income.descripcion}</td>
                </tr>
              {/each}
            {:else}
              <tr>
                <td colspan="4" class="text-center">No hay ingresos registrados</td>
              </tr>
            {/if}
          </tbody>
        </table>
      </div>
    </div>
  
    <!-- Tabla de Gastos -->
    <div>
      <h3 class="text-xl font-semibold mb-3">Gastos</h3>
      <div class="overflow-x-auto">
        <table class="table w-full">
          <thead>
            <tr>
              <th class="text-left">Fecha</th>
              <th class="text-left">Proveedor</th>
              <th class="text-left">Monto</th>
              <th class="text-left">Descripción</th>
            </tr>
          </thead>
          <tbody>
            {#if cierreCaja.expenses.length > 0}
              {#each cierreCaja.expenses as expense}
                <tr>
                  <td>{expense.fecha}</td>
                  <td>{expense.proveedor}</td>
                  <td class="text-red-500">Gs. {formatNumber(expense.monto)}</td>
                  <td>{expense.descripcion}</td>
                </tr>
              {/each}
            {:else}
              <tr>
                <td colspan="4" class="text-center">No hay gastos registrados</td>
              </tr>
            {/if}
          </tbody>
        </table>
      </div>
    </div>
  </div>
{/if}