<?php
require_once("global.php");
require_once(__CLS_PATH . "cls_html.php");

$html = new cls_Html();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio Reportes</title>
    <?= $html->html_css_header(__CSS_PATH . "style.css", "all"); ?>
</head>
<body>

<h1>Bienvenido al Módulo de Reportes 📚</h1>

<div class="inicio-reportes">
    <p>Desde aquí puedes acceder al menú general de reportes:</p>

    <a href="<?= __VWS_HOST_PATH ?>reportes/reportes.php" class="btn btn-new">Ir al Menú de Reportes</a>
</div>

<style>
.inicio-reportes {
    margin-top: 40px;
    text-align: center;
}

.inicio-reportes p {
    font-size: 18px;
    margin-bottom: 20px;
}
</style>

</body>
</html>
