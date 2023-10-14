<?php
function encriptarPassword($password)
{
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    return $hashedPassword;
}

$conn = mysqli_connect('localhost:3307', 'root', '', 'sistema_tecnophone');

if (mysqli_connect_errno()) {
    echo "Error de conexión a la base de datos: " . mysqli_connect_error();
    exit;
}

$nombreUsuario = $_POST['nombre'];
$contrasenaDueno = $_POST['contrasena_dueno'];

$query = "SELECT contrasena, rol FROM usuarios WHERE rol = 'Dueño'";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $hashedPassword, $rol);
mysqli_stmt_fetch($stmt);
mysqli_stmt_free_result($stmt);

$response = [];

if (password_verify($contrasenaDueno, $hashedPassword)) {
    $query = "DELETE FROM usuarios WHERE nombre_usuario = '$nombreUsuario'";
    $resultado = mysqli_query($conn, $query);

    if ($resultado) {
        $response['eliminado'] = true;
    } else {
        $response['eliminado'] = false;
    }
} else {
    $response['eliminado'] = false;
}

$response['contrasena_dueno'] = $contrasenaDueno;

mysqli_close($conn);

echo json_encode($response);
exit;
?>
