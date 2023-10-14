var formulario = document.getElementById('formulario');
var nombreInput = document.getElementById('nombre');
var edadInput = document.getElementById('edad');
var nombreGuardado = document.getElementById('nombre-guardado');
var edadGuardada = document.getElementById('edad-guardada');

formulario.addEventListener('submit', function(event) {
    event.preventDefault();

    var nombre = nombreInput.value;
    var edad = edadInput.value;

    localStorage.setItem('nombre', nombre);
    localStorage.setItem('edad', edad);

    nombreGuardado.textContent = nombre;
    edadGuardada.textContent = edad;

    nombreInput.value = '';
    edadInput.value = '';
});

if (localStorage.getItem('nombre') && localStorage.getItem('edad')) {
    nombreGuardado.textContent = localStorage.getItem('nombre');
    edadGuardada.textContent = localStorage.getItem('edad');
}
