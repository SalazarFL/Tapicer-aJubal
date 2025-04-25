<?php
require_once("../../global.php"); // Ajusta si estás en otra ruta
require_once(__CLS_PATH . "cls_cliente.php");
require_once(__CLS_PATH . "cls_message.php");

$cliente = new cls_Cliente();

// Determina la acción
$accion = $_REQUEST["accion"] ?? "";

// Ejecutar la acción correspondiente
switch ($accion) {
    case "insertar":
        $nombre_completo = $_POST["nombre"] ?? "";
        $telefono        = $_POST["telefono"] ?? "";
        $direccion       = $_POST["direccion"] ?? "";
        $correo          = $_POST["correo"] ?? "";

        if ($cliente->insertarCliente($nombre_completo, $telefono, $direccion, $correo)) {
            cls_Message::show_message("", "success", "success_insert");
        } else {
            cls_Message::show_message("No se pudo guardar el cliente", "error", "");
        }
        break;

    case "actualizar":
        $id              = intval($_POST["id"] ?? 0);
        $nombre_completo = $_POST["nombre"] ?? "";
        $telefono        = $_POST["telefono"] ?? "";
        $direccion       = $_POST["direccion"] ?? "";
        $correo          = $_POST["correo"] ?? "";

        if ($cliente->actualizarCliente($id, $nombre_completo, $telefono, $direccion, $correo)) {
            cls_Message::show_message("", "success", "success_update");
        } else {
            cls_Message::show_message("No se pudo actualizar el cliente", "error", "");
        }
        break;

    case "eliminar":
        $id = intval($_GET["id"] ?? 0);

        if ($cliente->eliminarCliente($id)) {
            cls_Message::show_message("", "success", "success_delete");
        } else {
            cls_Message::show_message("No se pudo eliminar el cliente", "error", "");
        }
        break;

    case "detalle":
        $id = intval($_GET["id"] ?? 0);
        $datos = $cliente->obtenerClientePorId($id);
        echo json_encode($datos);
        break;

    case "listar":
    default:
        $lista = $cliente->obtenerClientes();
        include(__VWS_PATH . "clientes/lista_clientes.php"); // Vista para mostrar lista
        break;
}
?>
