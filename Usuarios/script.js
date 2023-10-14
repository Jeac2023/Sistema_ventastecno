function mostrarModal(nombreUsuario) {
    const modal = document.getElementById('modal');
    const nombreInput = modal.querySelector('#nombre');
    nombreInput.value = nombreUsuario;
    modal.showModal();
  }

  function cerrarModal() {
    const modal = document.getElementById('modal');
    modal.close();
  }
  function cerrarModal2() {
    const modal2 = document.getElementById('modal-2');
    modal2.close();
  }
  function hola(nombreUsuario) {
    const modal2 = document.getElementById('modal-2');
    const nombreInput = modal2.querySelector('#nombre');
    nombreInput.value = nombreUsuario;
    modal2.showModal2();
  }