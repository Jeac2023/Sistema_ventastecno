document.addEventListener('DOMContentLoaded', function () {
const btncarrito = document.querySelectorAll(".vender");
const listaProductos = document.getElementById("lista-productos");
const productosSeleccionados = [];
const mostrarCarrito = document.querySelector(".Carro");
const borrarTodo = document.querySelector(".eliminartodo");

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
  btn.addEventListener('click', function (event) {
    const x = event.clientX;
    const y = event.clientY;
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
      const productImage = btn.parentElement.querySelector('img');
      //animarProductoHaciaEsquina(productImage,inicialX,inicialY);
      animar(x,y,productImage);
      // Actualizar la lista de productos en la ventana modal
      actualizarListaProductos();
      // Guardar los productos en el localStorage
      guardarProductosEnLocalStorage();
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

borrarTodo.addEventListener('click', function () {
  Swal.fire({
    title: '¿Estás seguro?',
    text: 'Estás a punto de quitar todos los productos del Carrito. ¿Deseas continuar?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, vaciar carrito',
    cancelButtonText: 'Cancelar'
}).then((result) => {
    // Si el usuario confirma, enviar el formulario
    if (result.isConfirmed) {
      productosSeleccionados.length = 0;
      // Actualiza la lista de productos en la ventana modal
      actualizarListaProductos();
      // Elimina los productos del almacenamiento local
      localStorage.removeItem('productosSeleccionados');
    }
});
  // Borra todos los productos del carrito
  
});

function animar(x,y,image){
  const ejex = x;
  const ejey = y;
  const mostrarCarritoRect = mostrarCarrito.getBoundingClientRect();
  const coorx = mostrarCarritoRect.left;
  const coory = mostrarCarritoRect.top;
  const clonedImage = image.cloneNode(true);
  clonedImage.style.height = '50px';
  clonedImage.style.position = 'fixed';
  clonedImage.style.zIndex = '1111112';
  clonedImage.style.left = ejex + 'px';
  clonedImage.style.top = ejey + 'px';
  clonedImage.style.transition = 'opacity 1s';
  clonedImage.style.opacity = 1;

  document.body.appendChild(clonedImage);

  setTimeout(function () {
    // Calcula la distancia en píxeles entre las coordenadas actuales y las de mostrarCarrito
    const deltaX = coorx - ejex;
    const deltaY = coory - ejey;
    // Mueve gradualmente la imagen clonada hacia mostrarCarrito en un lapso de tiempo
    let startTime;
    function moveImage(timestamp) {
      if (!startTime) startTime = timestamp;
      const progress = (timestamp - startTime) / 600; // Duración de la animación en segundos
      if (progress < 1) {
        const newX = x + deltaX * progress;
        const newY = y + deltaY * progress;
        clonedImage.style.left = newX + 'px';
        clonedImage.style.top = newY + 'px';
        requestAnimationFrame(moveImage);
      } else {
        // Animación completada
        clonedImage.style.left = coorx + 'px';
        clonedImage.style.top = coory + 'px';
        setTimeout(function () {
          clonedImage.style.opacity = 0;
          setTimeout(function () {
            clonedImage.remove();
          }, 50); // Espera 1 segundo para eliminarla
        }, 50); // Espera 1 segundo para ocultarla
      }
    }
    
    requestAnimationFrame(moveImage);
  }, 0); // Sin demora
    
} 

// Llamar a las funciones para cargar los datos almacenados en el localStorage
cargarProductosDesdeLocalStorage();
cargarContadorDesdeLocalStorage();
});




