<?php
require_once("../../global.php");
require_once(__CLS_PATH . "cls_material.php");
require_once(__CLS_PATH . "cls_message.php");

$material = new cls_Material();

// Obtener acción
$accion = $_REQUEST["accion"] ?? "";

switch ($accion) {
    case "insertar":
        $nombre               = $_POST["nombre"] ?? "";
        $tipo                 = $_POST["tipo"] ?? "";
        $cantidad_disponible  = $_POST["cantidad_disponible"] ?? 0;
        $precio_unitario      = $_POST["precio_unitario"] ?? 0.0;
        $imagen               = $_FILES["imagen"] ?? null;

        if ($material->insertarMaterial($nombre, $tipo, $cantidad_disponible, $precio_unitario, $imagen)) {
            cls_Message::show_message("", "success", "success_insert");
        } else {
            cls_Message::show_message("No se pudo guardar el material", "error", "");
        }
        break;

    case "actualizar":
        $id                   = intval($_POST["id"] ?? 0);
        $nombre               = $_POST["nombre"] ?? "";
        $tipo                 = $_POST["tipo"] ?? "";
        $cantidad_disponible  = $_POST["cantidad_disponible"] ?? 0;
        $precio_unitario      = $_POST["precio_unitario"] ?? 0.0;
        $imagen               = $_FILES["imagen"] ?? null;

        if ($material->actualizarMaterial($id, $nombre, $tipo, $cantidad_disponible, $precio_unitario, $imagen)) {
            cls_Message::show_message("", "success", "success_update");
        } else {
            cls_Message::show_message("No se pudo actualizar el material", "error", "");
        }
        break;

    case "eliminar":
        $id = intval($_GET["id"] ?? 0);

        if ($material->eliminarMaterial($id)) {
            cls_Message::show_message("", "success", "success_delete");
        } else {
            cls_Message::show_message("No se pudo eliminar el material", "error", "");
        }
        break;

    case "listar":
        $lista = $material->obtenerMateriales();
        include(__VWS_PATH . "inventario/lista_materiales.php");
        break;

    case "detalle":
        $id = intval($_GET["id"] ?? 0);
        $datos = $material->obtenerMaterialPorId($id);
        echo json_encode($datos);
        break;
}
