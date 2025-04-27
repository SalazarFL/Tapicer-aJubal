<?php
require_once(__CLS_PATH . "cls_html.php");
$html = new cls_Html();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Servicios</title>
    <?= $html->html_css_header(__CSS_PATH . "style.css", "all"); ?>
</head>
<body>
<?php include(__VWS_PATH . "navbar.php"); ?>
<h2>Listado de Servicios</h2>

<div class="acciones-reporte">
    <a href="<?= __VWS_HOST_PATH ?>servicios/form_servicio.php" class="btn btn-new">+ Nuevo Servicio</a>
</div>

<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio Base</th>
            <th>Tiempo Estimado (días)</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($lista)): ?>
            <?php foreach ($lista as $servicio): ?>
                <tr>
                    <td data-label="Nombre"><?= htmlspecialchars($servicio['nombre']) ?></td>
                    <td data-label="Descripción"><?= htmlspecialchars($servicio['descripcion']) ?></td>
                    <td data-label="Precio">₡ <?= number_format($servicio['precio_base'], 2) ?></td>
                    <td data-label="Tiempo"><?= $servicio['tiempo_estimado_dias'] ?> días</td>
                    <td data-label="Acciones">
                        <a href="<?= __VWS_HOST_PATH ?>servicios/form_servicio.php?id=<?= $servicio['id'] ?>" class="btn btn-edit">Editar</a>
                        <a href="<?= __CTR_HOST_PATH ?>ctrl_servicios.php?accion=eliminar&id=<?= $servicio['id'] ?>" class="btn btn-delete" onclick="return confirm('¿Desea eliminar este servicio?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">No hay servicios registrados.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
<?php include(__VWS_PATH . "footer.php"); ?>
</body>
</html>
