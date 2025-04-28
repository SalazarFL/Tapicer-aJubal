<?php
require_once(__CLS_PATH . "cls_mysql.php");

class cls_Material {
    private cls_Mysql $db;

    public function __construct() {
        $this->db = new cls_Mysql();
    }

    // Insertar nuevo material
    public function insertarMaterial(string $nombre, string $tipo, int $cantidad, float $precio, ?string $imagen = null): bool {
        $sql = "INSERT INTO materiales (nombre, tipo, cantidad_disponible, precio_unitario, imagen) VALUES (?, ?, ?, ?, ?)";
        $params = [$nombre, $tipo, $cantidad, $precio, $imagen];
        $types = "ssids";

        return $this->db->sql_execute_prepared_dml($sql, $types, $params);
    }

    // Actualizar material existente
    public function actualizarMaterial(int $id, string $nombre, string $tipo, int $cantidad, float $precio, ?string $imagen = null): bool {
        if ($imagen !== null) {
            $sql = "UPDATE materiales SET nombre = ?, tipo = ?, cantidad_disponible = ?, precio_unitario = ?, imagen = ? WHERE id = ?";
            $params = [$nombre, $tipo, $cantidad, $precio, $imagen, $id];
            $types = "ssidsi";
        } else {
            $sql = "UPDATE materiales SET nombre = ?, tipo = ?, cantidad_disponible = ?, precio_unitario = ? WHERE id = ?";
            $params = [$nombre, $tipo, $cantidad, $precio, $id];
            $types = "ssidi";
        }

        return $this->db->sql_execute_prepared_dml($sql, $types, $params);
    }

    // Eliminar material
    public function eliminarMaterial(int $id): bool {
        $sql = "DELETE FROM materiales WHERE id = ?";
        $params = [$id];
        $types = "i";

        return $this->db->sql_execute_prepared_dml($sql, $types, $params);
    }

    // Obtener listado de materiales
    public function obtenerMateriales(): array {
        $sql = "SELECT id, nombre, tipo, cantidad_disponible, precio_unitario FROM materiales ORDER BY nombre ASC";
        $result = $this->db->sql_execute($sql);
        return ($result) ? $this->db->sql_get_rows_assoc($result) : [];
    }

    // Obtener material por ID
    public function obtenerMaterialPorId(int $id): ?array {
        $sql = "SELECT id, nombre, tipo, cantidad_disponible, precio_unitario, imagen FROM materiales WHERE id = ?";
        $params = [$id];
        $types = "i";
    
        $result = $this->db->sql_execute_prepared($sql, $types, $params);
        return ($result) ? $this->db->sql_get_fetchassoc($result) : null;
    }
    

    // Obtener solo la imagen de un material
    public function obtenerImagenPorId(int $id): ?string {
        $sql = "SELECT imagen FROM materiales WHERE id = ?";
        $params = [$id];
        $types = "i";

        $result = $this->db->sql_execute_prepared($sql, $types, $params);

        if ($result) {
            $row = $this->db->sql_get_fetchassoc($result);
            return $row['imagen'] ?? null;
        }
        return null;
    }
}
?>
