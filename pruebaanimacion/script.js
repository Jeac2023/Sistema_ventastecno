const btnAgregar = document.querySelector('.vender');
const carrito = document.getElementById('carrito');

btnAgregar.addEventListener('click', () => {
  const producto = btnAgregar.getAttribute('data-producto');
  const imagen = btnAgregar.getAttribute('data-imagen');

  // Crea una imagen pequeña del producto y colócala en la posición del botón
  const productImage = document.createElement('div');
  productImage.classList.add('product-image');
  productImage.style.backgroundImage = `url(${imagen})`;

  // Obtiene las coordenadas del botón de carrito
  const carritoRect = carrito.getBoundingClientRect();
  const carritoX = carritoRect.left + window.scrollX;
  const carritoY = carritoRect.top + window.scrollY;

  // Coloca la imagen del producto en la posición del botón
  productImage.style.transform = `translate(${carritoX-40}px, ${carritoY}px)`;

  // Agrega la imagen al cuerpo del documento
  document.body.appendChild(productImage);

  // Realiza la animación moviendo la imagen al carrito
  setTimeout(() => {
    productImage.style.transform = 'translate(0, 0)';
  }, 0);

  // Elimina la imagen después de la animación
  setTimeout(() => {
    productImage.remove();
  }, 500);
});
