const carrito = document.getElementById('car');
const carritoRect = carrito.getBoundingClientRect();
  const carritoX = carritoRect.left + window.scrollX;
  const carritoY = carritoRect.top + window.scrollY;
console.log(carritoX,carritoY);