<?php
require_once("cls_mysql.php");

class cls_Servicio {
    private cls_Mysql $db;

    public function __construct() {
        $this->db = new cls_Mysql();
    }

    
    //Insertar un nuevo servicio     
    public function insertarServicio(string $nombre, string $descripcion, float $precio_base, int $tiempo_estimado): bool {
        $sql = "INSERT INTO servicios (nombre, descripcion, precio_base, tiempo_estimado_dias)
                VALUES (?, ?, ?, ?)";
        $params = [$nombre, $descripcion, $precio_base, $tiempo_estimado];
        $types = "ssdi"; // string, string, decimal, integer

        return $this->db->sql_execute_prepared_dml($sql, $types, $params);
    }

   
   //Obtener todos los servicios        
     public function obtenerServicios(): array {
        $sql = "SELECT id, nombre, descripcion, precio_base, tiempo_estimado_dias FROM servicios";
        $result = $this->db->sql_execute($sql);
        return ($result) ? $this->db->sql_get_rows_assoc($result) : [];
    }
    

    
     //Obtener un servicio por ID
    public function obtenerServicioPorId(int $id): ?array {
        $sql = "SELECT * FROM servicios WHERE id = ?";
        $params = [$id];
        $types = "i";

        $result = $this->db->sql_execute_prepared($sql, $types, $params);
        return ($result) ? $this->db->sql_get_fetchassoc($result) : null;
    }

    
     //Actualizar un servicio    
    public function actualizarServicio(int $id, string $nombre, string $descripcion, float $precio_base, int $tiempo_estimado): bool {
        $sql = "UPDATE servicios 
                SET nombre = ?, descripcion = ?, precio_base = ?, tiempo_estimado_dias = ?
                WHERE id = ?";
        $params = [$nombre, $descripcion, $precio_base, $tiempo_estimado, $id];
        $types = "ssdii";

        return $this->db->sql_execute_prepared_dml($sql, $types, $params);
    }

    
    //Eliminar un servicio    
    public function eliminarServicio(int $id): bool {
        $sql = "DELETE FROM servicios WHERE id = ?";
        $params = [$id];
        $types = "i";

        return $this->db->sql_execute_prepared_dml($sql, $types, $params);
    }
      

}
?>
