$(document).ready(function() {
    // Función para actualizar la tabla de carrito de compras
    function actualizarTablaCarrito() {
        var tablaCarrito = $("#tabla-carrito tbody");
        tablaCarrito.empty(); // Limpiar la tabla antes de actualizar

        for (var i = 0; i < carrito.length; i++) {
            var producto = carrito[i].producto;
            var codigo = carrito[i].codigo;
            var cantidad = carrito[i].cantidad;

            // Crear una nueva fila para el producto en el carrito
            var fila = $("<tr></tr>");
            fila.append("<td>" + producto + "</td>");
            fila.append("<td>" + codigo + "</td>");
            fila.append("<td>" + cantidad + "</td>");

            // Agregar un botón para eliminar el producto del carrito
            var btnEliminar = $("<button></button>")
                .text("Eliminar")
                .click((function(index) {
                    return function() {
                        eliminarProductoCarrito(index);
                    };
                })(i));
            fila.append($("<td></td>").append(btnEliminar));

            tablaCarrito.append(fila);
        }
    }

    // Función para eliminar un producto del carrito
    function eliminarProductoCarrito(index) {
        carrito.splice(index, 1); // Eliminar el producto del arreglo
        actualizarTablaCarrito(); // Actualizar la tabla de carrito de compras
    }

    // Llamar a la función de actualización al cargar la página
    actualizarTablaCarrito();
});
