<?php
require_once("global.php");

// Redireccionar directamente al controlador de clientes con acción listar
header("Location: " . __CTR_HOST_PATH . "ctrl_clientes.php?accion=listar");
exit;
