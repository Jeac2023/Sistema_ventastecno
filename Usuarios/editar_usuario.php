<?php
$conexion = mysqli_connect('localhost:3307', 'root', '', 'sistema_tecnophone');

// Verificar si hay errores en la conexión
if (mysqli_connect_errno()) {
    echo "Error de conexión a la base de datos: " . mysqli_connect_error();
    exit;
}

// Obtener el nombre de usuario a editar desde la URL
$nombreUsuario = $_GET['nombre'];

// Obtener los datos del usuario de la base de datos
$query = "SELECT nombre_usuario, rol FROM usuarios WHERE nombre_usuario = '$nombreUsuario'";
$resultado = mysqli_query($conexion, $query);

// Verificar si se obtuvieron resultados
if (mysqli_num_rows($resultado) > 0) {
    $fila = mysqli_fetch_assoc($resultado);
    $nombre = $fila['nombre_usuario'];
    $rol = $fila['rol'];
} else {
    echo "Usuario no encontrado.";
    exit;
}

// Procesar el formulario de edición cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los nuevos datos del usuario desde el formulario
    $nuevoNombre = $_POST['nombre'];
    $nuevoRol = $_POST['rol'];

    // Actualizar los datos del usuario en la base de datos
    $query = "UPDATE usuarios SET nombre_usuario = '$nuevoNombre', rol = '$nuevoRol' WHERE nombre_usuario = '$nombreUsuario'";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        header("Location: index.php?registro_exitoso=true");
        exit();
    } else {
        echo "Error al actualizar el usuario: " . mysqli_error($conexion);
    }
    
}

// Cerrar la conexión
mysqli_close($conexion);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inventario</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../sweetalert2.min.css">
    <script src="../sweetalert2.min.js"></script>
    <script src="../librerias_js/jquery-3.7.0.min.js"></script>
    <style>
        /* Estilos para la ventana modal */
        dialog {
        width: 300px;
        padding: 20px;
        background-color: #f0f0f0;
        border: 1px solid #ccc;
        border-radius: 5px;
        }

        /* Estilos para el botón de cerrar */
        dialog::backdrop {
        background-color: rgba(0, 0, 0, 0.5);
        }

        button {
        margin-top: 10px;
        padding: 5px 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        }
    </style>
</head>
<body>
    <div>
        <header>
            <h1>Editar Usuario</h1>
        </header>
        <form class="register-form" action="" method="POST">
            <label class="edit-usuario" for="nombre">Nombre de usuario:</label>
            <input class="edit-usuario" type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
            <label class="edit-usuario" for="rol">Rol:</label>
            <select class="rol-select" name="rol" required>
                            <option value="Trabajador">Trabajador</option>
                            <option value="Dueño">Dueño</option>
                        </select value="<?php echo $rol; ?>" required>
                        <p></p> 
            <input type="submit" value="Guardar Cambios" class="Guardar_usuario">
        </form>
    </div>
    <button onclick="mostrarModal()">Abrir Ventana Modal</button>
    <dialog id="modal" close>
        <header>
            <h1>Editar Usuario</h1>
        </header>
        <form action="" method="POST">
            <label class="edit-usuario" for="nombre">Nombre de usuario:</label>
            <input class="edit-usuario" type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
            <label class="edit-usuario" for="rol">Rol:</label>
            <select class="rol-select" name="rol" required>
                            <option value="Trabajador">Trabajador</option>
                            <option value="Dueño">Dueño</option>
                        </select value="<?php echo $rol; ?>" required>
                        <p></p> 
            <input type="submit" value="Guardar Cambios" class="Guardar_usuario">
        </form>
        <button onclick="cerrarModal()">Cerrar</button>
    </dialog>
    <script>
    function mostrarModal() {
      const modal = document.getElementById('modal');
      modal.showModal();
    }

    function cerrarModal() {
      const modal = document.getElementById('modal');
      modal.close();
    }
    </script>
</body>