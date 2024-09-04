<?php
class Automovil {
    private $conn; // Conexión a la base de datos
    private $table_name = "automoviles"; // Nombre de la tabla

    // Propiedades de la clase
    public $id;
    public $marca;
    public $modelo;
    public $anio;
    public $color;
    public $placa;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

   // Método para generar una placa aleatoria
   private function generarPlacaAleatoria($longitud = 7) {
    $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $placa = '';
    for ($i = 0; $i < $longitud; $i++) {
        $placa .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
    return $placa;
}

// Método para verificar si una placa ya existe en la base de datos
private function placaExisteEnBaseDeDatos($placa) {
    $query = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE placa = :placa";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":placa", $placa);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    return $count > 0;
}

    // Método para registrar un nuevo automóvil
    public function registrar() {
        // Generar una placa única
        do {
            $this->placa = $this->generarPlacaAleatoria();
        } while ($this->placaExisteEnBaseDeDatos($this->placa));

        // Query para insertar un nuevo automóvil
        $query = "INSERT INTO " . $this->table_name . " (marca, modelo, anio, color, placa) 
                  VALUES (:marca, :modelo, :anio, :color, :placa)";
        // Preparar la declaración
        $stmt = $this->conn->prepare($query);

        // Limpiar los datos para evitar inyección SQL
        $this->marca = htmlspecialchars(strip_tags($this->marca));
        $this->modelo = htmlspecialchars(strip_tags($this->modelo));
        $this->anio = htmlspecialchars(strip_tags($this->anio));
        $this->color = htmlspecialchars(strip_tags($this->color));
        $this->placa = htmlspecialchars(strip_tags($this->placa));

        // Enlazar los parámetros
        $stmt->bindParam(":marca", $this->marca);
        $stmt->bindParam(":modelo", $this->modelo);
        $stmt->bindParam(":anio", $this->anio);
        $stmt->bindParam(":color", $this->color);
        $stmt->bindParam(":placa", $this->placa);

        // Ejecutar la declaración
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

 // Método para eliminar un automóvil
public function eliminar($id) {
    // Query para eliminar un automóvil
    $query = "DELETE FROM ". $this->table_name. " WHERE id = :id";
    // Preparar la declaración
    $stmt = $this->conn->prepare($query);

    // Limpiar los datos para evitar inyección SQL
    $this->id = htmlspecialchars(strip_tags($id));

    // Enlazar los parámetros
    $stmt->bindParam(":id", $this->id);

    // Ejecutar la declaración
    if ($stmt->execute()) {
        return true;
    }
    return false;
}

  // Método para actualizar un automóvil

  public function actualizar() {
    // Query para actualizar un automóvil
    $query = "UPDATE ". $this->table_name. "
              SET marca = :marca, modelo = :modelo, anio = :anio, color = :color
              WHERE id = :id";
              // Preparar la declaración
              $stmt = $this->conn->prepare($query);
              // Limpiar los datos para evitar inyección SQL
              $this->marca = htmlspecialchars(strip_tags($this->marca));
              $this->modelo = htmlspecialchars(strip_tags($this->modelo));
              $this->anio = htmlspecialchars(strip_tags($this->anio));
              $this->color = htmlspecialchars(strip_tags($this->color));
              $this->id = htmlspecialchars(strip_tags($this->id));
              // Enlazar los parámetros
              $stmt->bindParam(":marca", $this->marca);
              $stmt->bindParam(":modelo", $this->modelo);
              $stmt->bindParam(":anio", $this->anio);
              $stmt->bindParam(":color", $this->color);
              $stmt->bindParam(":id", $this->id);
              // Ejecutar la declaración
              if ($stmt->execute()) {
                  return true;
              }
              return false;
  }


}
?>
