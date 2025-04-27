<?php
require_once(__CLS_PATH . "cls_html.php");
$html = new cls_Html();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Ventas</title>
    <?= $html->html_css_header(__CSS_PATH . "style.css", "all"); ?>
</head>
<body>

<h2>Listado de Ventas</h2>

<div class="acciones-reporte">
    <a href="<?= __VWS_HOST_PATH ?>ventas/form_venta.php" class="btn btn-new">+ Nueva Venta</a>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Usuario</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Total</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($lista)): ?>
            <?php foreach ($lista as $venta): ?>
                <tr>
                    <td data-label="ID"><?= $venta['id']; ?></td>
                    <td data-label="Cliente"><?= htmlspecialchars($venta['nombre_cliente']); ?></td>
                    <td data-label="Usuario"><?= htmlspecialchars($venta['nombre_usuario']); ?></td>
                    <td data-label="Fecha"><?= $venta['fecha']; ?></td>
                    <td data-label="Estado"><?= ucfirst($venta['estado']); ?></td>
                    <td data-label="Total">₡ <?= number_format($venta['total'], 2); ?></td>
                    <td data-label="Acciones">
                        <a href="<?= __VWS_HOST_PATH ?>ventas/form_venta.php?id=<?= $venta['id']; ?>" class="btn btn-edit">Editar</a>
                        <a href="<?= __CTR_HOST_PATH ?>ctrl_ventas.php?accion=eliminar&id=<?= $venta['id']; ?>" class="btn btn-delete" onclick="return confirm('¿Desea eliminar esta venta?');">Eliminar</a>
                        <a href="<?= __VWS_HOST_PATH ?>ventas/detalle_venta.php?id=<?= $venta['id']; ?>" class="btn btn-pdf">Detalle</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7">No hay ventas registradas.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
