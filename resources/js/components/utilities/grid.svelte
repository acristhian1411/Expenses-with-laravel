<script>
    export let columns = 12; // Número total de columnas de la cuadrícula
    export let gap = 3; // Espaciado entre columnas
  </script>
  
  <div class={`grid grid-cols-${columns} gap-${gap} gap-y-3 p-4`}>
    <slot/>
  </div>