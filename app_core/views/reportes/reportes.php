<?php
require_once("../../../global.php");
require_once(__CLS_PATH . "cls_html.php");
$html = new cls_Html();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes Generales</title>
    <?= $html->html_css_header(__CSS_PATH . "style.css", "all"); ?>
</head>
<body>
<?php include(__VWS_PATH . "navbar.php"); ?>
<h2>Menú de Reportes 📑</h2>

<div class="contenedor-reportes">

    <div class="reporte-item">
        <h3>Clientes</h3>
        <a href="<?= __CTR_HOST_PATH ?>ctrl_reportes.php?tipo=clientes&formato=pdf" class="btn btn-pdf" target="_blank">📄 PDF</a>
        <a href="<?= __CTR_HOST_PATH ?>ctrl_reportes.php?tipo=clientes&formato=excel" class="btn btn-excel" target="_blank">📊 Excel</a>
    </div>

    <div class="reporte-item">
        <h3>Materiales</h3>
        <a href="<?= __CTR_HOST_PATH ?>ctrl_reportes.php?tipo=materiales&formato=pdf" class="btn btn-pdf" target="_blank">📄 PDF</a>
        <a href="<?= __CTR_HOST_PATH ?>ctrl_reportes.php?tipo=materiales&formato=excel" class="btn btn-excel" target="_blank">📊 Excel</a>
    </div>

    <div class="reporte-item">
        <h3>Servicios</h3>
        <a href="<?= __CTR_HOST_PATH ?>ctrl_reportes.php?tipo=servicios&formato=pdf" class="btn btn-pdf" target="_blank">📄 PDF</a>
        <a href="<?= __CTR_HOST_PATH ?>ctrl_reportes.php?tipo=servicios&formato=excel" class="btn btn-excel" target="_blank">📊 Excel</a>
    </div>

    <div class="reporte-item">
        <h3>Ventas</h3>
        <a href="<?= __CTR_HOST_PATH ?>ctrl_reportes.php?tipo=ventas&formato=pdf" class="btn btn-pdf" target="_blank">📄 PDF</a>
        <a href="<?= __CTR_HOST_PATH ?>ctrl_reportes.php?tipo=ventas&formato=excel" class="btn btn-excel" target="_blank">📊 Excel</a>
    </div>

    <div class="reporte-item">
        <h3>Abonos</h3>
        <a href="<?= __CTR_HOST_PATH ?>ctrl_reportes.php?tipo=abonos&formato=pdf" class="btn btn-pdf" target="_blank">📄 PDF</a>
        <a href="<?= __CTR_HOST_PATH ?>ctrl_reportes.php?tipo=abonos&formato=excel" class="btn btn-excel" target="_blank">📊 Excel</a>
    </div>

</div>

<style>
.contenedor-reportes {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 30px;
}

.reporte-item {
    background-color: #f9f9f9;
    border: 2px solid #eeba0b;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.reporte-item h3 {
    margin-bottom: 15px;
}

.reporte-item .btn {
    margin: 5px;
    padding: 10px 20px;
    display: inline-block;
}
</style>
<?php include(__VWS_PATH . "footer.php"); ?>
</body>

</html>
