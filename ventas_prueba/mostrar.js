window.addEventListener('DOMContentLoaded', () => {
  // Cargar la tabla de inventario al cargar la página
  cargarProductos();
});

function cargarProductos() {
  // Realizar una solicitud AJAX para obtener los datos del inventario desde el servidor
  const xhr = new XMLHttpRequest();
  xhr.open('GET', 'obtener_inventario.php', true);
  xhr.onload = function () {
      if (xhr.status === 200) {
          // Actualizar el contenido de la sección de la tabla de inventario
          const tablaInventario = document.getElementById('tabla-ventas');
          tablaInventario.innerHTML = xhr.responseText;

          // Agregar eventos a los botones de editar y borrar
          const editarButtons = document.getElementsByClassName('editar-btn');
          for (let i = 0; i < editarButtons.length; i++) {
              const producto = editarButtons[i];
              const codigoProducto = producto.getAttribute('data-codigo');
              const agregarButton = document.createElement('button');
              agregarButton.textContent = 'Agregar al Carrito';
              agregarButton.addEventListener('click', function() {
                agregarAlCarrito(codigoProducto);
              });
              producto.appendChild(agregarButton);
          }

          const borrarButtons = document.getElementsByClassName('borrar-btn');
          for (let i = 0; i < borrarButtons.length; i++) {
              const button = borrarButtons[i];
              button.addEventListener('click', confirmarBorrarProducto);
          }

          // Agregar botón "Agregar al Carrito" a cada fila de producto
          const productos = document.getElementsByClassName('producto');
          for (let i = 0; i < productos.length; i++) {
              const producto = productos[i];
              const codigoProducto = producto.getAttribute('data-codigo');
              const agregarButton = document.createElement('button');
              agregarButton.textContent = 'Agregar al Carrito';
              agregarButton.addEventListener('click', function() {
                agregarAlCarrito(codigoProducto);
              });
              producto.appendChild(agregarButton);
          }
      }
  };
  xhr.send();
}

function confirmarBorrarProducto(event) {
  // Detener la propagación del evento para evitar que se seleccione la fila
  event.stopPropagation();

  const idProducto = event.target.getAttribute('data-id');
  // Mostrar un mensaje de confirmación antes de borrar el producto
  if (confirm('¿Estás seguro que quieres borrar este producto?')) {
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
}

function cargarCarrito() {
  // Obtener los productos del carrito desde el almacenamiento local
  var cartItemsHtml = localStorage.getItem("cartItems");
  if (cartItemsHtml) {
    var cartItemsDiv = document.getElementById("cart-items");
    cartItemsDiv.innerHTML = cartItemsHtml;

    // Actualizar el total del carrito
    actualizarTotalCarrito();
  }
}

function agregarAlCarrito(codigo) {
  // Realizar una solicitud AJAX al servidor para obtener los detalles del producto
  console.log(codigo);
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "productos.php?codigo=" + codigo, true);
  xhr.onload = function () {
    if (xhr.status === 200) {
      var response = JSON.parse(xhr.responseText);
      var product = response.find(function (item) {
        return item.codigo === codigo;
      });

      if (product) {
        var producto = product.producto;
        var precio = parseFloat(product.precio);

        // Verificar si el producto ya está en el carrito
        var cartItemsDiv = document.getElementById("cart-items");
        var cartItems = cartItemsDiv.getElementsByClassName("cart-item");
        var existingCartItem = Array.from(cartItems).find(function (item) {
          return item.dataset.codigo === codigo;
        });

        if (existingCartItem) {
          // Si el producto ya está en el carrito, aumentar la cantidad
          var cantidadElement = existingCartItem.querySelector(".cart-item-quantity");
          var cantidad = parseInt(cantidadElement.textContent) + 1;
          cantidadElement.textContent = cantidad;

          var subtotalElement = existingCartItem.querySelector(".cart-item-subtotal");
          var subtotal = parseFloat(subtotalElement.textContent.replace("S/ ", "")) + precio;
          subtotalElement.textContent = "S/ " + subtotal.toFixed(2);
        } else {
          // Si el producto no está en el carrito, crear un nuevo elemento
          var cartItem = document.createElement("tr");
          cartItem.classList.add("cart-item");
          cartItem.dataset.codigo = codigo;

          var quantity = 1;
          var subtotal = precio;

          cartItem.innerHTML = `
            <td>${producto}</td>
            <td>S/ ${precio.toFixed(2)}</td>
            <td class="cart-item-quantity">${quantity}</td>
            <td class="cart-item-subtotal">S/ ${subtotal.toFixed(2)}</td>
            <td><button class="remove-button">Quitar</button></td>
          `;

          // Agregar evento para quitar el producto del carrito
          var removeButton = cartItem.querySelector(".remove-button");
          removeButton.addEventListener("click", function () {
            eliminarDelCarrito(codigo);
          });

          cartItemsDiv.querySelector("tbody").appendChild(cartItem);
        }

        // Actualizar el total del carrito
        actualizarTotalCarrito();
        // Guardar los productos del carrito en el almacenamiento local
        localStorage.setItem("cartItems", cartItemsDiv.innerHTML);
      }
    }
  };
  xhr.send();
}

function actualizarTotalCarrito() {
  var cartItems = document.getElementsByClassName("cart-item");
  var total = 0;

  Array.from(cartItems).forEach(function (cartItem) {
    var subtotalElement = cartItem.querySelector(".cart-item-subtotal");
    var subtotal = parseFloat(subtotalElement.textContent.replace("S/ ", ""));
    total += subtotal;
  });

  var totalElement = document.getElementById("cart-total");
  totalElement.textContent = "S/ " + total.toFixed(2);
}

function eliminarDelCarrito(codigo) {
  // Buscar el elemento del producto en el carrito
  var cartItem = document.querySelector(`.cart-item[data-codigo="${codigo}"]`);
  if (cartItem) {
    // Eliminar el elemento del carrito
    cartItem.remove();

    // Actualizar el total del carrito
    actualizarTotalCarrito();
    // Guardar los productos del carrito en el almacenamiento local
    var cartItemsDiv = document.getElementById("cart-items");
    localStorage.setItem("cartItems", cartItemsDiv.innerHTML);
  }
}

function vaciarCarrito() {
  var cartItemsDiv = document.getElementById("cart-items");
  cartItemsDiv.innerHTML = "";

  // Actualizar el total del carrito
  actualizarTotalCarrito();
  // Eliminar los productos del carrito del almacenamiento local
  localStorage.removeItem("cartItems");
  location.reload();
}

document.addEventListener("DOMContentLoaded", function () {
  // Obtener los productos del carrito del almacenamiento local
  var cartItemsDiv = document.getElementById("cart-items");
  var cartItems = localStorage.getItem("cartItems");
  if (cartItems) {
    cartItemsDiv.innerHTML = cartItems;
  }



  var removeButtons = document.getElementsByClassName("remove-button");
  Array.from(removeButtons).forEach(function (button) {
    button.addEventListener("click", function () {
      var codigo = this.parentNode.parentNode.dataset.codigo;
      eliminarDelCarrito(codigo);
    });
  });

  var vaciarCarritoButton = document.getElementById("vaciar-carrito");
  vaciarCarritoButton.addEventListener("click", function () {
    vaciarCarrito();
  });

  // Actualizar el total del carrito
  actualizarTotalCarrito();
});
