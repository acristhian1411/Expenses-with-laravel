<script>
    import { inertia } from '@inertiajs/inertia-svelte';
    import { CartIcon, MoneyIcon, ProductIcon} from '@components/Icons/';
  </script>
  
  <div class="grid grid-cols-2 gap-6 p-8">
    <button class="flex flex-col items-center justify-center p-6 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700" use:inertia={{ href: '/sales' }}>
      <!-- SVG Icon for Ventas -->
      <CartIcon/>
      
      <span>Ventas</span>
    </button>
    <button class="flex flex-col items-center justify-center p-6 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700" use:inertia={{ href: '/purchases' }}>
      <!-- SVG Icon for Compras -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zm-2 11H8a2 2 0 00-2 2v1h12v-1a2 2 0 00-2-2z" />
        </svg>
      <!-- <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l1.6-8H6.4L5 4H3" />
      </svg> -->
      <span>Compras</span>
    </button>
  
   
  
    <button class="flex flex-col items-center justify-center p-6 bg-yellow-600 text-white rounded-lg shadow-md hover:bg-yellow-700" use:inertia={{ href: '/tills' }}>
      <!-- SVG Icon for Cajas -->
      <MoneyIcon/>
      <!-- <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4 -4m5 0a9 9 0 11-18 0a9 9 0 0118 0z" />
      </svg> -->
      <span>Cajas</span>
    </button>
  
    <button class="flex flex-col items-center justify-center p-6 bg-purple-600 text-white rounded-lg shadow-md hover:bg-purple-700" use:inertia={{ href: '/products' }}>
      <!-- SVG Icon for Productos -->
        <ProductIcon
          className="w-12 h-12 mb-2"
          stroke="currentColor"
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="1"
        />
      <!-- <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h1v11a1 1 0 001 1h14a1 1 0 001-1V10h1M12 3v4m-2-2h4M5 10h14l1 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1v-2l1-1z" />
      </svg> -->
      <span>Productos</span>
    </button>
  </div>
  