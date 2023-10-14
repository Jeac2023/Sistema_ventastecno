$(document).ready(function() {
    // Obtener la referencia al campo de búsqueda de productos
    var buscarProductoInput = $("#buscar-producto");

    // Configurar el autocompletado utilizando jQuery UI
    buscarProductoInput.autocomplete({
        source: "buscar_producto.php",
        minLength: 1,
        select: function(event, ui) {
            // Actualizar el valor del campo de código del producto
            $("#codigo-producto").val(ui.item.codigo);
        }
    });

    // Escuchar el evento de cambio en el campo de búsqueda de productos
    buscarProductoInput.on("change", function() {
        var valorBusqueda = buscarProductoInput.val().trim();

        // Realizar una solicitud AJAX para obtener el código del producto
        $.ajax({
            url: "obtener_codigo_producto.php",
            method: "POST",
            data: { producto: valorBusqueda },
            dataType: "json",
            success: function(response) {
                if (response.codigo) {
                    // Actualizar el valor del campo de código del producto
                    $("#codigo-producto").val(response.codigo);
                } else {
                    // Limpiar el campo de código del producto si no se encuentra
                    $("#codigo-producto").val("");
                }
                if (response.imagen) {
                    $("#imagen-producto").attr("src", "data:image/jpeg;base64," + response.imagen);
                } else {
                    $("#imagen-producto").attr("src", "");
                }
            },
            error: function() {
                console.log("Ocurrió un error al obtener el código del producto.");
            }
        });
    });

    // Variables para almacenar los productos en el carrito y detalle de venta
    var productosCarrito = [];
    var productosVenta = [];

    // Función para actualizar la tabla de carrito de compras
    function actualizarTablaCarrito() {
        var tablaCarrito = $("#tabla-carrito tbody");
        tablaCarrito.empty();

        // Recorrer los productos en el carrito y agregar las filas a la tabla
        for (var i = 0; i < productosCarrito.length; i++) {
            var producto = productosCarrito[i];

            var fila = $("<tr>");
            fila.append($("<td>").text(producto.nombre));
            fila.append($("<td>").text(producto.codigo));
            fila.append($("<td>").text(producto.cantidad));
            fila.append($("<td>").html("<button class='eliminar-carrito' data-indice='" + i + "'>Eliminar</button>"));

            tablaCarrito.append(fila);
        }
    }

    // Función para actualizar la tabla de detalle de venta
    function actualizarTablaVenta() {
        var tablaVenta = $("#tabla-venta tbody");
        tablaVenta.empty();

        // Recorrer los productos en el detalle de venta y agregar las filas a la tabla
        for (var i = 0; i < productosVenta.length; i++) {
            var producto = productosVenta[i];

            var fila = $("<tr>");
            fila.append($("<td>").text(producto.nombre));
            fila.append($("<td>").text(producto.codigo));
            fila.append($("<td>").text(producto.cantidad));
            fila.append($("<td>").html("<button class='eliminar-venta' data-indice='" + i + "'>Eliminar</button>"));

            tablaVenta.append(fila);
        }
    }

    // Función para limpiar los campos de búsqueda y código de producto
    function limpiarCampos() {
        buscarProductoInput.val("");
        $("#codigo-producto").val("");
        $("#imagen-producto").attr("src", "");
    }

    // Manejar el evento de click en el botón "Agregar al Carrito"
    $("#formulario-venta").on("submit", function(event) {
        event.preventDefault();

        var producto = {
            nombre: buscarProductoInput.val().trim(),
            codigo: $("#codigo-producto").val().trim(),
            cantidad: $("#cantidad").val()
        };

        // Validar que se haya seleccionado un producto y especificado la cantidad
        if (producto.nombre !== "" && producto.cantidad !== "") {
            // Agregar el producto al carrito
            productosCarrito.push(producto);

            // Actualizar la tabla de carrito de compras
            actualizarTablaCarrito();

            // Limpiar los campos de búsqueda y código de producto
            limpiarCampos();
        }
    });

    // Manejar el evento de click en el botón "Eliminar" de un producto en el carrito
    $("#tabla-carrito").on("click", ".eliminar-carrito", function() {
        var indice = $(this).data("indice");

        // Eliminar el producto del carrito según el índice
        productosCarrito.splice(indice, 1);

        // Actualizar la tabla de carrito de compras
        actualizarTablaCarrito();
    });

    // Manejar el evento de click en el botón "Eliminar" de un producto en el detalle de venta
    $("#tabla-venta").on("click", ".eliminar-venta", function() {
        var indice = $(this).data("indice");

        // Eliminar el producto del detalle de venta según el índice
        productosVenta.splice(indice, 1);

        // Actualizar la tabla de detalle de venta
        actualizarTablaVenta();
    });

    // Manejar el evento de submit del formulario de registro de venta
    $("#formulario-registro-venta").on("submit", function(event) {
        event.preventDefault();

        var cliente = $("#cliente-venta").val().trim();

        // Validar que se haya especificado un cliente y que haya productos en el detalle de venta
        if (cliente !== "" && productosVenta.length > 0) {
            // Agregar el cliente al formulario de registro de venta
            $(this).find("#cliente").val(cliente);

            // Enviar el formulario de registro de venta
            this.submit();
        } else {
            alert("Debe especificar un cliente y agregar productos al detalle de venta");
        }
    });
});
