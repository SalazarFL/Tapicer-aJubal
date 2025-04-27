<?php
require_once("../../global.php");
require_once(__CLS_PATH . "cls_material.php");

$material = new cls_Material();

$id = intval($_GET['id'] ?? 0);

if ($id > 0) {
    $datos = $material->obtenerMaterialPorId($id);

    if ($datos && isset($datos['imagen']) && !empty($datos['imagen'])) {
        // Detectar el tipo MIME
        if (function_exists('finfo_open')) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->buffer($datos['imagen']);
        } else {
            // Fallback en caso que no exista finfo
            $mimeType = 'image/jpeg'; // Suponemos JPEG
        }

        header('Content-Type: ' . $mimeType);
        echo $datos['imagen'];
        exit;
    }
}

// Imagen por defecto
header('Content-Type: image/png');
readfile(__ROOT__ . "/$myproject/app_design/img/no-image.png");
exit;
?>
