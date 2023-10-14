 // Verificar si hay un parámetro de URL "registro_exitoso" y mostrar el mensaje correspondiente
        const urlParams = new URLSearchParams(window.location.search);
        const registroExitoso = urlParams.get('registro_exitoso');
        if (registroExitoso === 'true') {
            Swal.fire({
                title: 'Registro exitoso',
                text: '',
                icon: 'success'
            }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirigir a la página de eliminación con el parámetro del nombre de usuario
                        window.location.href = `index.php`;
                    }
                });
            }
        const urlParams2 = new URLSearchParams(window.location.search);
        const actualizacionExitosa = urlParams2.get('actualizacion_exitosa');
        if (actualizacionExitosa === 'true') {
            Swal.fire({
                title: 'Actualización exitosa',
                text: '',
                icon: 'success'
            }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirigir a la página de eliminación con el parámetro del nombre de usuario
                        window.location.href = `index.php`;
                    }
                });
            }
        const urlParams3 = new URLSearchParams(window.location.search);
        const actualizacionmasivaExitosa = urlParams3.get('actualizacion_masiva_exitosa');
        if (actualizacionmasivaExitosa === 'true') {
            Swal.fire({
                title: 'Registro Masivo exitoso',
                text: '',
                icon: 'success'
            }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirigir a la página de eliminación con el parámetro del nombre de usuario
                        window.location.href = `index.php`;
                    }
                });
            }
        const urlParams4 = new URLSearchParams(window.location.search);
        const registroeliminado = urlParams4.get('registro_eliminado');
        if (registroeliminado === 'true') {
            Swal.fire({
                title: 'Producto eliminado exitosamente',
                text: '',
                icon: 'success'
            }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirigir a la página de eliminación con el parámetro del nombre de usuario
                        window.location.href = `index.php`;
                    }
                });
            }
