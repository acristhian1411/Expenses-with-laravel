<script>
    import { Alert } from '@/components/Alerts';
    import { Inertia } from '@inertiajs/inertia';
    let email = '';
    let password = '';
    let alertMessage = '';
    let alertType = '';
	  let openAlert = false;

    function closeAlert() {
		openAlert = false;
	}

	function OpenAlertMessage(event) {
		console.log('details desde index',event.detail);
		openAlert = true;
		alertType = event.detail.type;
		alertMessage = event.detail.message;
	}
    const login = async () => {
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      const response = await fetch('/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({ email, password }),
      });
  
      if (response.ok) {
        // Redirigir o manejar éxito
        OpenAlertMessage({detail: {type: 'success', message: 'Inicio de sesión exitoso'}});
        Inertia.visit('/');
      } else {
        OpenAlertMessage({detail: {type: 'error', message: response.data.message}});
      }
    };
  </script>
  {#if openAlert}
    <Alert {alertMessage} {alertType} on:close={closeAlert} />
  {/if}
  <form on:submit|preventDefault={login}>
    <input type="email" bind:value={email} placeholder="Email" required />
    <input type="password" bind:value={password} placeholder="Password" required />
    <button type="submit">Login</button>
  </form>
  