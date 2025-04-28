<?php
require_once("../../global.php");
require_once(__CLS_PATH . "cls_mysql.php");

// Iniciamos sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$db = new cls_Mysql();

// Obtenemos la acción
$accion = $_REQUEST['accion'] ?? '';

switch ($accion) {
    case "insertar_usuario":
        // Insertar nuevo usuario
        $nombre_usuario = $_POST['nombre_usuario'] ?? '';
        $contrasena = $_POST['contrasena'] ?? '';
        $nombre_completo = $_POST['nombre_completo'] ?? '';
        $rol = $_POST['rol'] ?? '';

        if (empty($nombre_usuario) || empty($contrasena) || empty($nombre_completo) || empty($rol)) {
            echo "Todos los campos son obligatorios.";
            exit;
        }

        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nombre_usuario, contrasena, nombre_completo, rol) VALUES (?, ?, ?, ?)";
        $params = [$nombre_usuario, $contrasena_hash, $nombre_completo, $rol];
        $types = "ssss";

        if ($db->sql_execute_prepared_dml($sql, $types, $params)) {
            header("Location: " . __VWS_HOST_PATH . "usuarios/lista_usuarios.php?success=Usuario registrado correctamente");
            exit;
        } else {
            echo "Error al registrar usuario.";
        }
        break;

    case "eliminar_usuario":
        // Eliminar usuario si es admin y no tiene ventas asociadas
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
            header("Location: " . __VWS_HOST_PATH . "dashboard.php");
            exit;
        }
        
        $id = intval($_GET['id'] ?? 0);
        
        if ($id > 0) {
            // Comprobamos si el usuario tiene ventas
            $sql = "SELECT COUNT(*) AS total FROM ventas WHERE id_usuario = ?";
            $params = [$id];
            $types = "i";
        
            $result = $db->sql_execute_prepared($sql, $types, $params);
            $row = $db->sql_get_fetchassoc($result);
        
            if ($row['total'] > 0) {
                header("Location: " . __VWS_HOST_PATH . "usuarios/lista_usuarios.php?error=No se puede eliminar usuario con ventas asociadas");
                exit;
            }
        
            // Si no tiene ventas, eliminamos
            $sql = "DELETE FROM usuarios WHERE id = ?";
            $params = [$id];
            $types = "i";
        
            if ($db->sql_execute_prepared_dml($sql, $types, $params)) {
                header("Location: " . __VWS_HOST_PATH . "usuarios/lista_usuarios.php?success=Usuario eliminado correctamente");
                exit;
            } else {
                header("Location: " . __VWS_HOST_PATH . "usuarios/lista_usuarios.php?error=Error al eliminar usuario");
                exit;
            }
        } else {
            header("Location: " . __VWS_HOST_PATH . "usuarios/lista_usuarios.php?error=ID inválido");
            exit;
        }
        break;

    default:
        // Acción no válida
        echo "Acción no válida.";
}
?>
