const swURL = '/ModuloArethaE/service-worker.js';

const registerServiceWorker = async () => {
    if ("serviceWorker" in navigator) {
      try {
        const registration = await navigator.serviceWorker.register(swURL);
        if (registration.installing) {
          console.log("Instalando el Service worker");
        } else if (registration.waiting) {
          console.log("Service worker instalado");
        } else if (registration.active) {
          console.log("Service worker activo");
        }
      } catch (error) {
        console.error(`Falló el registro con el ${error}`);
      }
    }
  };
  registerServiceWorker();
  navigator.serviceWorker.onmessage=(event)=>{
    console.log('debug: clients message');
    if(event.data&& event.data.type==='isNetwork'){
      console.log('debug: clients message entra');
      Swal.fire({
        title: '¡Sincornizacion realizada!',
        text: 'Se establecio la conexión a red, los cambios en modo fuera de linea se aplicaron. \n Debe actulizar la pagina.',
        icon: 'success',
        confirmButtonText: 'De acuerdo'
      });
      afLoadPage("#content", "resources/dt.business.php", {}, false);
    }
  };
