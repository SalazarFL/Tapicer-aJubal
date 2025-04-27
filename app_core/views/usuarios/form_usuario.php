<?php
require_once("../../../global.php");
require_once(__CLS_PATH . "cls_html.php");

$html = new cls_Html();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Usuario</title>
    <?= $html->html_css_header(__CSS_PATH . "style.css", "all"); ?>
</head>
<body>

<h2>Registrar Nuevo Usuario</h2>

<form method="POST" action="<?= __CTR_HOST_PATH ?>ctrl_usuarios.php">
    <input type="hidden" name="accion" value="insertar_usuario">

    <label>Nombre de Usuario:</label>
    <input type="text" name="nombre_usuario" required>

    <label>Contraseña:</label>
    <input type="password" name="contrasena" required>

    <label>Nombre Completo:</label>
    <input type="text" name="nombre_completo" required>

    <label>Rol:</label>
    <select name="rol" required>
        <option value="admin">Administrador</option>
        <option value="empleado">Empleado</option>
    </select>

    <div class="acciones-formulario">
        <button type="submit" class="btn btn-new">Guardar Usuario</button>
        <a href="<?= __VWS_HOST_PATH ?>usuarios/lista_usuarios.php" class="btn btn-delete">Cancelar</a>
    </div>
</form>

</body>
</html>
