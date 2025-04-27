<?php
require_once("../../../global.php");
require_once(__CLS_PATH . "cls_html.php");
$html = new cls_Html();

// Datos previos (si viene editando)
$id = $_GET['id'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= ($id) ? "Editar Material" : "Nuevo Material"; ?></title>
    <?= $html->html_css_header(__CSS_PATH . "style.css", "all"); ?>
</head>
<body>

<h2><?= ($id) ? "Editar Material" : "Nuevo Material"; ?></h2>

<form action="<?= __CTR_HOST_PATH ?>ctrl_materiales.php" method="POST" enctype="multipart/form-data" class="form-material">
    <?php if ($id): ?>
        <input type="hidden" name="id" value="<?= htmlspecialchars($id); ?>">
        <input type="hidden" name="accion" value="actualizar">
    <?php else: ?>
        <input type="hidden" name="accion" value="insertar">
    <?php endif; ?>

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required>

    <label for="tipo">Tipo:</label>
    <input type="text" id="tipo" name="tipo">

    <label for="cantidad_disponible">Cantidad Disponible:</label>
    <input type="number" id="cantidad_disponible" name="cantidad_disponible" min="0">

    <label for="precio_unitario">Precio Unitario:</label>
    <input type="number" id="precio_unitario" name="precio_unitario" step="0.01" min="0">

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" name="imagen" accept="image/*">

    <div class="acciones-reporte">
        <button type="submit" class="btn btn-new"><?= ($id) ? "Actualizar" : "Guardar"; ?></button>
        <a href="<?= __CTR_HOST_PATH ?>ctrl_materiales.php?accion=listar" class="btn btn-delete">Cancelar</a>
    </div>
</form>

</body>
</html>
