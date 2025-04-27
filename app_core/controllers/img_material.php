<?php
require_once("../global.php");
require_once(__CLS_PATH . "cls_material.php");

$material = new cls_Material();
$id = intval($_GET['id'] ?? 0);

if ($id > 0) {
    $imgData = $material->obtenerImagenPorId($id);
    if ($imgData) {
        header("Content-Type: image/jpeg"); // Puedes ajustarlo si guardas diferentes tipos
        echo $imgData;
        exit;
    }
}

// Si no existe imagen
header("Content-Type: image/png");
readfile("../resources/no-image.png"); // una imagen de "no disponible" opcional
exit;
