<?php
require_once("../../global.php");
require_once(__CLS_PATH . "cls_cliente.php");

$cliente = new cls_Cliente();

// Solo si quiere eliminar
if (isset($_GET['accion']) && $_GET['accion'] === 'eliminar' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        $resultado = $cliente->eliminarCliente($id);

        if ($resultado) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
        } else {
            // Si no se pudo eliminar, pero no se sabe bien por qué
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'No se pudo eliminar el cliente.']);
        }
    } catch (mysqli_sql_exception $e) {
        // Capturamos el error SQL de base de datos
        if (strpos($e->getMessage(), 'a foreign key constraint fails') !== false) {
            // Error típico de FK
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'Este cliente tiene ventas asociadas y no puede ser eliminado.']);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'Error inesperado: ' . $e->getMessage()]);
        }
    }
    exit;
}

// Si llegó aquí es porque no envió parámetros correctos
http_response_code(400);
echo json_encode(['success' => false, 'error' => 'Parámetros inválidos']);
?>
