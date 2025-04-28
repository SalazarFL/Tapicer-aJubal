<?php
require_once("../../global.php");
require_once(__CLS_PATH . "cls_reporte.php");

// Obtenemos tipo de reporte y formato (por defecto PDF)
$tipo = $_GET["tipo"] ?? "";
$formato = $_GET["formato"] ?? "pdf";

$reporte = new cls_Reporte();

switch ($tipo) {
    case "clientes":

        // Configuración para reporte de clientes
        $sql = "SELECT id, nombre_completo, telefono, direccion, correo FROM clientes";
        $encabezados = ["ID", "Nombre", "Teléfono", "Dirección", "Correo"];
        $titulo = "Listado de Clientes";
        break;

    case "materiales":
        // Configuración para reporte de materiales
        $sql = "SELECT id, nombre, tipo, cantidad_disponible, precio_unitario FROM materiales";
        $encabezados = ["ID", "Nombre", "Tipo", "Cantidad Disponible", "Precio Unitario"];
        $titulo = "Inventario de Materiales";
        break;

    case "servicios":
        // Configuración para reporte de servicios
        $sql = "SELECT id, nombre, descripcion, precio_base, tiempo_estimado_dias FROM servicios";
        $encabezados = ["ID", "Servicio", "Descripción", "Precio Base", "Tiempo Estimado (días)"];
        $titulo = "Catálogo de Servicios";
        break;

    case "ventas":
        // Configuración para reporte de ventas
        $sql = "SELECT v.id, c.nombre_completo AS cliente, v.fecha, v.estado, v.total 
                FROM ventas v
                JOIN clientes c ON v.id_cliente = c.id
                ORDER BY v.fecha DESC";
        $encabezados = ["ID Venta", "Cliente", "Fecha", "Estado", "Total"];
        $titulo = "Reporte de Ventas";
        break;

    case "abonos":
        // Configuración para reporte de abonos
        $sql = "SELECT a.id, c.nombre_completo AS cliente, a.fecha_abono, a.monto_abono
                FROM abonos a
                JOIN ventas v ON a.id_venta = v.id
                JOIN clientes c ON v.id_cliente = c.id
                ORDER BY a.fecha_abono DESC";
        $encabezados = ["ID Abono", "Cliente", "Fecha Abono", "Monto Abonado"];
        $titulo = "Reporte de Abonos";
        break;

    default:
        // Si no es un tipo válido, se cancela
        echo "Tipo de reporte no válido.";
        exit;
}

// Llamamos a la función para generar el reporte
$reporte->generarReporte($titulo, $sql, $formato, $encabezados);
?>
