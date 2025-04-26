<?php
require_once("../../global.php");
require_once(__CLS_PATH . "cls_cliente.php");

$cliente = new cls_Cliente();

// Capturar filtros desde GET
$nombre = $_GET['nombre'] ?? "";
$telefono = $_GET['telefono'] ?? "";
$correo = $_GET['correo'] ?? "";

$lista = $cliente->obtenerClientes($nombre, $telefono, $correo);

// Imprimir solo las filas <tr> para actualizar la tabla vía JS
if (!empty($lista)) {
    foreach ($lista as $cliente) {
        echo "<tr>";
        echo "<td data-label='ID'>{$cliente['id']}</td>";
        echo "<td data-label='Nombre completo'>{$cliente['nombre_completo']}</td>";
        echo "<td data-label='Teléfono'>{$cliente['telefono']}</td>";
        echo "<td data-label='Dirección'>{$cliente['direccion']}</td>";
        echo "<td data-label='Correo'>{$cliente['correo']}</td>";
        echo "<td data-label='Acciones'>
                <a href='form_cliente.php?id={$cliente['id']}' class='btn btn-edit'>Editar</a>
                <a href='" . __CTR_HOST_PATH . "ctrl_clientes.php?accion=eliminar&id={$cliente['id']}' class='btn btn-delete' onclick='return confirm(\"¿Desea eliminar este cliente?\");'>Eliminar</a>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No hay clientes registrados.</td></tr>";
}
