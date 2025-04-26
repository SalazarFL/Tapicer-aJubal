<?php
require_once(__CLS_PATH . "cls_html.php");
$html = new cls_Html();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Clientes</title>
    <?= $html->html_css_header(__CSS_PATH . "style.css", "all"); ?>
</head>
<body>

    <h2>Listado de Clientes</h2>

        <form id="form-filtro-clientes" class="form-filtro">
            <input type="text" name="nombre" placeholder="Buscar por nombre" class="input-filtro" value="<?= htmlspecialchars($_GET['nombre'] ?? '') ?>">
            <input type="text" name="telefono" placeholder="Buscar por teléfono" class="input-filtro" value="<?= htmlspecialchars($_GET['telefono'] ?? '') ?>">
            <input type="text" name="correo" placeholder="Buscar por correo" class="input-filtro" value="<?= htmlspecialchars($_GET['correo'] ?? '') ?>">

            <button type="submit" class="btn btn-new">🔍 Buscar</button>
            <button type="button" id="btn-limpiar" class="btn btn-delete">♻️ Limpiar</button>
</form>


    <div class="acciones-reporte">
        <a href="<?= __CTR_HOST_PATH ?>ctrl_reportes.php?tipo=clientes&formato=pdf" class="btn btn-pdf" target="_blank">📄 Generar PDF</a>
        <a href="<?= __CTR_HOST_PATH ?>ctrl_reportes.php?tipo=clientes&formato=excel" class="btn btn-excel">📊 Generar Excel</a>
        <a href="form_cliente.php" class="btn btn-new">+ Nuevo Cliente</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre completo</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($lista)): ?>
                <?php foreach ($lista as $cliente): ?>
                    <tr>
                        <td data-label="ID"><?= $cliente['id']; ?></td>
                        <td data-label="Nombre completo"><?= $cliente['nombre_completo']; ?></td>
                        <td data-label="Teléfono"><?= $cliente['telefono']; ?></td>
                        <td data-label="Dirección"><?= $cliente['direccion']; ?></td>
                        <td data-label="Correo"><?= $cliente['correo']; ?></td>
                        <td data-label="Acciones">
                            <a href="form_cliente.php?id=<?= $cliente['id']; ?>" class="btn btn-edit">Editar</a>
                            <a href="<?= __CTR_HOST_PATH ?>ctrl_clientes.php?accion=eliminar&id=<?= $cliente['id']; ?>" class="btn btn-delete" onclick="return confirm('¿Desea eliminar este cliente?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">No hay clientes registrados.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <script>
    const BASE_AJAX_CLIENTES = "<?= __CTR_HOST_PATH ?>ajax_clientes.php";
</script>
<?= $html->html_js_header(__JS_PATH . "scripts.js"); ?>


</body>
</html>
