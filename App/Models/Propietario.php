<?php
class Propietario
{
    private $conn; // Conexión a la base de datos
    private $table_name = "propietarios";

    // Propiedades de la clase
    public $id;
    public $nombre;
    public $apellido;
    public $telefono;
    public $documentacion;
    public $tipo_propietario;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Método para registrar un propietario
    public function registrar()
    {
        // Verificar si la documentación ya existe
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE documentacion = :documentacion";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":documentacion", $this->documentacion);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['count'] > 0) {
            // La documentación ya existe, retornar false
            return false;
        }

        // Insertar el nuevo propietario
        $query = "INSERT INTO " . $this->table_name . " 
        (nombre, apellido, telefono, documentacion, tipo_propietario) 
        VALUES (:nombre, :apellido, :telefono, :documentacion, :tipo_propietario)";

        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->documentacion = htmlspecialchars(strip_tags($this->documentacion));
        $this->tipo_propietario = htmlspecialchars(strip_tags($this->tipo_propietario));

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":documentacion", $this->documentacion);
        $stmt->bindParam(":tipo_propietario", $this->tipo_propietario);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para leer todos los propietarios
    public function leer()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Método para actualizar un propietario
    public function actualizar()
    {
        $query = "UPDATE " . $this->table_name . "
        SET nombre = :nombre, apellido = :apellido, telefono = :telefono, documentacion = :documentacion, tipo_propietario = :tipo_propietario
        WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->documentacion = htmlspecialchars(strip_tags($this->documentacion));
        $this->tipo_propietario = htmlspecialchars(strip_tags($this->tipo_propietario));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":documentacion", $this->documentacion);
        $stmt->bindParam(":tipo_propietario", $this->tipo_propietario);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para eliminar un propietario
    public function eliminar($id)
    {
        // Eliminar registros relacionados en la tabla propietario_automovil
        $query = "DELETE FROM propietario_automovil WHERE documentacion = (SELECT documentacion FROM " . $this->table_name . " WHERE id = :id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        // Eliminar el propietario
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>