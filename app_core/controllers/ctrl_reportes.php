<?php
require_once("../../global.php");
require_once(__CLS_PATH . "cls_reporte.php");

$tipo = $_GET["tipo"] ?? "";
$formato = $_GET["formato"] ?? "pdf"; // por defecto PDF si no se especifica

$reporte = new cls_Reporte();

// Definir la consulta SQL y los encabezados dependiendo del tipo de reporte
switch ($tipo) {
    case "clientes":
        $sql = "SELECT id, nombre_completo, telefono, direccion, correo FROM clientes";
        $encabezados = ["ID", "Nombre", "Teléfono", "Dirección", "Correo"];
        $titulo = "Listado de Clientes";
        break;

    case "ventas":
        $sql = "SELECT v.id, c.nombre_completo AS cliente, v.fecha, v.estado, v.total 
                FROM ventas v
                JOIN clientes c ON v.id_cliente = c.id
                ORDER BY v.fecha DESC";
        $encabezados = ["ID Venta", "Cliente", "Fecha", "Estado", "Total"];
        $titulo = "Reporte de Ventas";
        break;

    case "materiales":
        $sql = "SELECT id, nombre, tipo, cantidad_disponible, precio_unitario FROM materiales";
        $encabezados = ["ID", "Nombre", "Tipo", "Cantidad Disponible", "Precio Unitario"];
        $titulo = "Inventario de Materiales";
        break;

    case "servicios":
        $sql = "SELECT id, nombre, descripcion, precio_base, tiempo_estimado_dias FROM servicios";
        $encabezados = ["ID", "Servicio", "Descripción", "Precio Base", "Tiempo Estimado (días)"];
        $titulo = "Catálogo de Servicios";
        break;

    case "usuarios":
        $sql = "SELECT id, nombre_usuario, nombre_completo, rol FROM usuarios";
        $encabezados = ["ID", "Usuario", "Nombre Completo", "Rol"];
        $titulo = "Listado de Usuarios";
        break;

    default:
        echo "Tipo de reporte no válido.";
        exit;
}

// Generar el reporte
$reporte->generarReporte($titulo, $sql, $formato, $encabezados);
