<?php
require_once("global.php");

// Redireccionar directamente al controlador de materiales con acción listar
header("Location: " . __CTR_HOST_PATH . "ctrl_ventas.php?accion=listar");
exit;
?>
