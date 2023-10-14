$(document).ready(function() {
    // Obtener la referencia al campo de búsqueda
    var busquedaInput = $("#busqueda");
    // Obtener la referencia al mensaje de no resultados
    var mensajeNoResultados = $("#mensaje-no-resultados");

    // Escuchar el evento de cambio en el campo de búsqueda
    busquedaInput.on("input", function() {
        // Obtener el valor de búsqueda
        var valorBusqueda = busquedaInput.val().toLowerCase();

        // Filtrar los productos en la tabla
        var productosEncontrados = 0;
        $("#tabla-ventas tr").each(function() {
            var producto = $(this).find("td:first-child").text().toLowerCase();
            var codigo = $(this).find("td:nth-child(2)").text().toLowerCase();

            if (producto.includes(valorBusqueda) || codigo.includes(valorBusqueda)) {
                $(this).show();
                productosEncontrados++;
            } else {
                $(this).hide();
            }
        });

        // Mostrar u ocultar el mensaje de no resultados
        if (productosEncontrados > 0) {
            mensajeNoResultados.hide();
        } else {
            mensajeNoResultados.show();
        }
    });
});
