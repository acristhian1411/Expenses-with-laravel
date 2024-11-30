<script>
    import { Textfield } from '@components/FormComponents';
    import {SearchIcon} from '@components/Icons';
    import { onMount } from 'svelte';
    import { createEventDispatcher } from 'svelte';
    const dispatch = createEventDispatcher();
    
    let query = '';
    
    let errors = null;
    let searchUrl = '/api/products';
    let options = [
    ];
  
    let filteredOptions = options;
  
    function checkItem(event,item) {
      if(event.target.checked == true) {
        dispatch('checked', item);
      }else{
        dispatch('remove', item);
      }
    }

    function getProducts(event) {
      
      if(event && event.target && event.target.value) {
        query = event.target.value;
        searchUrl = `api/products?product_name=${query}&product_barcode=${query}`;
      }else{
        searchUrl = `api/products`;
      }
      axios.get(`${searchUrl}`).then((response) => {
        options = response.data.data.map(x=>({...x,quantity:"1"}));
      }).catch((err) => {
        let detail = {
          detail: {
            type: 'delete',
            message: err.response.data.message
          }
        };
      });
    }
    
    onMount(() => {
      getProducts();
    });
  
  </script>
  
  <div class="grid grid-rows-2">
    <div class="p-4 gap-0" >
      <div class="flex justify-center">
        <label class="input input-bordered flex items-center gap-2">
          <input type="text" class="grow" placeholder="Search" on:change={getProducts} />
          <SearchIcon />
        </label>
      </div>
    </div>
    <div class="p-4">
      <table class="table w-full gap-0">
          <thead>
              <tr>
                <th class="text-lg">
                  Cant
                </th>
                <th class="text-lg">
                  Producto
                </th>
                <th class="text-lg">
                  Precio
                </th>
              </tr>
          </thead>
          <tbody>
            {#each options as item, i (item.id)}
              <tr class="hover">
                <td>
                  <Textfield 
                    label="Cant"
                    type="number"
                    bind:value={item.quantity}
                  />
                </td>
                <td>{item.product_desc}</td>
                <td>{item.product_selling_price}</td>
                <td class="text-center">
                  <button class="btn btn-primary" on:click={() => checkItem({target:{checked:true}},item)}>Seleccionar</button>
                  <button class="btn btn-secondary" on:click={() => checkItem({target:{checked:false}},item)}>Eliminar</button>
                </td>
              </tr>
            {/each}
          </tbody>
      </table>
    </div>
  </div>