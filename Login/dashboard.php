<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
  header("Location: index.html"); // Redirigir al formulario de inicio de sesión si no ha iniciado sesión
  exit();
}

// Aquí puedes colocar el contenido de tu página principal o de ventas
?>

<!DOCTYPE html>
<html>
<head>
  <title>Página principal</title>
</head>
<body>
  <h2>Bienvenido, <?php echo $_SESSION['username']; ?></h2>
  <!-- Coloca aquí el contenido de tu página principal o de ventas -->
</body>
</html>
