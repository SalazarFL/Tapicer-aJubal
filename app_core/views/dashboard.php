<?php
require_once("../../global.php");
require_once(__CLS_PATH . "cls_html.php");

$html = new cls_Html();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Tapicería Jubal</title>
    <?= $html->html_css_header(__CSS_PATH . "style.css", "all"); ?>
</head>
<body>
<?php include(__VWS_PATH . "navbar.php"); ?>

<h1>Tapicería Jubal 🛋️</h1>
<p style="text-align: center; font-size: 18px;">Sistema de Gestión de Clientes, Ventas, Inventario y Reportes</p>

<div class="dashboard">
    <div class="card">
        <h3>📋 Clientes</h3>
        <p>Administrar clientes registrados.</p>
        <a href="<?= __VWS_HOST_PATH ?>clientes/lista_clientes.php" class="btn btn-new">Ir a Clientes</a>
    </div>

    <div class="card">
        <h3>🛠️ Materiales</h3>
        <p>Inventario de materiales disponibles.</p>
        <a href="<?= __VWS_HOST_PATH ?>inventario/lista_materiales.php" class="btn btn-new">Ir a Materiales</a>
    </div>

    <div class="card">
        <h3>💼 Servicios</h3>
        <p>Catálogo de servicios ofrecidos.</p>
        <a href="<?= __VWS_HOST_PATH ?>servicios/lista_servicios.php" class="btn btn-new">Ir a Servicios</a>
    </div>

    <div class="card">
        <h3>🛒 Ventas</h3>
        <p>Gestión de ventas y trabajos.</p>
        <a href="<?= __VWS_HOST_PATH ?>ventas/lista_ventas.php" class="btn btn-new">Ir a Ventas</a>
    </div>

    <div class="card">
        <h3>📈 Reportes</h3>
        <p>Generar reportes en PDF o Excel.</p>
        <a href="<?= __VWS_HOST_PATH ?>reportes/reportes.php" class="btn btn-new">Ver Reportes</a>
    </div>
</div>

<style>
h1 {
    text-align: center;
    margin-top: 30px;
    font-size: 36px;
}

.dashboard {
    margin: 40px auto;
    max-width: 1200px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    padding: 0 20px;
}

.card {
    background: #f4e409;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    text-align: center;
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-5px);
}

.card h3 {
    margin-bottom: 10px;
}

.card p {
    font-size: 14px;
    margin-bottom: 15px;
}

.card a {
    font-size: 14px;
}
</style>
<?php include(__VWS_PATH . "footer.php"); ?>

</body>
</html>
