<?php
require_once(__CLS_PATH . "cls_mysql.php");

class cls_Venta {
    private cls_Mysql $db;

    public function __construct() {
        $this->db = new cls_Mysql();
    }

    
   // Obtener todas las ventas de un cliente específico     
    public function obtenerVentasPorCliente(int $id_cliente): array {
        $sql = "SELECT fecha, estado, total
                FROM ventas
                WHERE id_cliente = ?
                ORDER BY fecha DESC";

        $params = [$id_cliente];
        $types = "i";

        $result = $this->db->sql_execute_prepared($sql, $types, $params);

        return ($result) ? $this->db->sql_get_rows_assoc($result) : [];
    }

    
   //Insertar una nueva venta     
    public function insertarVenta(int $id_cliente, int $id_usuario, string $fecha, string $estado, float $total): ?int {
        $sql = "INSERT INTO ventas (id_cliente, id_usuario, fecha, estado, total) 
                VALUES (?, ?, ?, ?, ?)";
        $params = [$id_cliente, $id_usuario, $fecha, $estado, $total];
        $types = "iissd";

        if ($this->db->sql_execute_prepared_dml($sql, $types, $params)) {
            return $this->db->sql_get_last_insert_id(); 
        }
        return null;
    }

   
    //Insertar un detalle de venta    
    public function insertarDetalleVenta(int $id_venta, string $tipo_trabajo, string $descripcion, string $medidas, string $materiales_usados, float $costo_mano_obra, float $subtotal): bool {
        $sql = "INSERT INTO detalle_ventas (id_venta, tipo_trabajo, descripcion, medidas, materiales_usados, costo_mano_obra, subtotal)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $params = [$id_venta, $tipo_trabajo, $descripcion, $medidas, $materiales_usados, $costo_mano_obra, $subtotal];
        $types = "isssddd";

        return $this->db->sql_execute_prepared_dml($sql, $types, $params);
    }

    
   //Actualizar el total de una venta     
    public function actualizarTotalVenta(int $id_venta, float $nuevo_total): bool {
        $sql = "UPDATE ventas SET total = ? WHERE id = ?";
        $params = [$nuevo_total, $id_venta];
        $types = "di";

        return $this->db->sql_execute_prepared_dml($sql, $types, $params);
    }

   
    // Eliminar todos los detalles de una venta    
    public function eliminarDetalleVenta(int $id_venta): bool {
        $sql = "DELETE FROM detalle_ventas WHERE id_venta = ?";
        $params = [$id_venta];
        $types = "i";

        return $this->db->sql_execute_prepared_dml($sql, $types, $params);
    }

   
    // Eliminar una venta (primero se deben eliminar sus detalles)   
    public function eliminarVenta(int $id_venta): bool {
        $this->eliminarDetalleVenta($id_venta); 
        $sql = "DELETE FROM ventas WHERE id = ?";
        $params = [$id_venta];
        $types = "i";

        return $this->db->sql_execute_prepared_dml($sql, $types, $params);
    }

    
    //Obtener todas las ventas    
    public function obtenerVentas(): array {
        $sql = "SELECT v.id, v.fecha, v.estado, v.total,
                       c.nombre_completo AS nombre_cliente,
                       u.nombre_completo AS nombre_usuario
                FROM ventas v
                INNER JOIN clientes c ON v.id_cliente = c.id
                INNER JOIN usuarios u ON v.id_usuario = u.id
                ORDER BY v.fecha DESC";

        $result = $this->db->sql_execute($sql);

        return ($result) ? $this->db->sql_get_rows_assoc($result) : [];
    }

    
   //Obtener una venta específica    
    public function obtenerVentaPorId(int $id): ?array {
        $sql = "SELECT v.id, v.fecha, v.estado, v.total, 
                       v.id_cliente, 
                       c.nombre_completo AS nombre_cliente, 
                       u.nombre_completo AS nombre_usuario
                FROM ventas v
                INNER JOIN clientes c ON v.id_cliente = c.id
                INNER JOIN usuarios u ON v.id_usuario = u.id
                WHERE v.id = ?";
        $params = [$id];
        $types = "i";
    
        $result = $this->db->sql_execute_prepared($sql, $types, $params);
        return ($result) ? $this->db->sql_get_fetchassoc($result) : null;
    }
    
   
  // Obtener los detalles de una venta específica
    
    public function obtenerDetalleVenta(int $id_venta): array {
        $sql = "SELECT tipo_trabajo, descripcion, medidas, materiales_usados, costo_mano_obra, subtotal 
                FROM detalle_ventas
                WHERE id_venta = ?";
        $params = [$id_venta];
        $types = "i";

        $result = $this->db->sql_execute_prepared($sql, $types, $params);

        return ($result) ? $this->db->sql_get_rows_assoc($result) : [];
    }

// Insertar un abono
public function insertarAbono(int $id_venta, float $monto): bool {
    $fecha_actual = date('Y-m-d'); // Fecha actual
    $sql = "INSERT INTO abonos (id_venta, monto_abono, fecha_abono) VALUES (?, ?, ?)";
    $params = [$id_venta, $monto, $fecha_actual];
    $types = "ids"; // int, double, string

    return $this->db->sql_execute_prepared_dml($sql, $types, $params);
}

// Obtener todos los abonos de una venta
public function obtenerAbonosPorVenta(int $id_venta): array {
    $sql = "SELECT id, fecha_abono, monto_abono FROM abonos WHERE id_venta = ? ORDER BY fecha_abono ASC";
    $params = [$id_venta];
    $types = "i";

    $result = $this->db->sql_execute_prepared($sql, $types, $params);

    return ($result) ? $this->db->sql_get_rows_assoc($result) : [];
}

// Calcular el total abonado de una venta
public function obtenerTotalAbonado(int $id_venta): float {
    $sql = "SELECT SUM(monto_abono) AS total_abonado FROM abonos WHERE id_venta = ?";
    $params = [$id_venta];
    $types = "i";

    $result = $this->db->sql_execute_prepared($sql, $types, $params);
    $row = ($result) ? $this->db->sql_get_fetchassoc($result) : null;

    return floatval($row['total_abonado'] ?? 0);
}

// Actualizar el estado de una venta
public function actualizarEstadoVenta(int $id_venta, string $nuevo_estado): bool {
    $sql = "UPDATE ventas SET estado = ? WHERE id = ?";
    $params = [$nuevo_estado, $id_venta];
    $types = "si";

    return $this->db->sql_execute_prepared_dml($sql, $types, $params);
}

}
?>
