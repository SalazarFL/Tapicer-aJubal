<?php
require_once("global.php");

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si no hay usuario logueado, redirigir a login
if (!isset($_SESSION['id_usuario'])) {
    header("Location: app_core/views/login.php");
    exit;
}

// Si hay sesión activa, redirigir a dashboard
header("Location: app_core/views/dashboard.php");
exit;


?>
