<?php
require_once("../../global.php");
require_once(__CLS_PATH . "cls_material.php");

$material = new cls_Material();

// Obtenemos el ID del material
$id = intval($_GET['id'] ?? 0);

if ($id > 0) {
    $datos = $material->obtenerMaterialPorId($id);

    if ($datos && isset($datos['imagen']) && !empty($datos['imagen'])) {        
        // Detectamos el tipo MIME de la imagen
        if (function_exists('finfo_open')) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->buffer($datos['imagen']);
        } else {
            // Si no existe finfo, asumimos JPEG
            $mimeType = 'image/jpeg';
        }

        header('Content-Type: ' . $mimeType);
        echo $datos['imagen'];
        exit;
    }
}

// Si no hay imagen, mostramos una imagen por defecto
header('Content-Type: image/png');
readfile(__ROOT__ . "/$myproject/app_design/img/no-image.png");
exit;
?>
