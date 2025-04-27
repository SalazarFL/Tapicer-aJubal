<?php
require_once("../../../global.php");
require_once(__CLS_PATH . "cls_html.php");
require_once(__CLS_PATH . "cls_mysql.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Solo admin puede ver esta página
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: " . __VWS_HOST_PATH . "dashboard.php");
    exit;
}

$html = new cls_Html();
$db = new cls_Mysql();

// Obtener usuarios
$sql = "SELECT id, nombre_usuario, nombre_completo, rol, fecha_creacion FROM usuarios";
$usuarios = [];
$result = $db->sql_execute($sql);
if ($result) {
    $usuarios = $db->sql_get_rows_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuarios Registrados</title>
    <?= $html->html_css_header(__CSS_PATH . "style.css", "all"); ?>
</head>
<body>

<?php include(__VWS_PATH . "navbar.php"); ?>

<h2>Usuarios Registrados</h2>

<div class="acciones-reporte">
        <a href="<?= __VWS_HOST_PATH ?>usuarios/form_usuario.php" class="btn btn-new">+ Añadir Usuario</a>

</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Nombre Completo</th>
            <th>Rol</th>
            <th>Fecha Creación</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($usuarios)): ?>
            <?php foreach ($usuarios as $user): ?>
                <tr>
                    <td><?= $user['id']; ?></td>
                    <td><?= htmlspecialchars($user['nombre_usuario']); ?></td>
                    <td><?= htmlspecialchars($user['nombre_completo']); ?></td>
                    <td><?= ucfirst($user['rol']); ?></td>
                    <td><?= $user['fecha_creacion']; ?></td>
                    <td>
                        <?php if ($user['id'] !== $_SESSION['id_usuario']): ?>
                            <a href="<?= __CTR_HOST_PATH ?>ctrl_usuarios.php?accion=eliminar_usuario&id=<?= $user['id']; ?>" class="btn btn-delete" onclick="return confirm('¿Desea eliminar este usuario?');">Eliminar</a>
                        <?php else: ?>
                            <!-- No se puede eliminar a sí mismo -->
                            <span style="color: gray;">No permitido</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6">No hay usuarios registrados.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
