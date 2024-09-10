<?php
class Automovil {
    private $conn; // Conexión a la base de datos
    private $table_name = "automoviles"; 

    // Propiedades de la clase
    public $id;
    public $marca_id;
    public $modelo_id;
    public $tipo_vehiculo_id;
    public $marca;
    public $modelo;
    public $anio;
    public $color;
    public $placa;

    public $numero_motor;
    public $numero_chasis;


    // Constructor que recibe la conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

   // Método para generar una placa aleatoria// Método para generar la siguiente placa secuencial
private function generarPlacaSecuencial() {
    $query = "SELECT placa FROM " . $this->table_name . " ORDER BY placa DESC LIMIT 1";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $lastPlate = $stmt->fetchColumn();
    if ($lastPlate) {
        $prefix = substr($lastPlate, 0, 2); 
        $number = substr($lastPlate, 2);   
        $number = str_pad((int)$number + 1, 4, '0', STR_PAD_LEFT);
        return $prefix . $number;
    } else {
        return 'AA0000';
    }
}

  // Método para generar un número aleatorio de chasis (17 caracteres)
  private function generarNumeroChasis() {
    return $this->generarCodigoAleatorio(17);
}

// Método para generar un número aleatorio de motor (10 caracteres)
private function generarNumeroMotor() {
    return $this->generarCodigoAleatorio(10);
}

// Método auxiliar para generar un código alfanumérico de longitud especificada
private function generarCodigoAleatorio($longitud) {
    $caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $codigo = '';
    for ($i = 0; $i < $longitud; $i++) {
        $codigo .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
    return $codigo;
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

public function registrar() {

    $this->numero_chasis = $this->generarNumeroChasis();
        $this->numero_motor = $this->generarNumeroMotor();
    do {
        $this->placa = $this->generarPlacaSecuencial();
    } while ($this->placaExisteEnBaseDeDatos($this->placa));

    $query = "INSERT INTO " . $this->table_name . " 
    (marca_id, modelo_id, tipo_vehiculo_id, ano, color, placa, numero_motor, numero_chasis) 
    VALUES (:marca_id, :modelo_id, :tipo_vehiculo_id, :ano, :color, :placa, :numero_motor, :numero_chasis)";
    
    $stmt = $this->conn->prepare($query);

    $this->marca_id = htmlspecialchars(strip_tags($this->marca_id));
    $this->modelo_id = htmlspecialchars(strip_tags($this->modelo_id));
    $this->tipo_vehiculo_id = htmlspecialchars(strip_tags($this->tipo_vehiculo_id));
    $this->anio = htmlspecialchars(strip_tags($this->anio));
    $this->color = htmlspecialchars(strip_tags($this->color));
    $this->placa = htmlspecialchars(strip_tags($this->placa));
    $this->numero_motor = htmlspecialchars(strip_tags($this->numero_motor));
    $this->numero_chasis = htmlspecialchars(strip_tags($this->numero_chasis));

    $stmt->bindParam(":marca_id", $this->marca_id);
    $stmt->bindParam(":modelo_id", $this->modelo_id);
    $stmt->bindParam(":tipo_vehiculo_id", $this->tipo_vehiculo_id);
    $stmt->bindParam(":ano", $this->anio);
    $stmt->bindParam(":color", $this->color);
    $stmt->bindParam(":placa", $this->placa);
    $stmt->bindParam(":numero_motor", $this->numero_motor);
    $stmt->bindParam(":numero_chasis", $this->numero_chasis);

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
    $query = "UPDATE ". $this->table_name. "
          SET marca_id = :marca_id, modelo_id = :modelo_id, tipo_vehiculo_id = :tipo_vehiculo_id, ano = :ano, color = :color
          WHERE id = :id";

    $stmt = $this->conn->prepare($query);

    $this->marca_id = htmlspecialchars(strip_tags($this->marca_id));
    $this->modelo_id = htmlspecialchars(strip_tags($this->modelo_id));
    $this->tipo_vehiculo_id = htmlspecialchars(strip_tags($this->tipo_vehiculo_id));
    $this->anio = htmlspecialchars(strip_tags($this->anio));
    $this->color = htmlspecialchars(strip_tags($this->color));
    $this->id = htmlspecialchars(strip_tags($this->id));

    $stmt->bindParam(":marca_id", $this->marca_id);
    $stmt->bindParam(":modelo_id", $this->modelo_id);
    $stmt->bindParam(":tipo_vehiculo_id", $this->tipo_vehiculo_id);
    $stmt->bindParam(":ano", $this->anio);
    $stmt->bindParam(":color", $this->color);
    $stmt->bindParam(":id", $this->id);

    if ($stmt->execute()) {
        return true;
    }
    return false;
}
}
?>
