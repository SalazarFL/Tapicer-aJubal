<?php
require_once("../../../global.php");
require_once(__CLS_PATH . "cls_html.php");
require_once(__CLS_PATH . "cls_servicio.php");

$html = new cls_Html();
$servicio = new cls_Servicio();

// Inicializar variables
$id = intval($_GET['id'] ?? 0);
$datos = [
    'nombre' => '',
    'descripcion' => '',
    'precio_base' => '',
    'tiempo_estimado_dias' => '',
];

// Si viene un ID, cargamos los datos del servicio
if ($id > 0) {
    $datosExistentes = $servicio->obtenerServicioPorId($id);
    if ($datosExistentes) {
        $datos = $datosExistentes;
    } else {
        header("Location: " . __CTR_HOST_PATH . "ctrl_servicios.php?accion=listar");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $id > 0 ? 'Editar Servicio' : 'Nuevo Servicio' ?></title>
    <?= $html->html_css_header(__CSS_PATH . "style.css", "all"); ?>
</head>
<body>

<h2><?= $id > 0 ? 'Editar Servicio' : 'Registrar Nuevo Servicio' ?></h2>

<form method="POST" action="<?= __CTR_HOST_PATH ?>ctrl_servicios.php" class="form-material">
    <input type="hidden" name="accion" value="<?= $id > 0 ? 'actualizar' : 'insertar' ?>">
    <?php if ($id > 0): ?>
        <input type="hidden" name="id" value="<?= $id ?>">
    <?php endif; ?>

    <label>Nombre del Servicio:</label>
    <input type="text" name="nombre" value="<?= htmlspecialchars($datos['nombre']) ?>" required>

    <label>Descripción:</label>
    <textarea name="descripcion" required><?= htmlspecialchars($datos['descripcion']) ?></textarea>

    <label>Precio Base (₡):</label>
    <input type="number" name="precio_base" step="0.01" value="<?= htmlspecialchars($datos['precio_base']) ?>" required>

    <label>Tiempo Estimado (días):</label>
    <input type="number" name="tiempo_estimado_dias" value="<?= htmlspecialchars($datos['tiempo_estimado_dias']) ?>" min="1" required>

    <div class="acciones-formulario">
        <button type="submit" class="btn btn-new"><?= $id > 0 ? 'Actualizar' : 'Guardar' ?></button>
        <a href="<?= __CTR_HOST_PATH ?>ctrl_servicios.php?accion=listar" class="btn btn-delete">Cancelar</a>
    </div>
</form>

</body>
</html>
