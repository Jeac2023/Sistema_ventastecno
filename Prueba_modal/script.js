document.addEventListener('DOMContentLoaded', function() {
    let foco = document.getElementById('foco');
    const botonCambioTema = document.getElementById('cambio-tema');
    const body = document.body;
    const cabecera = document.querySelector('h1'); // Corregido para seleccionar el elemento h1
    
    
    const modoGuardado = localStorage.getItem("modo");
        if (modoGuardado === "oscuro") {
        document.body.classList.remove("tema-claro");
        document.body.classList.add("tema-oscuro");
        cabecera.classList.remove('claro');
        cabecera.classList.add('oscuro');
        } else {
        document.body.classList.remove("tema-oscuro");
        document.body.classList.add("tema-claro");
        cabecera.classList.remove('oscuro');
        cabecera.classList.add('claro');
        }

    // Agrega un evento de clic al botón de cambio de tema
    botonCambioTema.addEventListener('click', function() {
        // Cambia el tema según la clase actual del body
        if (body.classList.contains('tema-claro')) {
            body.classList.remove('tema-claro');
            body.classList.add('tema-oscuro');
            cabecera.classList.remove('claro');
            cabecera.classList.add('oscuro');
            foco.style.backgroundColor = '#89f900';
            localStorage.setItem("modo", "oscuro");
            
        } else {
            body.classList.remove('tema-oscuro');
            body.classList.add('tema-claro');
            cabecera.classList.remove('oscuro');
            cabecera.classList.add('claro');
            foco.style.backgroundColor = 'blue';
            localStorage.setItem("modo", "claro");
        } 
    
    });
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

// Obtener referencias a elementos HTML
const abrirModalAdd = document.getElementById('Agregar');
const cerrarModalAdd = document.getElementById('cerrarModal');
const modalAgregar = document.getElementById('Modal-agregar');
function abrirModalAgregar() {
    modalAgregar.style.display = 'block';
}
function cerrarModal() {
    modalAgregar.style.display = 'none';
    modalEdicion.style.display = 'none';
    modalCarga.style.display = 'none';
    modalVender.style.display = 'none';
}
abrirModalAdd.addEventListener('click', abrirModalAgregar);
cerrarModalAdd.addEventListener('click', cerrarModal);

//Modal Carga Masiva
const abrirModalCarga = document.getElementById('Cargar');
const modalCarga = document.getElementById('Modal-cargar');
const CerrarCarga = document.getElementById('cerrar-carga');

function abrirModalCargar() {
    modalCarga.style.display = 'block';
}
function cerrarModal2() {
    modalCarga.style.display = 'none';
}
abrirModalCarga.addEventListener('click', abrirModalCargar);
CerrarCarga.addEventListener('click',cerrarModal2);

//Modal Venta
const btnsVender = document.querySelectorAll('.vender');
const modalVender = document.getElementById('Modal-vender');
const Cerrarvender = document.getElementById('cerrar-vender');
// function modalvender() {
//     modalVender.style.display = 'block';
// }
function cerrarModalvender() {
    modalVender.style.display = 'none';
}

// btnsVender.forEach(function (btn) {
//     btn.addEventListener('click', function () {
//         // Mostrar la ventana modal de edición
//         modalVender.style.display = 'block';
//     });
// });
Cerrarvender.addEventListener('click',cerrarModalvender);


//Modal editar
const btnsEditar = document.querySelectorAll('.editar');
const btnCerrarEdicion = document.getElementById('cerrar-modal-edicion');
const modalEdicion = document.getElementById('Modal-editar');
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
btnCerrarEdicion.addEventListener('click', cerrarModal);

//Eliminar
const btnsEliminar = document.querySelectorAll('.eliminar');
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

window.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        cerrarModal();
        cerrarModal2();
    }
});

