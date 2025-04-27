<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/tapiceria-jubal/global.php");
require_once(__CLS_PATH . "cls_html.php");
require_once(__CLS_PATH . "cls_cliente.php");

$html = new cls_Html();
$cliente = new cls_Cliente();

// Capturar ID del cliente
$id_cliente = intval($_GET['id'] ?? 0);

// Si no viene ID, redireccionar
if ($id_cliente <= 0) {
    header("Location: " . __CTR_HOST_PATH . "ctrl_clientes.php?accion=listar");
    exit;
}

// Obtener los datos del cliente
$datos_cliente = $cliente->obtenerClientePorId($id_cliente);

// Si el cliente no existe, redirigir
if (!$datos_cliente) {
    header("Location: " . __CTR_HOST_PATH . "ctrl_clientes.php?accion=listar");
    exit;
}

// Ahora obtener sus ventas
require_once(__CLS_PATH . "cls_venta.php");
$venta = new cls_Venta();
$ventas_cliente = $venta->obtenerVentasPorCliente($id_cliente);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estado de Cuenta - <?= htmlspecialchars($datos_cliente['nombre_completo']) ?></title>
    <?= $html->html_css_header(__CSS_PATH . "style.css", "all"); ?>
</head>
<body>

<h2>Estado de Cuenta</h2>

<p><strong>Cliente:</strong> <?= htmlspecialchars($datos_cliente['nombre_completo']) ?></p>
<p><strong>Teléfono:</strong> <?= htmlspecialchars($datos_cliente['telefono']) ?></p>
<p><strong>Correo:</strong> <?= htmlspecialchars($datos_cliente['correo']) ?></p>

<div class="acciones-reporte">
    <a href="<?= __CTR_HOST_PATH ?>ctrl_clientes.php?accion=listar" class="btn btn-delete">↩️ Volver a Clientes</a>
</div>

<table>
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($ventas_cliente)): ?>
            <?php foreach ($ventas_cliente as $venta): ?>
                <tr>
                    <td data-label="Fecha"><?= htmlspecialchars($venta['fecha']) ?></td>
                    <td data-label="Estado"><?= htmlspecialchars($venta['estado']) ?></td>
                    <td data-label="Total">₡ <?= number_format($venta['total'], 2, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="3">Este cliente no tiene ventas registradas.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
