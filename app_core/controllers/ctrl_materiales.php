<?php
require_once("../../global.php");
require_once(__CLS_PATH . "cls_material.php");
require_once(__CLS_PATH . "cls_message.php");

$material = new cls_Material();

$accion = $_REQUEST['accion'] ?? 'listar'; // Si no manda acción, lista

switch ($accion) {
    case "insertar":
        $nombre = $_POST['nombre'] ?? "";
        $tipo = $_POST['tipo'] ?? "";
        $cantidad = intval($_POST['cantidad_disponible'] ?? 0);
        $precio = floatval($_POST['precio_unitario'] ?? 0);
    
        $imagen = null;
        if (isset($_FILES['imagen']) && $_FILES['imagen']['tmp_name']) {
            $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
        }
    
        if ($material->insertarMaterial($nombre, $tipo, $cantidad, $precio, $imagen)) {
            header("Location: " . __CTR_HOST_PATH . "ctrl_materiales.php?accion=listar");
            exit;
        } else {
            cls_Message::show_message("No se pudo guardar el material.", "error", "");
        }
        break;
    
    case "actualizar":
        $id = intval($_POST['id'] ?? 0);
        $nombre = $_POST['nombre'] ?? "";
        $tipo = $_POST['tipo'] ?? "";
        $cantidad = intval($_POST['cantidad_disponible'] ?? 0);
        $precio = floatval($_POST['precio_unitario'] ?? 0);
    
        $imagen = null;
        if (isset($_FILES['imagen']) && $_FILES['imagen']['tmp_name']) {
            $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
        }
    
        if ($material->actualizarMaterial($id, $nombre, $tipo, $cantidad, $precio, $imagen)) {
            header("Location: " . __CTR_HOST_PATH . "ctrl_materiales.php?accion=listar");
            exit;
        } else {
            cls_Message::show_message("No se pudo actualizar el material.", "error", "");
        }
        break;
    

    case "eliminar":
            $id = intval($_GET['id'] ?? 0);
        
            if ($material->eliminarMaterial($id)) {
                // Después de eliminar, simplemente cargar el listado otra vez
                $lista = $material->obtenerMateriales();
                include(__VWS_PATH . "inventario/lista_materiales.php");
            } else {
                cls_Message::show_message("No se pudo eliminar el material.", "error", "");
            }
            break;
        


    case "formulario":
        $id = intval($_GET['id'] ?? 0);
        $datos = [];

        if ($id > 0) {
            $datos = $material->obtenerMaterialPorId($id);
        }

        include(__VWS_PATH . "inventario/form_material.php");
        break;

    case "listar":
    default:
        $lista = $material->obtenerMateriales();
        include(__VWS_PATH . "inventario/lista_materiales.php");
        break;
}
?>
