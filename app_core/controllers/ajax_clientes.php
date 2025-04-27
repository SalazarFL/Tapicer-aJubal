<?php
require_once("../../global.php");
require_once(__CLS_PATH . "cls_cliente.php");

$cliente = new cls_Cliente();

// Listar clientes
$nombre = $_GET['nombre'] ?? "";
$telefono = $_GET['telefono'] ?? "";
$correo = $_GET['correo'] ?? "";

$lista = $cliente->obtenerClientes($nombre, $telefono, $correo);

// Imprimir solo las filas <tr>
header('Content-Type: text/html');
if (!empty($lista)) {
    foreach ($lista as $cliente) {
        echo "<tr>";
        echo "<td data-label='ID'>{$cliente['id']}</td>";
        echo "<td data-label='Nombre completo'>{$cliente['nombre_completo']}</td>";
        echo "<td data-label='Teléfono'>{$cliente['telefono']}</td>";
        echo "<td data-label='Dirección'>{$cliente['direccion']}</td>";
        echo "<td data-label='Correo'>{$cliente['correo']}</td>";
        echo "<td data-label='Acciones'>
                <button type='button' class='btn btn-edit' onclick=\"window.location.href='" . __VWS_HOST_PATH . "clientes/form_cliente.php?id={$cliente['id']}'\">Editar</button>
                <button type='button' class='btn btn-delete btn-eliminar' data-id='{$cliente['id']}'>Eliminar</button>
                <button type='button' class='btn btn-pdf' onclick=\"window.location.href='" . __VWS_HOST_PATH . "clientes/estado_cuenta.php?id={$cliente['id']}'\">Estado de Cuenta</button>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No hay clientes registrados.</td></tr>";
}
?>
