<?php
require_once(__CLS_PATH . "cls_mysql.php");
require_once(__CLS_PATH . "cls_message.php");

class cls_Material {
    private cls_Mysql $db;

    public function __construct() {
        $this->db = new cls_Mysql();
    }

    /**
     * Inserta un nuevo material
     */
    public function insertarMaterial(string $nombre, string $tipo, int $cantidad_disponible, float $precio_unitario, ?array $imagen): bool {
        $sql = "INSERT INTO materiales (nombre, tipo, cantidad_disponible, precio_unitario, imagen) VALUES (?, ?, ?, ?, ?)";
        
        $imgData = ($imagen && $imagen['tmp_name']) ? file_get_contents($imagen['tmp_name']) : null;

        $params = [$nombre, $tipo, $cantidad_disponible, $precio_unitario, $imgData];
        $types = "ssids"; // string, string, int, decimal (float treated as double), string (para blob binario)

        return $this->db->sql_execute_prepared_dml($sql, $types, $params);
    }

    /**
     * Actualiza un material
     */
    public function actualizarMaterial(int $id, string $nombre, string $tipo, int $cantidad_disponible, float $precio_unitario, ?array $imagen): bool {
        if ($imagen && $imagen['tmp_name']) {
            // Actualizar también la imagen
            $sql = "UPDATE materiales SET nombre = ?, tipo = ?, cantidad_disponible = ?, precio_unitario = ?, imagen = ? WHERE id = ?";
            $imgData = file_get_contents($imagen['tmp_name']);
            $params = [$nombre, $tipo, $cantidad_disponible, $precio_unitario, $imgData, $id];
            $types = "ssidsi";
        } else {
            // No actualizar la imagen
            $sql = "UPDATE materiales SET nombre = ?, tipo = ?, cantidad_disponible = ?, precio_unitario = ? WHERE id = ?";
            $params = [$nombre, $tipo, $cantidad_disponible, $precio_unitario, $id];
            $types = "ssidi";
        }

        return $this->db->sql_execute_prepared_dml($sql, $types, $params);
    }

    /**
     * Elimina un material
     */
    public function eliminarMaterial(int $id): bool {
        $sql = "DELETE FROM materiales WHERE id = ?";
        $params = [$id];
        $types = "i";

        return $this->db->sql_execute_prepared_dml($sql, $types, $params);
    }

    /**
     * Lista todos los materiales
     */
    public function obtenerMateriales(): array {
        $sql = "SELECT id, nombre, tipo, cantidad_disponible, precio_unitario FROM materiales ORDER BY nombre ASC";
        $result = $this->db->sql_execute($sql);

        return ($result) ? $this->db->sql_get_rows_assoc($result) : [];
    }

    /**
     * Obtiene los datos de un material específico
     */
    public function obtenerMaterialPorId(int $id): ?array {
        $sql = "SELECT id, nombre, tipo, cantidad_disponible, precio_unitario FROM materiales WHERE id = ?";
        $params = [$id];
        $types = "i";

        $result = $this->db->sql_execute_prepared($sql, $types, $params);
        return ($result) ? $this->db->sql_get_fetchassoc($result) : null;
    }

    /**
     * Obtiene la imagen BLOB de un material
     */
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
