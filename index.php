<?php
require_once("global.php");

// Redireccionar directamente al controlador de materiales con acción listar
header("Location: " . __CTR_HOST_PATH . "ctrl_servicios.php?accion=listar");
exit;
?>
