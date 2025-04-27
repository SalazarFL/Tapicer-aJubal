<?php
require_once("../../global.php");
require_once(__CLS_PATH . "cls_material.php");

$material = new cls_Material();

// Detectar acción
$accion = $_GET['accion'] ?? '';

switch ($accion) {
    
    case 'eliminar':
        $id = intval($_GET['id'] ?? 0);
        $respuesta = ["success" => false];

        if ($id > 0) {
            if ($material->eliminarMaterial($id)) {
                $respuesta["success"] = true;
            }
        }

        header('Content-Type: application/json');
        echo json_encode($respuesta);
        break;

    case 'listar':
    default:
        // Si quieres implementar búsqueda después puedes agregar filtros aquí
        $lista = $material->obtenerMateriales();

        if (!empty($lista)) {
            foreach ($lista as $material) {
                echo "<tr>";
                echo "<td data-label='Imagen'>
                        <img src='" . __CTR_HOST_PATH . "img_material.php?id=" . $material['id'] . "' alt='Imagen' style='width: 60px; height: auto; border-radius: 5px;'>
                      </td>";
                echo "<td data-label='Nombre'>" . htmlspecialchars($material['nombre']) . "</td>";
                echo "<td data-label='Tipo'>" . htmlspecialchars($material['tipo']) . "</td>";
                echo "<td data-label='Cantidad'>" . $material['cantidad_disponible'] . "</td>";
                echo "<td data-label='Precio'>₡ " . number_format($material['precio_unitario'], 2) . "</td>";
                echo "<td data-label='Acciones'>
                        <a href='" . __VWS_HOST_PATH . "inventario/form_material.php?id=" . $material['id'] . "' class='btn btn-edit'>Editar</a>
                        <button type='button' class='btn btn-delete btn-eliminar-material' data-id='" . $material['id'] . "'>Eliminar</button>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No hay materiales registrados.</td></tr>";
        }
        break;
}
