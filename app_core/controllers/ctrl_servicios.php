<?php
require_once("../../global.php");
require_once(__CLS_PATH . "cls_servicio.php");
require_once(__CLS_PATH . "cls_message.php");

$servicio = new cls_Servicio();

// Obtenemos la acción solicitada o 'listar' por defecto
$accion = $_REQUEST['accion'] ?? 'listar';

switch ($accion) {
    case "insertar":
        // Insertar nuevo servicio
        $nombre = $_POST['nombre'] ?? "";
        $descripcion = $_POST['descripcion'] ?? "";
        $precio_base = floatval($_POST['precio_base'] ?? 0);
        $tiempo_estimado = intval($_POST['tiempo_estimado_dias'] ?? 0);
    
        if ($servicio->insertarServicio($nombre, $descripcion, $precio_base, $tiempo_estimado)) {
            header("Location: ctrl_servicios.php?accion=listar");
            exit;
        } else {
            cls_Message::show_message("No se pudo insertar el servicio.", "error", "");
        }
        break;
    
    case "actualizar":
        // Actualizar servicio existente
        $id = intval($_POST['id'] ?? 0);
        $nombre = $_POST['nombre'] ?? "";
        $descripcion = $_POST['descripcion'] ?? "";
        $precio_base = floatval($_POST['precio_base'] ?? 0);
        $tiempo_estimado = intval($_POST['tiempo_estimado_dias'] ?? 0);

        if ($servicio->actualizarServicio($id, $nombre, $descripcion, $precio_base, $tiempo_estimado)) {
            header("Location: ctrl_servicios.php?accion=listar");
        } else {
            cls_Message::show_message("No se pudo actualizar el servicio.", "error", "");
        }
        break;

    case "eliminar":
        // Eliminar servicio por ID
        $id = intval($_GET['id'] ?? 0);

        if ($servicio->eliminarServicio($id)) {
            header("Location: ctrl_servicios.php?accion=listar");
        } else {
            cls_Message::show_message("No se pudo eliminar el servicio.", "error", "");
        }
        break;

    case "formulario":
        // Mostrar formulario de agregar o editar
        $id = intval($_GET['id'] ?? 0);
        $datos = [];

        if ($id > 0) {
            $datos = $servicio->obtenerServicioPorId($id);
        }

        include(__VWS_PATH . "servicios/form_servicio.php");
        break;

    case "listar":
    default:
        // Mostrar listado de servicios
        $lista = $servicio->obtenerServicios();
        include(__VWS_PATH . "servicios/lista_servicios.php");
        break;
}
?>
