document.addEventListener('DOMContentLoaded', () => {
    const cerrarSesionBtn = document.querySelector('.cerrar-sesion');
    cerrarSesionBtn.addEventListener('click', () => {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción cerrará la sesión actual',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, cerrar sesión',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '';
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'cerrar_sesion';
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
});