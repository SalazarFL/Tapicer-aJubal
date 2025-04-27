<?php
require_once("../../../global.php");
require_once(__CLS_PATH . "cls_html.php");
require_once(__CLS_PATH . "cls_cliente.php");
require_once(__CLS_PATH . "cls_venta.php"); // <-- Faltaba
require_once(__CLS_PATH . "cls_usuario.php"); // <-- (por si ocupamos usuario luego)

$html = new cls_Html();
$cliente = new cls_Cliente();
$venta = new cls_Venta();

// Obtener lista de clientes
$clientes = $cliente->obtenerClientes();

// Inicializar variables
$id = intval($_GET['id'] ?? 0);
$modo_editar = false;
$ventaData = [];
$detalles = [];

if ($id > 0) {
    // Si hay ID, estamos en modo de edición
    $modo_editar = true;
    $ventaData = $venta->obtenerVentaPorId($id);
    $detalles = $venta->obtenerDetalleVenta($id);

    // Si no existe esa venta, redirigimos
    if (!$ventaData) {
        header("Location: " . __CTR_HOST_PATH . "ctrl_ventas.php?accion=listar");
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Nueva Venta</title>
    <?= $html->html_css_header(__CSS_PATH . "style.css", "all"); ?>
</head>
<body>

<h2><?= $modo_editar ? "Editar Venta" : "Registrar Nueva Venta" ?></h2>

<form method="POST" action="<?= __CTR_HOST_PATH ?>ctrl_ventas.php" id="form-venta">
        <input type="hidden" name="accion" value="<?= $modo_editar ? 'actualizar_venta' : 'insertar_venta' ?>">
            <?php if ($modo_editar): ?>
                 <input type="hidden" name="id" value="<?= $id ?>">
            <?php endif; ?>

    <label>Cliente:</label>
    <select name="id_cliente" required>
        <option value="">Seleccione un cliente</option>
            <?php foreach ($clientes as $cli): ?>
        <option value="<?= $cli['id']; ?>" <?= ($modo_editar && $cli['id'] == $ventaData['id_cliente']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($cli['nombre_completo']); ?>
        </option>
            <?php endforeach; ?>
    </select>


    <h3>Detalles del Trabajo</h3>
    <div id="trabajos-container">
    <?php if ($modo_editar && !empty($detalles)): ?>
        <?php foreach ($detalles as $detalle): ?>
            <div class="trabajo">
                <label>Tipo de Trabajo:</label>
                <input type="text" name="tipo_trabajo[]" value="<?= htmlspecialchars($detalle['tipo_trabajo']) ?>" required>

                <label>Descripción:</label>
                <textarea name="descripcion[]" required><?= htmlspecialchars($detalle['descripcion']) ?></textarea>

                <label>Medidas:</label>
                <input type="text" name="medidas[]" value="<?= htmlspecialchars($detalle['medidas']) ?>">

                <label>Materiales Usados:</label>
                <textarea name="materiales_usados[]"><?= htmlspecialchars($detalle['materiales_usados']) ?></textarea>

                <label>Costo Mano de Obra:</label>
                <input type="number" name="costo_mano_obra[]" step="0.01" value="<?= htmlspecialchars($detalle['costo_mano_obra']) ?>" required>

                <button type="button" class="btn btn-delete btn-quitar-trabajo">Quitar Trabajo</button>
                <hr>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="trabajo">
            <label>Tipo de Trabajo:</label>
            <input type="text" name="tipo_trabajo[]" required>

            <label>Descripción:</label>
            <textarea name="descripcion[]" required></textarea>

            <label>Medidas:</label>
            <input type="text" name="medidas[]">

            <label>Materiales Usados:</label>
            <textarea name="materiales_usados[]"></textarea>    

                <label>Costo Mano de Obra:</label>
                <input type="number" name="costo_mano_obra[]" step="0.01" required>

                <button type="button" class="btn btn-delete btn-quitar-trabajo">Quitar Trabajo</button>
                <hr>
            </div>
        <?php endif; ?>
    </div>


    <button type="button" class="btn btn-new" id="btn-agregar-trabajo">+ Agregar Otro Trabajo</button>

    <h3>Total General: ₡ <span id="total-general">0.00</span></h3>

    <div class="acciones-formulario">
        <button type="submit" class="btn btn-new">Guardar Venta</button>
        <a href="<?= __CTR_HOST_PATH ?>ctrl_ventas.php?accion=listar" class="btn btn-delete">Cancelar</a>
    </div>
</form>

<script>
// Script para agregar más trabajos
document.getElementById('btn-agregar-trabajo').addEventListener('click', function () {
    const container = document.getElementById('trabajos-container');
    const trabajoOriginal = container.querySelector('.trabajo');
    const nuevoTrabajo = trabajoOriginal.cloneNode(true);

    // Limpiar campos
    nuevoTrabajo.querySelectorAll('input, textarea').forEach(el => el.value = "");

    container.appendChild(nuevoTrabajo);

    actualizarBotonesQuitar();
});

// Script para quitar trabajos
function actualizarBotonesQuitar() {
    document.querySelectorAll('.btn-quitar-trabajo').forEach(btn => {
        btn.onclick = function () {
            if (document.querySelectorAll('.trabajo').length > 1) {
                btn.parentElement.remove();
                calcularTotal();
            } else {
                alert("Debe tener al menos un trabajo en la venta.");
            }
        }
    });
}
actualizarBotonesQuitar();

// Script para calcular total automáticamente
document.getElementById('form-venta').addEventListener('input', calcularTotal);

function calcularTotal() {
    let total = 0;
    document.querySelectorAll('input[name="costo_mano_obra[]"]').forEach(input => {
        total += parseFloat(input.value) || 0;
    });
    document.getElementById('total-general').innerText = total.toFixed(2);
}
</script>

</body>
</html>
