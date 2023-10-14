window.addEventListener('DOMContentLoaded', () => {
  // Cargar la tabla de inventario al cargar la página
  cargarTablaInventario();
});

function cargarTablaInventario() {
  // Realizar una solicitud AJAX para obtener los datos del inventario desde el servidor
  const xhr = new XMLHttpRequest();
  xhr.open('GET', 'obtener_inventario.php', true);
  xhr.onload = function () {
      if (xhr.status === 200) {
          // Actualizar el contenido de la sección de la tabla de inventario
          const tablaInventario = document.getElementById('tabla-inventario');
          tablaInventario.innerHTML = xhr.responseText;

          // Agregar eventos a los botones de editar y borrar
          const editarButtons = document.getElementsByClassName('editar-btn');
          for (let i = 0; i < editarButtons.length; i++) {
              const button = editarButtons[i];
              button.addEventListener('click', editarProducto);
          }

          const borrarButtons = document.getElementsByClassName('borrar-btn');
          for (let i = 0; i < borrarButtons.length; i++) {
              const button = borrarButtons[i];
              button.addEventListener('click', confirmarBorrarProducto);
          }
      }
  };
  xhr.send();
}

function editarProducto(event) {
  // Detener la propagación del evento para evitar que se seleccione la fila
  event.stopPropagation();

  const idProducto = event.target.getAttribute('data-id');
  // Redirigir al archivo de edición de producto
  window.location.href = `editar_producto.php?id=${idProducto}`;
}

function confirmarBorrarProducto(event) {
  // Detener la propagación del evento para evitar que se seleccione la fila
  event.stopPropagation();

  const idProducto = event.target.getAttribute('data-id');
  // Mostrar un mensaje de confirmación antes de borrar el producto
  Swal.fire({
    title: '¿Estás seguro?',
    text: '¿Estás seguro que quieres borrar este producto?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      // Realizar una solicitud AJAX para eliminar el producto desde el servidor
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'eliminar_producto.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onload = function () {
        if (xhr.status === 200) {
          // Recargar la tabla de inventario
          cargarTablaInventario();
        }
      };
      xhr.send(`id=${idProducto}`);
    }
  });
}



