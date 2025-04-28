<?php
require_once("../../global.php");
require_once(__CLS_PATH . "cls_html.php");

$html = new cls_Html();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <!-- Cargar hoja de estilos -->
    <?= $html->html_css_header(__CSS_PATH . "style.css", "all"); ?>
</head>
<body>

<h2>Login Tapicería Jubal</h2>

<!-- Mostrar error si existe -->
<?php if (!empty($_GET['error'])): ?>
    <p style="color:red;">⚠️ <?= htmlspecialchars($_GET['error']); ?></p>
<?php endif; ?>

<!-- Formulario de inicio de sesión -->
<form method="POST" action="<?= __CTR_HOST_PATH ?>ctrl_login.php" class="form-login">
    <label>Usuario:</label>
    <input type="text" name="usuario" required>

    <label>Contraseña:</label>
    <input type="password" name="contrasena" required>

    <div class="acciones-formulario">
        <button type="submit" class="btn btn-new">Iniciar Sesión</button>
    </div>
</form>

</body>
</html>
