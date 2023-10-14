<?php
session_start();
// Si no se ha iniciado sesión, redirige a la página de inicio de sesión (login.php)
if (!isset($_SESSION['mensaje_bienvenida'])) {
    header('Location: ../Login/index.html');
    exit;
}
// Función para destruir la sesión y redirigir al inicio de sesión
function cerrarSesion() {
    session_destroy();
    header('Location: ../Login/index.html');
    exit;
}

if (isset($_POST['cerrar_sesion'])) {
    cerrarSesion();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>
    <link rel="stylesheet" href="../librerias_css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../librerias_css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../sweetalert2.min.css">
    <script src="../sweetalert2.min.js"></script>
</head>
<body>
    <header>
        <h1>Usuarios</h1>
    </header>
    <div class="sidebar">
        <div class="Usuario">
            <a  href="#"><?php echo $_SESSION['Usuario']; ?></a>
            <button type="submit" class="cerrar-sesion" name="cerrar_sesion">Cerrar Sesión</button>
        </div>
        <a href="../index.php"><i class="fa fa-home"></i> Inicio</a>
        <a href="../Inventario/inventario.php"><i class="fa fa-cube"></i> Inventario</a>
        <a class="active" href="#"><i class="fa fa-users"></i> Usuarios</a>
        <a href="#"><i class="fa fa-users"></i> Clientes</a>
        <a href="../Reportes/reportes.php"><i class="fa fa-chart-bar"></i> Reportes</a>
    </div>
    <section> <!-- Se agregó una etiqueta de apertura a la sección -->
        <?php
        require_once '../conexion_db.php';
        // Obtener los usuarios de la base de datos
        $query = "SELECT nombre_usuario, rol FROM usuarios";
        $resultado = mysqli_query($conexion, $query);

        // Verificar si se obtuvieron resultados
        if (mysqli_num_rows($resultado) > 0) {
            ?>
            <table class="Usuarios">
                <thead>
                    <tr>
                        <th>Nombre de usuario</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="form-usuarios">
                    <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>
                        <tr>
                            <td><?php echo $fila['nombre_usuario']; ?></td>
                            <td><?php echo $fila['rol']; ?></td>
                            <td>
                                <button class="editar-usuario" data-nombre="<?php echo $fila['nombre_usuario'];?>">Editar</button>
                                <button class="eliminar-usuario" data-nombre="<?php echo $fila['nombre_usuario']; ?>">Eliminar</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php
        } else {
            echo "No se encontraron usuarios.";
        }

        // Cerrar la conexión
        mysqli_close($conexion);
        ?>
        <dialog  id="modal" close>
            <button class ="Cerrar-modal" onclick="cerrarModal()">X</button>
            <h1 class ="t">Editar Usuario</h1>
            <form action="guardar.php" method="POST">
                <label class="edit-usuario" for="nombre">Nombre de usuario:</label>
                <input class="edit-usuario" type="text" id="nombre" name="nombre" readonly required>
                <label class="edit-usuario" for="rol">Rol:</label>
                <select class="rol-select" name="rol" required>
                                <option value="Trabajador">Trabajador</option>
                                <option value="Dueño">Dueño</option>
                            </select value="<?php echo $rol; ?>" required>
                            <p></p> 
                <input type="submit" value="Guardar Cambios" class="Cambios_usuario">
            </form>
        </dialog>
    </section> <!-- Se cerró la etiqueta de la sección -->
    
    <footer>
        <p>Derechos de Autor &copy; 2023 - Tecnophone</p>
    </footer>
    <script src="../cerrar_sesion.js"></script>
    <script src="script.js"></script>
    <script>
        // Agregar eventos a los botones de editar y eliminar
        const editarBotones = document.querySelectorAll('.editar-usuario');
        const eliminarBotones = document.querySelectorAll('.eliminar-usuario');

        editarBotones.forEach((boton) => {
        boton.addEventListener('click', (event) => {
            const nombreUsuario = event.target.dataset.nombre;

            // Aquí puedes mostrar SweetAlert para editar el usuario
            Swal.fire({
            title: 'Editar usuario',
            text: `¿Deseas editar el usuario ${nombreUsuario}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Editar',
            cancelButtonText: 'Cancelar',
            }).then((result) => {
            if (result.isConfirmed) {
                // Llamar a la función mostrarModal y pasar el nombre de usuario
                mostrarModal(nombreUsuario);
            }
            });
        });
        });


       
    </script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        eliminarBotones.forEach((boton) => {
            boton.addEventListener('click', (event) => {
                const nombreUsuario = event.target.dataset.nombre;
                
                Swal.fire({
                    title: 'Eliminar usuario',
                    text: `¿Deseas eliminar el usuario ${nombreUsuario}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Eliminar',
                    cancelButtonText: 'Cancelar',
                    html: `
                        <input type="password" id="contrasena_dueno" class="swal2-input" placeholder="Contraseña del dueño" required>
                    `,
                    preConfirm: () => {
                        const contrasenaDueno = document.getElementById('contrasena_dueno').value;
                        return axios.post('eliminar_usuario.php', {
                            nombre: nombreUsuario,
                            contrasena_dueno: contrasenaDueno
                        })
                        .then(response => {
                            return response.data;
                        })
                        .catch(error => {
                            Swal.showValidationMessage(`Error al eliminar el usuario: ${error}`);
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (result.value.eliminado === true) {
                            Swal.fire({
                                title: 'Usuario eliminado exitosamente',
                                text: '',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'inventario.php';
                            });
                        } else if (result.value.eliminado === false) {
                            const contrasenaDueno = result.value.contrasena_dueno;
                            document.getElementById('contrasena_dueno_msg').textContent = `Contraseña del dueño: ${contrasenaDueno}`;
                            Swal.fire({
                                title: 'Contraseña incorrecta',
                                text: '',
                                icon: 'error'
                            });
                        } else {
                            Swal.fire({
                                title: 'Error al eliminar el usuario',
                                text: '',
                                icon: 'error'
                            });
                        }
                    }
                });
            });
        });
    </script>

    <script>
    // Verificar si hay un parámetro de URL "registro_exitoso" y mostrar el mensaje correspondiente
        const urlParams = new URLSearchParams(window.location.search);
        const registroExitoso = urlParams.get('registro_exitoso');
        if (registroExitoso === 'true') {
            Swal.fire({
                title: 'Usuario modificado exitosamente',
                text: '',
                icon: 'success'
            }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirigir a la página de eliminación con el parámetro del nombre de usuario
                        window.location.href = `index.php`;
                    }
                });
            } 
            const eliminado = urlParams.get('eliminado');
        if (eliminado === 'true') {
            Swal.fire({
                title: 'Usuario eliminado exitosamente',
                text: '',
                icon: 'success'
            }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirigir a la página de eliminación con el parámetro del nombre de usuario
                        window.location.href = `index.php`;
                    }
                });
            }
            if (eliminado === 'false') {
            Swal.fire({
                title: 'Contraseña Incorrecta',
                text: '',
                icon: 'error'
            }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirigir a la página de eliminación con el parámetro del nombre de usuario
                        window.location.href = `index.php`;
                    }
                });
            }
            const formu = urlParams.get('formulario');
            if (formu === 'true') {
            Swal.fire({
            title: 'Ingresar Contraseña',
            html: `<input type="password" id="contra" class="swal2-input" placeholder="Contraseña">`,
            confirmButtonText: 'Eliminar',
            focusConfirm: false,
            preConfirm: () => {
                const password = Swal.getPopup().querySelector('#contra').value
                if (!password) {
                Swal.showValidationMessage(`Por favor Ingresar la Contraseña del Administrador`)
                }
                return {password: password }
            }
            }).then((result) => {
                window.location.href = `hola.php`;
            Swal.fire(`Contraseña: ${result.value.password}`.trim())
            })
        }

    </script>
</body>
</html>

