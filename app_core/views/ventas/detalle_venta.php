<?php
if (!defined('__CLS_PATH')) {
    require_once("../../../global.php");
}
require_once(__CLS_PATH . "cls_html.php");
require_once(__CLS_PATH . "cls_venta.php");

$html = new cls_Html();
$venta = new cls_Venta();

// Asegurar que viene el id
$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: " . __CTR_HOST_PATH . "ctrl_ventas.php?accion=listar");
    exit;
}

// Obtener datos de la venta
$datosVenta = $venta->obtenerVentaPorId($id);
$detalles = $venta->obtenerDetalleVenta($id);
$abonos = $venta->obtenerAbonosPorVenta($id);
$total_abonado = $venta->obtenerTotalAbonado($id);
$saldo_pendiente = ($datosVenta['total'] ?? 0) - $total_abonado;

// Validar si no existe
if (!$datosVenta) {
    header("Location: " . __CTR_HOST_PATH . "ctrl_ventas.php?accion=listar");
    exit;
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Venta</title>
    <?= $html->html_css_header(__CSS_PATH . "style.css", "all"); ?>
</head>
<body>

<h2>Detalle de Venta</h2>

<!-- Info principal de la venta -->
<table class="tabla-detalle">
    <tr><th>ID Venta:</th><td><?= $datosVenta['id']; ?></td></tr>
    <tr><th>Cliente:</th><td><?= htmlspecialchars($datosVenta['nombre_cliente']); ?></td></tr>
    <tr><th>Fecha:</th><td><?= $datosVenta['fecha']; ?></td></tr>
    <tr><th>Estado:</th><td><?= ucfirst($datosVenta['estado']); ?></td></tr>
    <tr><th>Total Venta:</th><td>₡ <?= number_format($datosVenta['total'], 2); ?></td></tr>
    <tr><th>Total Abonado:</th><td>₡ <?= number_format($total_abonado, 2); ?></td></tr>
    <tr><th>Saldo Pendiente:</th><td>₡ <?= number_format($saldo_pendiente, 2); ?></td></tr>
</table>

<!-- Trabajos realizados -->
<h3>Trabajos Realizados</h3>
<table>
    <thead>
        <tr>
            <th>Tipo de Trabajo</th>
            <th>Descripción</th>
            <th>Medidas</th>
            <th>Materiales Usados</th>
            <th>Costo Mano de Obra</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($detalles)): ?>
            <?php foreach ($detalles as $detalle): ?>
                <tr>
                    <td><?= htmlspecialchars($detalle['tipo_trabajo']); ?></td>
                    <td><?= htmlspecialchars($detalle['descripcion']); ?></td>
                    <td><?= htmlspecialchars($detalle['medidas']); ?></td>
                    <td><?= htmlspecialchars($detalle['materiales_usados']); ?></td>
                    <td>₡ <?= number_format($detalle['costo_mano_obra'], 2); ?></td>
                    <td>₡ <?= number_format($detalle['subtotal'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6">No hay detalles de trabajos registrados.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Abonos realizados -->
<h3>Abonos Realizados</h3>
<table>
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Monto</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($abonos)): ?>
            <?php foreach ($abonos as $abono): ?>
                <tr>
                    <td><?= $abono['fecha_abono']; ?></td>
                    <td>₡ <?= number_format($abono['monto_abono'], 2); ?></td>

                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="2">No hay abonos registrados.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Botón para nuevo abono -->
<div class="acciones-formulario">
    <a href="<?= __VWS_HOST_PATH ?>ventas/form_abono.php?id=<?= $datosVenta['id']; ?>" class="btn btn-new">Registrar Nuevo Abono</a>
    <a href="<?= __CTR_HOST_PATH ?>ctrl_ventas.php?accion=listar" class="btn btn-delete">Volver al Listado</a>
</div>

</body>
</html>
