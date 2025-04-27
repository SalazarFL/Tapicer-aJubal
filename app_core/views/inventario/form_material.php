<?php
require_once("../../../global.php");
require_once(__CLS_PATH . "cls_html.php");
require_once(__CLS_PATH . "cls_material.php");

$html = new cls_Html();
$material = new cls_Material();

// Inicializar variables
$id = intval($_GET['id'] ?? 0);
$datos = [
    'nombre' => '',
    'tipo' => '',
    'cantidad_disponible' => '',
    'precio_unitario' => '',
];

// Si viene un ID, buscamos para cargar en el formulario
if ($id > 0) {
    $datosExistentes = $material->obtenerMaterialPorId($id);
    if ($datosExistentes) {
        $datos = $datosExistentes;
    } else {
        header("Location: " . __CTR_HOST_PATH . "ctrl_materiales.php?accion=listar");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $id > 0 ? 'Editar Material' : 'Nuevo Material' ?></title>
    <?= $html->html_css_header(__CSS_PATH . "style.css", "all"); ?>
</head>
<body>

<h2><?= $id > 0 ? 'Editar Material' : 'Registrar Nuevo Material' ?></h2>

<form method="POST" action="<?= __CTR_HOST_PATH ?>ctrl_materiales.php" enctype="multipart/form-data" class="form-material">
    <input type="hidden" name="accion" value="<?= $id > 0 ? 'actualizar' : 'insertar' ?>">
    <?php if ($id > 0): ?>
        <input type="hidden" name="id" value="<?= $id ?>">
    <?php endif; ?>

    <label>Nombre del Material:</label>
    <input type="text" name="nombre" value="<?= htmlspecialchars($datos['nombre']) ?>" required>

    <label>Tipo:</label>
    <input type="text" name="tipo" value="<?= htmlspecialchars($datos['tipo']) ?>" required>

    <label>Cantidad Disponible:</label>
    <input type="number" name="cantidad_disponible" value="<?= htmlspecialchars($datos['cantidad_disponible']) ?>" min="0" required>

    <label>Precio Unitario (₡):</label>
    <input type="number" name="precio_unitario" step="0.01" value="<?= htmlspecialchars($datos['precio_unitario']) ?>" required>

    <label>Imagen del Material:</label>
    <input type="file" name="imagen">

    <?php if ($id > 0): ?>
        <p><strong>Nota:</strong> Si no desea cambiar la imagen, deje este campo vacío.</p>
    <?php endif; ?>

    <div class="acciones-formulario">
        <button type="submit" class="btn btn-new"><?= $id > 0 ? 'Actualizar' : 'Guardar' ?></button>
        <a href="<?= __CTR_HOST_PATH ?>ctrl_materiales.php?accion=listar" class="btn btn-delete">Cancelar</a>
    </div>
</form>

</body>
</html>
