<script>
    import { onMount } from 'svelte';
    let query = '';
    let selectedItem = null;
  
    const options = [
      { id: 1, name: 'Ella Lauda', group: 'Designer' },
      { id: 2, name: 'David Harrison', group: 'Designer' },
      { id: 3, name: 'James Collins', group: 'Backend' },
      { id: 4, name: 'Costa Quinn', group: 'Backend' },
      { id: 5, name: 'Lewis Clarke', group: 'Backend' },
      { id: 6, name: 'Mia Maya', group: 'Backend' }
    ];
  
    let filteredOptions = options;
  
    const filterOptions = () => {
      filteredOptions = options.filter(option =>
        option.name.toLowerCase().includes(query.toLowerCase())
      );
    };
  
    $: filterOptions();
  </script>
  
  <div class="w-full max-w-md mx-auto">
    <!-- Input field -->
    <div class="relative">
      <input
        type="text"
        placeholder="Type a name"
        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        bind:value={query}
      />
    </div>
  
    <!-- Dropdown -->
    <ul
      class="absolute z-10 w-full mt-2 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-auto"
      style="display: {filteredOptions.length > 0 ? 'block' : 'none'};"
    >
      <!-- Grouped options -->
      {#each Array.from(new Set(filteredOptions.map(option => option.group))) as group}
        <li>
          <div class="px-4 py-2 text-sm font-bold text-gray-700 uppercase bg-gray-100">{group}</div>
          {#each filteredOptions.filter(option => option.group === group) as option}
            <!-- svelte-ignore a11y-click-events-have-key-events -->
            <div
              class="px-4 py-2 cursor-pointer hover:bg-blue-100"
              on:click={() => (selectedItem = option)}
            >
              <div class="flex items-center">
                <img
                  src={`https://ui-avatars.com/api/?name=${option.name}&size=32`}
                  alt={option.name}
                  class="w-8 h-8 rounded-full mr-3"
                />
                {option.name}
              </div>
            </div>
          {/each}
        </li>
      {/each}
    </ul>
  
    <!-- Selected item -->
    {#if selectedItem}
      <div class="mt-4 text-gray-700">
        Selected: <strong>{selectedItem.name}</strong>
      </div>
    {/if}
  </div>
  