<?php
require_once("../../global.php");
require_once(__CLS_PATH . "cls_mysql.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$usuario = $_POST['usuario'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';

if (empty($usuario) || empty($contrasena)) {
    header("Location: " . __VWS_HOST_PATH . "login.php?error=Datos incompletos");
    exit;
}

$db = new cls_Mysql();

// Buscar usuario
$sql = "SELECT id, nombre_usuario, contrasena, nombre_completo, rol FROM usuarios WHERE nombre_usuario = ?";
$params = [$usuario];
$types = "s";

$result = $db->sql_execute_prepared($sql, $types, $params);

if ($result && $row = $db->sql_get_fetchassoc($result)) {
    if (password_verify($contrasena, $row['contrasena'])) {

        // Contraseña correcta
        $_SESSION['id_usuario'] = $row['id'];
        $_SESSION['nombre_usuario'] = $row['nombre_usuario'];
        $_SESSION['nombre_completo'] = $row['nombre_completo'];
        $_SESSION['rol'] = $row['rol'];

        header("Location: " . __VWS_HOST_PATH . "dashboard.php");
        exit;
    } else {
        // Contraseña incorrecta
        header("Location: " . __VWS_HOST_PATH . "login.php?error=Contraseña incorrecta");
        exit;
    }
} else {
    // Usuario no encontrado
    header("Location: " . __VWS_HOST_PATH . "login.php?error=Usuario no encontrado");
    exit;
}
?>