<?php
require_once("../../global.php"); // Siempre para que cargue rutas

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Limpiar y destruir la sesión
session_unset();
session_destroy();

// Redirigir al login
header("Location: " . __VWS_HOST_PATH . "login.php?mensaje=logout");
exit;
?>
