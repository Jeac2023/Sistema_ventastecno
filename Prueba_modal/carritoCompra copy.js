document.addEventListener('DOMContentLoaded', function () {
const carrito = document.getElementById('car');
const btncarrito = document.querySelectorAll(".vender");
const listaProductos = document.getElementById("lista-productos");
const productosSeleccionados = [];
const mostrarCarrito = document.querySelector(".Carro");


function animarProductoHaciaCarrito(productImage, a, b) {
  
  // Clona la imagen del producto
  const clonedImage = productImage.cloneNode(true);
  clonedImage.classList.add("cloned-product-image"); // Agrega una clase para darle estilo
  clonedImage.style.position = 'absolute'; // Fija la posición para animar en relación al viewport

  // Agrega la imagen clonada al cuerpo del documento
  document.body.appendChild(clonedImage);

  // Calcula la diferencia en coordenadas
  const deltaX = a + (mostrarCarrito.getBoundingClientRect().left - a);
  const deltaY = (mostrarCarrito.getBoundingClientRect().top - b);
  console.log('coordenadas destino');
  console.log(deltaX,deltaY);

  // Aplica la transformación CSS para mover la imagen clonada
  clonedImage.style.transition = 'transform 1s ease';
  clonedImage.style.transform = `translate(${deltaX}px, ${deltaY}px) scale(0.5)`; // Escala la imagen

  // Cuando termine la animación, elimina la imagen clonada
  clonedImage.addEventListener('transitionend', function () {
    clonedImage.remove();
  });

  // Espera un momento antes de eliminar la imagen para permitir que la animación termine
  setTimeout(function () {
    clonedImage.remove();
  }, 1000);
}



// Función para guardar los productos en el localStorage
function guardarProductosEnLocalStorage() {
  localStorage.setItem('productosSeleccionados', JSON.stringify(productosSeleccionados));
  //localStorage.setItem('contadorProductos', contador.toString());
}

// Función para cargar los productos desde el localStorage
function cargarProductosDesdeLocalStorage() {
  const productosGuardados = localStorage.getItem('productosSeleccionados');
  if (productosGuardados) {
    productosSeleccionados.push(...JSON.parse(productosGuardados));
    actualizarListaProductos(); // Actualizar la lista al cargar los productos desde el localStorage
  }
}

// Función para guardar el contador en el localStorage
function guardarContadorEnLocalStorage(cont) {
  localStorage.setItem('contadorProductos', cont);
}

// Función para cargar el contador desde el localStorage
function cargarContadorDesdeLocalStorage() {
    const contadorGuardado = localStorage.getItem('contadorProductos');
    if (contadorGuardado !== null) {
      let contador = parseInt(contadorGuardado);
      const contadorSpan = document.getElementById("Contador");
      contadorSpan.textContent = contador;
    }
    else{
      let contador = 0;
      const contadorSpan = document.getElementById("Contador");
      contadorSpan.textContent = contador;
    }
  }
  
btncarrito.forEach(function (btn) {
  btn.addEventListener('click', function () {
    var producto = btn.getAttribute('data-producto');
    var precio = btn.getAttribute('data-precio');
    var stock = btn.getAttribute('data-stock');
    var imagenBase64 = btn.getAttribute('data-imagen');

    // Verificar si el producto ya existe en productosSeleccionados
    const productoExistente = productosSeleccionados.find(item => item.producto === producto);

    if (!productoExistente) {
      // Si no existe, agrégalo a productosSeleccionados
      productosSeleccionados.push({
        producto: producto,
        precio: precio,
        stock: stock,
        imagenBase64: imagenBase64
      });

      // Actualizar la lista de productos en la ventana modal
      actualizarListaProductos();
      // Guardar los productos en el localStorage
      guardarProductosEnLocalStorage();
      // Obtén la imagen del producto que se hizo clic
      const productImage = btn.parentElement.querySelector('img');
       // Obtén las coordenadas del botón btncarrito
      const btncarritoRect = btn.getBoundingClientRect();
      const btncarritoTop = btncarritoRect.top;
      const btncarritoLeft = btncarritoRect.left;
      console.log('coordenadas inicio')
      console.log('----------------------------')
      console.log(btncarritoLeft,btncarritoTop);

      
      // Llama a la función de animación pasando las coordenadas
      animarProductoHaciaCarrito(productImage, btncarritoLeft, btncarritoTop);
    } else {
      // Si el producto ya existe, muestra una alerta
      alert(`El producto "${producto}" ya está en el carrito.`);
    }
  
  });
});

// Función para actualizar la lista de productos en la ventana modal
function actualizarListaProductos() {
  let cuenta = 0;
  listaProductos.innerHTML = ""; // Borra la lista actual

  productosSeleccionados.forEach(function (producto) {
    const nombreProducto = producto.producto;
    const productElement = document.createElement("div");
    productElement.classList.add("product");

    productElement.innerHTML = `
      <span>${nombreProducto}  </span>
      <img src="data:image/jpeg;base64,${producto.imagenBase64}" alt="Imagen del producto">
      <span>Precio:  S/.${producto.precio}  </span>
      <button class="remove">X</button>
    `;
    listaProductos.appendChild(productElement);
    cuenta += Number(producto.precio);
  });
  const contadorSpan = document.getElementById("Contador");
  let contador = productosSeleccionados.length;
  contadorSpan.textContent = contador; // Usar la longitud de productosSeleccionados
  const total = document.getElementById("cuenta");
  total.textContent = "Total a pagar :   S/." + cuenta.toFixed(2);

  // Guardar el contador en el localStorage
  guardarContadorEnLocalStorage(contador);
}

listaProductos.addEventListener('click', function (event) {
  if (event.target.classList.contains('remove')) {
    // El botón "remove" fue clickeado
    // Encuentra el índice del producto en la lista
    const productoAEliminar = event.target.parentElement;
    const index = Array.from(productoAEliminar.parentElement.children).indexOf(productoAEliminar);

    // Elimina el producto de productosSeleccionados
    productosSeleccionados.splice(index, 1);

    // Actualiza la lista de productos en la ventana modal
    actualizarListaProductos();

    // Guardar los productos actualizados en el localStorage
    guardarProductosEnLocalStorage();
  }
});

function mostrar(){
  modalVender.style.display = 'block';
}

mostrarCarrito.addEventListener('click',mostrar);

// Llamar a las funciones para cargar los datos almacenados en el localStorage
cargarProductosDesdeLocalStorage();
cargarContadorDesdeLocalStorage();
});




