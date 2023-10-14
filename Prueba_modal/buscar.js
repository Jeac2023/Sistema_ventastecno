$(document).ready(function() {
    let body = document.body;
    // Obtener la referencia al campo de búsqueda
    var busquedaInput = $("#input-busqueda");
    // Obtener todos los productos
    var todosLosProductos = $(".producto");
    // Escuchar el evento de cambio en el campo de búsqueda
    busquedaInput.on("input", function() {
        // Obtener el valor de búsqueda
        var valorBusqueda = busquedaInput.val().toLowerCase();

        // Filtrar los productos en la tabla
        var productosEncontrados = 0;
        todosLosProductos.each(function() {
            var nombreProducto = $(this).find("h3").text().toLowerCase();
            var codigoProducto = $(this).find(".codigo").text().toLowerCase();

            if (nombreProducto.includes(valorBusqueda) || codigoProducto.includes(valorBusqueda)) {
                $(this).show();
                productosEncontrados++;
            } else {
                $(this).hide();
            }
        });
        //console.log(valorBusqueda);
        if (valorBusqueda == ""){
            limpiarCampoBusqueda();
        }
        // Mostrar u ocultar el mensaje de no resultados
        if (productosEncontrados > 0) {
            body.classList.remove('nofound');
            document.getElementById('mensaje-no-resultados').style.display = 'none';
            
        } else {
            body.classList.add('nofound');
            document.getElementById('mensaje-no-resultados').style.display = 'block';   
        }
    });

    const limpiarBtn = document.getElementById('limpiar-busqueda');
    // Función para limpiar el campo de búsqueda y mostrar todos los productos
    function limpiarCampoBusqueda() {
        busquedaInput.val(''); // Establecer el valor en una cadena vacía
        document.getElementById('mensaje-no-resultados').style.display = 'none';
        todosLosProductos.show(); // Mostrar todos los productos
        body.classList.remove('nofound');
        //body.classList.add('tema-claro');
    }

    // Agregar un evento de clic al botón de limpiar
    limpiarBtn.addEventListener('click', limpiarCampoBusqueda);
    window.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            limpiarCampoBusqueda();
        }
    });
});

