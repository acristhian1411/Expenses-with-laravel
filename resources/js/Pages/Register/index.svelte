<script>
    let name = '';
    let email = '';
    let password = '';
  
    const register = async () => {
      const response = await fetch('/api/register', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ name, email, password }),
      });
  
      if (response.ok) {
        // Redirigir o manejar éxito
      } else {
        // Mostrar error
      }
    };
  </script>
  
  <form on:submit|preventDefault={register}>
    <input type="text" bind:value={name} placeholder="Name" required />
    <input type="email" bind:value={email} placeholder="Email" required />
    <input type="password" bind:value={password} placeholder="Password" required />
    <button type="submit">Register</button>
  </form>