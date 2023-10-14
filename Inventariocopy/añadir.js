document.addEventListener("DOMContentLoaded", function() {
    const mostrarFormularioBtn = document.getElementById("mostrar-formulario");
    const formularioRegistro = document.getElementById("formulario-registro");

    mostrarFormularioBtn.addEventListener("click", function() {
        formularioRegistro.style.display = "block"; // Muestra el formulario
        mostrarFormularioBtn.style.display = "none"; // Oculta el botón "Agregar Producto"
    });

    function cancelarRegistro() {
        formularioRegistro.style.display = "none"; // Oculta el formulario
        mostrarFormularioBtn.style.display = "block"; // Muestra el botón "Agregar Producto" nuevamente
    }

    // Agrega el evento de cancelar al botón "Cancelar"
    const cancelarBtn = document.querySelector("#formulario-registro input[type='button']");
    cancelarBtn.addEventListener("click", cancelarRegistro);
});
