<?php
require_once("../../global.php"); 

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
