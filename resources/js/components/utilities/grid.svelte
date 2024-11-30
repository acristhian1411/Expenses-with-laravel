<script>
     export let columns = 12; // Número de columnas en el grid
    export let gap = 3; // Espaciado entre columnas
  </script>
  

  <div class={`grid grid-cols-${columns} gap-${gap}`}>
      <slot/>
  </div>
  
<!-- 
<div 
class={`grid grid-cols-${columns} gap-${gap} p-4`} 
style="grid-auto-rows: minmax(0, auto);">
<slot />
</div> -->