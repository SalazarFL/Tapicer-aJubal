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
<?php include(__VWS_PATH . "navbar.php"); ?>
    <h2>Gestion de clientes</h2>

        <form id="form-filtro-clientes" class="form-filtro">
            <input type="text" name="nombre" placeholder="Buscar por nombre" class="input-filtro" value="<?= htmlspecialchars($_GET['nombre'] ?? '') ?>">
            <input type="text" name="telefono" placeholder="Buscar por teléfono" class="input-filtro" value="<?= htmlspecialchars($_GET['telefono'] ?? '') ?>">
            <input type="text" name="correo" placeholder="Buscar por correo" class="input-filtro" value="<?= htmlspecialchars($_GET['correo'] ?? '') ?>">

            <button type="submit" class="btn btn-new">🔍 Buscar</button>
            <button type="submit" id="btn-limpiar" class="btn btn-delete">♻️ Limpiar</button>
        </form>


    <div class="acciones-reporte">
        <a href="<?= __CTR_HOST_PATH ?>ctrl_reportes.php?tipo=clientes&formato=pdf" class="btn btn-pdf" target="_blank">📄 Generar PDF</a>
        <a href="<?= __CTR_HOST_PATH ?>ctrl_reportes.php?tipo=clientes&formato=excel" class="btn btn-excel">📊 Generar Excel</a>
        <a href="<?= __VWS_HOST_PATH ?>clientes/form_cliente.php" class="btn btn-new">+ Nuevo Cliente</a>
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
                            <button type="button" class="btn btn-edit" onclick="window.location.href='<?= __VWS_HOST_PATH ?>clientes/form_cliente.php?id=<?= $cliente['id']; ?>'">Editar</button>
                            <button type="button" class="btn btn-delete btn-eliminar" data-id="<?= $cliente['id']; ?>">Eliminar</button>
                            <button type="button" class="btn btn-pdf" onclick="window.location.href='<?= __VWS_HOST_PATH ?>clientes/estado_cuenta.php?id=<?= $cliente['id']; ?>'">Estado de Cuenta</button>
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
    const BASE_AJAX_CLIENTES_ACCIONES = "<?= __CTR_HOST_PATH ?>ajax_clientes_acciones.php";
    </script>
<?= $html->html_js_header(__JS_PATH . "scripts.js"); ?>
<?php include(__VWS_PATH . "footer.php"); ?>
</body>
</html>
