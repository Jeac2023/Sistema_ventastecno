// Obtener referencias a elementos HTML
const abrirModalBtn = document.getElementById('abrirModal');
const btnsEditar = document.querySelectorAll('.editar');
const btnsEliminar = document.querySelectorAll('.eliminar');
const btnsVender = document.querySelectorAll('.vender');
const abrirModal2Btn = document.getElementById('abrirModal3');
const modalVender = document.getElementById('Modal-vender');
const cerrarModalBtn = document.getElementById('cerrarModal');
const CerrarCarga = document.getElementById('cerrar-carga');
const btnCerrarEdicion = document.getElementById('cerrar-modal-edicion');
const Cerrarvender = document.getElementById('cerrar-vender');
const modal = document.getElementById('Modal-agregar');
const modalEdicion = document.getElementById('Modal-editar');
const modalCarga = document.getElementById('Modal-cargar');
const formulario = document.getElementById('formulario');

// Función para abrir la ventana modal
function abrirModal() {
    modal.style.display = 'block';
}

function abrirModal2() {
    modalCarga.style.display = 'block';
}
function modalvender() {
    modalVender.style.display = 'block';
}

// Función para cerrar la ventana modal
function cerrarModal() {
    modal.style.display = 'none';
    modalEdicion.style.display = 'none';
    modalCarga.style.display = 'none';
    modalVender.style.display = 'none';
}
function cerrarModal2() {
    modalCarga.style.display = 'none';
}
function cerrarModalvender() {
    modalVender.style.display = 'none';
}

// Abrir la ventana modal al hacer clic en el botón "Agregar Producto"
abrirModalBtn.addEventListener('click', abrirModal);
cerrarModalBtn.addEventListener('click', cerrarModal);
abrirModal2Btn.addEventListener('click', abrirModal2);
CerrarCarga.addEventListener('click',cerrarModal2);
Cerrarvender.addEventListener('click',cerrarModalvender);
// Cerrar la ventana modal al presionar la tecla "Esc"
window.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        cerrarModal();
    }
});
window.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        cerrarModal2();
    }
});

// Agregar eventos de clic a los botones de editar
btnsEditar.forEach(function (btn) {
    btn.addEventListener('click', function () {
        var id = btn.getAttribute('data-id'); // Obtener el ID del producto
        var producto = btn.getAttribute('data-producto');
        var codigo = btn.getAttribute('data-codigo');
        var precio = btn.getAttribute('data-precio');
        var stock = btn.getAttribute('data-stock');
        var imagenBase64 = btn.getAttribute('data-imagen'); // Obtener la imagen en formato base64

        // Rellenar el formulario con los datos obtenidos
        document.getElementById('producto-id-e').value = id;
        document.getElementById('nombre-e').value = producto;
        document.getElementById('codigo-e').value = codigo;
        document.getElementById('precio-e').value = precio;
        document.getElementById('stock-e').value = stock;
        document.getElementById('imagen-preview').src = 'data:image/jpeg;base64,' + imagenBase64;

        // Mostrar la ventana modal de edición
        modalEdicion.style.display = 'block';
    });
});
btnsVender.forEach(function (btn) {
    btn.addEventListener('click', function () {
        // Mostrar la ventana modal de edición
        modalVender.style.display = 'block';
    });
});
// Agregar evento de clic al botón de cerrar en la ventana de edición
btnCerrarEdicion.addEventListener('click', cerrarModal);

btnsEliminar.forEach(function (btn) {
    btn.addEventListener('click', function () {
        var id = btn.getAttribute('data-id'); // Obtén el ID del registro a eliminar
        var nombre = btn.getAttribute('data-producto');
        Swal.fire({
            title: '¿Estás seguro de que deseas eliminar el producto ' + nombre + '?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirecciona a eliminar_registro.php pasando el ID como parámetro en la URL
                window.location.href = "eliminar_registro.php?id=" + id;
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const botonCambioTema = document.getElementById('cambio-tema');
    const body = document.body;
    const cabecera = document.querySelector('h1'); // Corregido para seleccionar el elemento h1
    // Agrega un evento de clic al botón de cambio de tema
    botonCambioTema.addEventListener('click', function() {
        // Cambia el tema según la clase actual del body
        if (body.classList.contains('tema-claro')) {
            body.classList.remove('tema-claro');
            body.classList.add('tema-oscuro');
            cabecera.classList.remove('claro');
            cabecera.classList.add('oscuro');

        } else {
            body.classList.remove('tema-oscuro');
            body.classList.add('tema-claro');
            cabecera.classList.remove('oscuro');
            cabecera.classList.add('claro');
        }     
    });
});


document.addEventListener('DOMContentLoaded', function () {
    // Obtener el botón "Guardar Cambios"
    const botonGuardarCambios = document.getElementById('boton-guardar-cambios');
    
    // Agregar un evento de clic al botón
    botonGuardarCambios.addEventListener('click', function () {
        // Mostrar una ventana de confirmación con SweetAlert2
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Estás a punto de actualizar este producto. ¿Deseas continuar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            // Si el usuario confirma, enviar el formulario
            if (result.isConfirmed) {
                document.getElementById('formulario-edicion').submit();
            }
        });
    });
});
