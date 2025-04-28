<?php
require_once("../../global.php");
require_once(__CLS_PATH . "cls_material.php");
require_once(__CLS_PATH . "cls_message.php");

$material = new cls_Material();

// Obtenemos la acción o usamos 'listar' por defecto
$accion = $_REQUEST['accion'] ?? 'listar';

switch ($accion) {
    case "insertar":
        // Recogemos datos del formulario
        $nombre = $_POST['nombre'] ?? "";
        $tipo = $_POST['tipo'] ?? "";
        $cantidad = intval($_POST['cantidad_disponible'] ?? 0);
        $precio = floatval($_POST['precio_unitario'] ?? 0);

        // Procesamos imagen si se envió
        $imagen = null;
        if (isset($_FILES['imagen']) && $_FILES['imagen']['tmp_name']) {
            $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
        }

        // Insertamos material
        if ($material->insertarMaterial($nombre, $tipo, $cantidad, $precio, $imagen)) {
            header("Location: " . __CTR_HOST_PATH . "ctrl_materiales.php?accion=listar");
            exit;
        } else {
            cls_Message::show_message("No se pudo guardar el material.", "error", "");
        }
        break;

    case "actualizar":
        
        // Recogemos datos del formulario para actualizar
        $id = intval($_POST['id'] ?? 0);
        $nombre = $_POST['nombre'] ?? "";
        $tipo = $_POST['tipo'] ?? "";
        $cantidad = intval($_POST['cantidad_disponible'] ?? 0);
        $precio = floatval($_POST['precio_unitario'] ?? 0);

        $imagen = null;
        if (isset($_FILES['imagen']) && $_FILES['imagen']['tmp_name']) {
            $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
        }

        // Actualizamos material
        if ($material->actualizarMaterial($id, $nombre, $tipo, $cantidad, $precio, $imagen)) {
            header("Location: " . __CTR_HOST_PATH . "ctrl_materiales.php?accion=listar");
            exit;
        } else {
            cls_Message::show_message("No se pudo actualizar el material.", "error", "");
        }
        break;

    case "eliminar":
        // Eliminamos material por ID
        $id = intval($_GET['id'] ?? 0);

        if ($material->eliminarMaterial($id)) {
            $lista = $material->obtenerMateriales();
            include(__VWS_PATH . "inventario/lista_materiales.php");
        } else {
            cls_Message::show_message("No se pudo eliminar el material.", "error", "");
        }
        break;

    case "formulario":
        // Mostramos formulario para agregar o editar
        $id = intval($_GET['id'] ?? 0);
        $datos = [];

        if ($id > 0) {
            $datos = $material->obtenerMaterialPorId($id);
        }

        include(__VWS_PATH . "inventario/form_material.php");
        break;

    case "listar":
    default:
        // Mostramos lista de materiales
        $lista = $material->obtenerMateriales();
        include(__VWS_PATH . "inventario/lista_materiales.php");
        break;
}
?>
