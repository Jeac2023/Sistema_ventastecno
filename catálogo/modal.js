// Obtener elementos de la ventana modal
const modal = document.getElementById('modal');
const cerrarModal = document.getElementById('cerrar-modal');
const comprarModal = document.getElementById('comprar-modal');
const modalProducto = document.getElementById('modal-producto');
const modalCodigo = document.getElementById('modal-codigo');
const modalPrecio = document.getElementById('modal-precio');
const modalStock = document.getElementById('modal-stock');
const modalImagen = document.getElementById('modal-imagen');

// Obtener todos los botones "Comprar"
const comprarBtns = document.querySelectorAll('.comprar');

// Agregar evento clic a los botones "Comprar"
comprarBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
        // Rellenar la ventana modal con los datos del producto
        modalProducto.textContent = btn.getAttribute('data-nombre');
        modalCodigo.textContent = btn.getAttribute('data-codigo');
        modalPrecio.textContent = 'S/ ' + parseFloat(btn.getAttribute('data-precio')).toFixed(2);
        modalStock.textContent = btn.getAttribute('data-stock') + ' Disponibles';
        modalImagen.src = 'data:image/jpeg;base64,' + btn.getAttribute('data-imagen');

        // Mostrar la ventana modal
        modal.style.display = 'block';
    });
});

// Agregar evento clic para cerrar la ventana modal
cerrarModal.addEventListener('click', () => {
    modal.style.display = 'none';
});

// Cierra la ventana modal si se hace clic fuera de ella
window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});

// Agregar evento clic para el botón "Comprar" en la ventana modal
comprarModal.addEventListener('click', () => {
    // Aquí puedes agregar la lógica para realizar la compra
    alert('Compra realizada');
    modal.style.display = 'none';
});
