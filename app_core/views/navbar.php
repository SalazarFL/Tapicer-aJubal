<?php
require_once(__CLS_PATH . "cls_html.php");
$html = new cls_Html();
?>

<!-- NAVBAR GLOBAL -->
<div class="navbar">
    <a href="<?= __VWS_HOST_PATH ?>dashboard.php">🏠 Inicio</a>
    <a href="<?= __CTR_HOST_PATH ?>ctrl_clientes.php?accion=listar">👥 Clientes</a>
    <a href="<?= __CTR_HOST_PATH ?>ctrl_materiales.php?accion=listar">🛠️ Inventario</a>
    <a href="<?= __CTR_HOST_PATH ?>ctrl_servicios.php?accion=listar">💼 Servicios</a>
    <a href="<?= __CTR_HOST_PATH ?>ctrl_ventas.php?accion=listar">🛒 Ventas</a>
    <a href="<?= __VWS_HOST_PATH ?>reportes/reportes.php">📈 Reportes</a>
    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
    <li><a href="<?= __VWS_HOST_PATH ?>usuarios/lista_usuarios.php">Usuarios</a></li>
<?php endif; ?>
<div class="navbar-right">
    <?php if (isset($_SESSION['nombre_completo'])): ?>
        <span style="color: white; margin-right: 10px;">👤 <?= htmlspecialchars($_SESSION['nombre_completo']); ?></span>
    <?php endif; ?>
    <a href="<?= __CTR_HOST_PATH ?>ctrl_logout.php">🔒 Cerrar Sesión</a>
</div>


</div>

<style>
    /* Estilos rápidos para Navbar */
    .navbar {
        background-color: #a63c06;
        overflow: hidden;
        padding: 10px 20px;
    }
    .navbar a {
        float: left;
        color: white;
        text-align: center;
        padding: 12px 16px;
        text-decoration: none;
        font-size: 17px;
    }
    .navbar a:hover {
        background-color: #710000;
        color: white;
    }
    .navbar-right {
        float: right;
    }
</style>
