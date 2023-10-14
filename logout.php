<?php
session_start();

// Destruye la sesión actual
session_destroy();

// Redirige a la página de inicio de sesión (login.php)
header('Location: Login/index.html');
exit;
?>
