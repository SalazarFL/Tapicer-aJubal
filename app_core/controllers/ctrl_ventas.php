<?php
require_once("../../global.php");
require_once(__CLS_PATH . "cls_venta.php");
require_once(__CLS_PATH . "cls_message.php");

$venta = new cls_Venta();

$accion = $_REQUEST['accion'] ?? 'listar';

switch ($accion) {
    case "insertar_venta":
        $id_cliente = intval($_POST['id_cliente'] ?? 0);
        $id_usuario = $_SESSION['id_usuario'] ?? 1; // Asegúrate que tienes el id_usuario en sesión
        $fecha = date('Y-m-d');
        $estado = 'recibido';

        // Insertar venta principal
        $id_venta = $venta->insertarVenta($id_cliente, $id_usuario, $fecha, $estado, 0);

        if ($id_venta) {
            $total_general = 0;

            // Insertar todos los trabajos
            foreach ($_POST['tipo_trabajo'] as $i => $tipo) {
                $descripcion = $_POST['descripcion'][$i] ?? '';
                $medidas = $_POST['medidas'][$i] ?? '';
                $materiales_usados = $_POST['materiales_usados'][$i] ?? '';
                $costo_mano_obra = floatval($_POST['costo_mano_obra'][$i] ?? 0);

                $venta->insertarDetalleVenta($id_venta, $tipo, $descripcion, $medidas, $materiales_usados, $costo_mano_obra, $costo_mano_obra);

                $total_general += $costo_mano_obra;
            }

            // Actualizar total en la venta
            $venta->actualizarTotalVenta($id_venta, $total_general);

            header("Location: " . __CTR_HOST_PATH . "ctrl_ventas.php?accion=listar");
            exit;
        } else {
            cls_Message::show_message("No se pudo guardar la venta.", "error", "");
        }
        break;

        case "insertar_abono":
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
                    // Actualizar el total abonado ahora con el nuevo abono
                    $total_abonado_actualizado = $total_abonado + $monto;
                    $saldo_actualizado = ($datosVenta['total'] ?? 0) - $total_abonado_actualizado;
            
                    if ($saldo_actualizado <= 0) {
                        // Si ya no hay saldo pendiente, cambiar estado a "pagado"
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
        $id_venta = intval($_POST['id'] ?? 0);
        $id_cliente = intval($_POST['id_cliente'] ?? 0);

        if ($id_venta > 0) {
            $venta->eliminarDetalleVenta($id_venta); // Eliminamos los trabajos antiguos

            $total_general = 0;

            // Insertar nuevos trabajos
            foreach ($_POST['tipo_trabajo'] as $i => $tipo) {
                $descripcion = $_POST['descripcion'][$i] ?? '';
                $medidas = $_POST['medidas'][$i] ?? '';
                $materiales_usados = $_POST['materiales_usados'][$i] ?? '';
                $costo_mano_obra = floatval($_POST['costo_mano_obra'][$i] ?? 0);

                $venta->insertarDetalleVenta($id_venta, $tipo, $descripcion, $medidas, $materiales_usados, $costo_mano_obra, $costo_mano_obra);

                $total_general += $costo_mano_obra;
            }

            // Actualizar total
            $venta->actualizarTotalVenta($id_venta, $total_general);

            header("Location: " . __CTR_HOST_PATH . "ctrl_ventas.php?accion=listar");
            exit;
        } else {
            cls_Message::show_message("ID de venta inválido.", "error", "");
        }
        break;

    case "eliminar":
        $id = intval($_GET['id'] ?? 0);

        if ($venta->eliminarVenta($id)) {
            header("Location: " . __CTR_HOST_PATH . "ctrl_ventas.php?accion=listar");
            exit;
        } else {
            cls_Message::show_message("No se pudo eliminar la venta.", "error", "");
        }
        break;

        case "detalle":
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
        $lista = $venta->obtenerVentas();
        include(__VWS_PATH . "ventas/lista_ventas.php");
        break;


}
?>
