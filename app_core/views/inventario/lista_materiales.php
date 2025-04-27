<?php
require_once(__CLS_PATH . "cls_html.php");
$html = new cls_Html();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Materiales</title>
    <?= $html->html_css_header(__CSS_PATH . "style.css", "all"); ?>
</head>
<body>

<h2>Gestion de Materiales</h2>

<div class="acciones-reporte">
    <a href="<?= __VWS_HOST_PATH ?>inventario/form_material.php" class="btn btn-new">+ Nuevo Material</a>
</div>

<table>
    <thead>
        <tr>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Cantidad Disponible</th>
            <th>Precio Unitario</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($lista)): ?>
            <?php foreach ($lista as $material): ?>
                <tr>
                    <td data-label="Imagen">
                        <img src="<?= __CTR_HOST_PATH ?>img_material.php?id=<?= $material['id']; ?>" alt="Imagen" style="width: 150px; height: auto; border-radius: 5px;">
                    </td>
                    <td data-label="Nombre"><?= htmlspecialchars($material['nombre']); ?></td>
                    <td data-label="Tipo"><?= htmlspecialchars($material['tipo']); ?></td>
                    <td data-label="Cantidad"><?= $material['cantidad_disponible']; ?></td>
                    <td data-label="Precio">₡ <?= number_format($material['precio_unitario'], 2); ?></td>
                    <td data-label="Acciones">
                        <a href="<?= __VWS_HOST_PATH ?>inventario/form_material.php?id=<?= $material['id']; ?>" class="btn btn-edit">Editar</a>
                        <a href="<?= __CTR_HOST_PATH ?>ctrl_materiales.php?accion=eliminar&id=<?= $material['id']; ?>" class="btn btn-delete" onclick="return confirm('¿Desea eliminar este material?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6">No hay materiales registrados.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
