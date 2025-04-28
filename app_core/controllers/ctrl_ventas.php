<?php
require_once("../../global.php");
require_once(__CLS_PATH . "cls_venta.php");
require_once(__CLS_PATH . "cls_message.php");

$venta = new cls_Venta();

// Obtenemos la acción a realizar
$accion = $_REQUEST['accion'] ?? 'listar';

switch ($accion) {
    case "insertar_venta":
        // Insertar nueva venta y sus trabajos
        $id_cliente = intval($_POST['id_cliente'] ?? 0);
        $id_usuario = $_SESSION['id_usuario'] ?? 1;
        $fecha = date('Y-m-d');
        $estado = 'recibido';

        $id_venta = $venta->insertarVenta($id_cliente, $id_usuario, $fecha, $estado, 0);

        if ($id_venta) {
            $total_general = 0;

            foreach ($_POST['tipo_trabajo'] as $i => $tipo) {
                $descripcion = $_POST['descripcion'][$i] ?? '';
                $medidas = $_POST['medidas'][$i] ?? '';
                $materiales_usados = $_POST['materiales_usados'][$i] ?? '';
                $costo_mano_obra = floatval($_POST['costo_mano_obra'][$i] ?? 0);

                $venta->insertarDetalleVenta($id_venta, $tipo, $descripcion, $medidas, $materiales_usados, $costo_mano_obra, $costo_mano_obra);
                $total_general += $costo_mano_obra;
            }

            $venta->actualizarTotalVenta($id_venta, $total_general);

            header("Location: " . __CTR_HOST_PATH . "ctrl_ventas.php?accion=listar");
            exit;
        } else {
            cls_Message::show_message("No se pudo guardar la venta.", "error", "");
        }
        break;

    case "insertar_abono":
        // Insertar un abono a una venta
        $id_venta = intval($_POST['id_venta'] ?? 0);
        $monto = floatval($_POST['monto'] ?? 0);

        if ($id_venta > 0 && $monto > 0) {
            $datosVenta = $venta->obtenerVentaPorId($id_venta);
            $total_abonado = $venta->obtenerTotalAbonado($id_venta);
            $saldo_pendiente = ($datosVenta['total'] ?? 0) - $total_abonado;

            if ($monto > $saldo_pendiente) {
                echo "<script>alert('El monto del abono no puede ser mayor al saldo pendiente.'); window.location.href = '" . __CTR_HOST_PATH . "ctrl_ventas.php?accion=detalle&id=" . $id_venta . "';</script>";
                exit;
            }

            if ($venta->insertarAbono($id_venta, $monto)) {
                $total_abonado_actualizado = $total_abonado + $monto;
                $saldo_actualizado = ($datosVenta['total'] ?? 0) - $total_abonado_actualizado;

                if ($saldo_actualizado <= 0) {
                    $venta->actualizarEstadoVenta($id_venta, 'pagado');
                }

                header("Location: " . __CTR_HOST_PATH . "ctrl_ventas.php?accion=detalle&id=" . $id_venta);
                exit;
            } else {
                echo "Error al registrar el abono.";
            }
        } else {
            echo "Datos inválidos para registrar el abono.";
        }
        break;

    case "actualizar_venta":
        // Actualizar trabajos de una venta
        $id_venta = intval($_POST['id'] ?? 0);
        $id_cliente = intval($_POST['id_cliente'] ?? 0);

        if ($id_venta > 0) {
            $venta->eliminarDetalleVenta($id_venta);

            $total_general = 0;

            foreach ($_POST['tipo_trabajo'] as $i => $tipo) {
                $descripcion = $_POST['descripcion'][$i] ?? '';
                $medidas = $_POST['medidas'][$i] ?? '';
                $materiales_usados = $_POST['materiales_usados'][$i] ?? '';
                $costo_mano_obra = floatval($_POST['costo_mano_obra'][$i] ?? 0);

                $venta->insertarDetalleVenta($id_venta, $tipo, $descripcion, $medidas, $materiales_usados, $costo_mano_obra, $costo_mano_obra);
                $total_general += $costo_mano_obra;
            }

            $venta->actualizarTotalVenta($id_venta, $total_general);

            header("Location: " . __CTR_HOST_PATH . "ctrl_ventas.php?accion=listar");
            exit;
        } else {
            cls_Message::show_message("ID de venta inválido.", "error", "");
        }
        break;

    case "eliminar":
        // Eliminar venta
        $id = intval($_GET['id'] ?? 0);

        if ($venta->eliminarVenta($id)) {
            header("Location: " . __CTR_HOST_PATH . "ctrl_ventas.php?accion=listar");
            exit;
        } else {
            cls_Message::show_message("No se pudo eliminar la venta.", "error", "");
        }
        break;

    case "detalle":
        // Mostrar detalle de venta
        $id = intval($_GET['id'] ?? 0);

        if ($id > 0) {
            $datosVenta = $venta->obtenerVentaPorId($id);
            $detalles = $venta->obtenerDetalleVenta($id);

            if (!$datosVenta) {
                header("Location: " . __CTR_HOST_PATH . "ctrl_ventas.php?accion=listar");
                exit;
            }

            include(__VWS_PATH . "ventas/detalle_venta.php");
        } else {
            header("Location: " . __CTR_HOST_PATH . "ctrl_ventas.php?accion=listar");
            exit;
        }
        break;

    case "listar":
    default:
        // Listar todas las ventas
        $lista = $venta->obtenerVentas();
        include(__VWS_PATH . "ventas/lista_ventas.php");
        break;
}
?>
