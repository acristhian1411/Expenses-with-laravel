<script>
    import { formatNumber } from '@components/utilities/NumberFormat.js';
    import axios from 'axios';
    import { onMount } from 'svelte';
    // Datos de ejemplo para el reporte de cierre de caja
    let today = new Date();
    let errors = null;
    let cierreCaja ;
    export let tillId;
    export let amount 
    export let person_id;

    function getTillData(){
      axios.get(`/api/tills/${tillId}/closeReportResume`).then((response) => {
        cierreCaja = response.data;
      }).catch((err) => {
        errors = err.response.data.details ? err.response.data.details : null;
      });
    }

    function handleSubmit(event) {
      event.preventDefault();
      axios.post(`/api/tills/${tillId}/close`, {
          till_id:tillId,
          td_amount:amount,
          person_id:person_id
      }).then((res) => {
          let detail = {
              detail: {
                  type: 'success',
                  message: res.data.message
              }
          };
      }).catch((err) => {
          errors = err.response.data.details ? err.response.data.details : null;
          let detail = {
              detail: {
                  type: 'error',
                  message: err.response.data.message
              }
          };
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
  
  <div class="p-6 bg-base-200 rounded-lg shadow-md">
    <!-- <h2 class="text-2xl font-bold mb-4">Reporte de Cierre de Caja</h2> -->
    <div class="space-y-4">
      <!-- Fecha del reporte -->
      <!-- <div class="flex justify-between">
        <span class="font-semibold">Fecha:</span>
        <span>{cierreCaja.fecha}</span>
      </div> -->
  
      <!-- Caja Inicial -->
      {#if cierreCaja && cierreCaja.incomes.length > 0}
        {#each cierreCaja.incomes as income}
          <div class="flex justify-between">
            <span class="font-semibold">Ingresos {income.payment_type_desc}:</span>
            <span class="text-green-500">Gs. {formatNumber(income.total_amount)}</span>
          </div>
        {/each}
      {/if}
      
      {#if cierreCaja && cierreCaja.expenses.length > 0}
        {#each cierreCaja.expenses as expense}
          <div class="flex justify-between">
            <span class="font-semibold">Gastos {expense.payment_type_desc}:</span>
            <span class="text-red-500">Gs. {formatNumber(expense.total_amount)}</span>
          </div>
        {/each}
      {/if}
  
      <!-- Total de Ingresos -->
      <div class="flex justify-between">
        <span class="font-semibold">Total ingresos:</span>
        {#if cierreCaja}
          <!-- use reduse to sum the total_amount of the expenses -->
            {#if cierreCaja.incomes.length > 0}
              <span class="text-green-500">Gs. {formatNumber(cierreCaja.incomes.reduce((acc, curr) => acc + curr.total_amount, 0))}</span>
            {:else}
              <span class="text-green-500">Gs. {formatNumber(0)}</span>
            {/if}
        {/if}
      </div>
      <!-- Gastos -->
      <div class="flex justify-between">
        <span class="font-semibold">Total gastos:</span>
        {#if cierreCaja}
          <!-- use reduse to sum the total_amount of the expenses -->
            {#if cierreCaja.expenses.length > 0}
              <span class="text-red-500">Gs. {formatNumber(cierreCaja.expenses.reduce((acc, curr) => acc + curr.total_amount, 0))}</span>
            {:else}
              <span class="text-red-500">Gs. {formatNumber(0)}</span>
            {/if}
        {/if}
      </div>

      <hr class="my-4 border-t"/>

      <!-- Diferencia de Ingresos -->
        <div class="flex justify-between">
          <span class="font-semibold">Caja actual</span>
          {#if cierreCaja}
            {#if cierreCaja}
              <span>Gs. {formatNumber(
                cierreCaja.incomes.reduce((acc,curr)=>acc+curr.total_amount,0) - 
                cierreCaja.expenses.reduce((acc, curr) => acc + curr.total_amount, 0)
                )}</span>
            {:else}
              <span>Gs. {formatNumber(0)}</span>
            {/if}
          {/if}
        </div>
    
    </div>
  </div>
  <button class="btn btn-primary mt-4" on:click={handleSubmit}>Cerrar caja</button>
  <button class="btn btn-info mt-4">Imprimir</button>
  <button class="btn btn-secondary mt-4">Cancelar</button>
