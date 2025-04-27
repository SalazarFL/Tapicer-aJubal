<?php
require_once("../../../global.php");
require_once(__CLS_PATH . "cls_html.php");
$html = new cls_Html();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Abono</title>
    <?= $html->html_css_header(__CSS_PATH . "style.css", "all"); ?>
</head>
<body>

<h2>Registrar Abono</h2>

<form method="POST" action="<?= __CTR_HOST_PATH ?>ctrl_ventas.php">
    <input type="hidden" name="accion" value="insertar_abono">
    <input type="hidden" name="id_venta" value="<?= intval($_GET['id'] ?? 0) ?>">

    <label>Monto del Abono:</label>
    <input type="number" name="monto" step="0.01" min="1" required>

    <div class="acciones-formulario">
        <button type="submit" class="btn btn-new">Guardar Abono</button>
        <a href="<?= __CTR_HOST_PATH ?>ctrl_ventas.php?accion=detalle&id=<?= intval($_GET['id'] ?? 0) ?>" class="btn btn-delete">Cancelar</a>
    </div>
</form>

</body>
</html>
