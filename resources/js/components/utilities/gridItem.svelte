<script>
    export let span = 1; // Columnas que ocupa este item (por defecto, 1)
  </script>
  
  <div class={`col-span-${span}`}>
    <slot />
  </div>