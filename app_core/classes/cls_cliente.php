<?php
require_once(__CLS_PATH . "cls_mysql.php");
require_once(__CLS_PATH . "cls_message.php");

class cls_Cliente {
    private cls_Mysql $db;

    public function __construct() {
        $this->db = new cls_Mysql();
    }

    /**
     * Inserta un nuevo cliente en la base de datos
     */
    public function insertarCliente(string $nombre_completo, string $telefono, string $direccion, string $correo): bool {
        $sql = "INSERT INTO clientes (nombre_completo, telefono, direccion, correo) VALUES (?, ?, ?, ?)";
        $params = [$nombre_completo, $telefono, $direccion, $correo];
        $types = "ssss";

        return $this->db->sql_execute_prepared_dml($sql, $types, $params);
    }

    /**
     * Lista todos los clientes
     */
    public function obtenerClientes(string $nombre = "", string $telefono = "", string $correo = ""): array {
        $sql = "SELECT * FROM clientes WHERE 1=1";
        $params = [];
        $types = "";
    
        if (!empty($nombre)) {
            $sql .= " AND nombre_completo LIKE ?";
            $params[] = "%" . $nombre . "%";
            $types .= "s";
        }
    
        if (!empty($telefono)) {
            $sql .= " AND telefono LIKE ?";
            $params[] = "%" . $telefono . "%";
            $types .= "s";
        }
    
        if (!empty($correo)) {
            $sql .= " AND correo LIKE ?";
            $params[] = "%" . $correo . "%";
            $types .= "s";
        }
    
        $sql .= " ORDER BY nombre_completo ASC";
    
        if (empty($params)) {
            $result = $this->db->sql_execute($sql);
        } else {
            $result = $this->db->sql_execute_prepared($sql, $types, $params);
        }
    
        return ($result) ? $this->db->sql_get_rows_assoc($result) : [];
    }
    

    /**
     * Obtener un cliente por ID
     */
    public function obtenerClientePorId(int $id): ?array {
        $sql = "SELECT * FROM clientes WHERE id = ?";
        $params = [$id];
        $types = "i";

        $result = $this->db->sql_execute_prepared($sql, $types, $params);
        return ($result) ? $this->db->sql_get_fetchassoc($result) : null;
    }

    /**
     * Actualizar datos de un cliente
     */
    public function actualizarCliente(int $id, string $nombre_completo, string $telefono, string $direccion, string $correo): bool {
        $sql = "UPDATE clientes SET nombre_completo = ?, telefono = ?, direccion = ?, correo = ? WHERE id = ?";
        $params = [$nombre_completo, $telefono, $direccion, $correo, $id];
        $types = "ssssi";

        return $this->db->sql_execute_prepared_dml($sql, $types, $params);
    }

    /**
     * Eliminar cliente
     */
    public function eliminarCliente(int $id): bool {
        $sql = "DELETE FROM clientes WHERE id = ?";
        $params = [$id];
        $types = "i";

        return $this->db->sql_execute_prepared_dml($sql, $types, $params);
    }
}
?>
