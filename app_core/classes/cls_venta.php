<?php
require_once(__CLS_PATH . "cls_mysql.php");

class cls_Venta {
    private cls_Mysql $db;

    public function __construct() {
        $this->db = new cls_Mysql();
    }

    /**
     * Obtener todas las ventas de un cliente específico
     */
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
}
?>
