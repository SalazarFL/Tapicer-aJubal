<?php
// ----------------------------------------------
// CONFIGURACIÓN DE NOMBRE Y ZONA HORARIA
// ----------------------------------------------
$myhost    = "http://localhost";
$myproject = "tapiceria-jubal";
$mysite    = $myhost . "/" . $myproject;

date_default_timezone_set('America/Costa_Rica');

// ----------------------------------------------
// RUTAS DEL SISTEMA
// ----------------------------------------------
define('__ROOT__', $_SERVER["DOCUMENT_ROOT"]);
define('__SITE_PATH', $mysite);
define('__CLS_PATH', __ROOT__ . "/" . $myproject . "/app_core/classes/");
define('__CTR_PATH', __ROOT__ . "/" . $myproject . "/app_core/controllers/");
define('__VWS_PATH', __ROOT__ . "/" . $myproject . "/app_core/views/");
define('__VWS_HOST_PATH', $mysite . "/app_core/views/");
define('__CTR_HOST_PATH', $mysite . "/app_core/controllers/");
define('__JS_PATH', $mysite . "/app_design/js/");
define('__CSS_PATH', $mysite . "/app_design/css/");
define('__IMG_PATH', $mysite . "/app_design/img/");

// ----------------------------------------------
// GESTIÓN DE ERRORES GLOBAL
// ----------------------------------------------
set_error_handler("my_error_handler", E_ALL);
require_once(__CLS_PATH . "cls_message.php");

function my_error_handler(int $errno, string $errstr, string $errfile, int $errline): bool {
    try {
        $MSG = new cls_Message();
        throw new Exception($errstr);
    } catch (Exception $e) {
        $MSG->show_message($e->getMessage(), "warning", "");
    }
    return true; // indica que el error fue manejado
}

// ----------------------------------------------
// INICIO DE SESIÓN
// ----------------------------------------------
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
