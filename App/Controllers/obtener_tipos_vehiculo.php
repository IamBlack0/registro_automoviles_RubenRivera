<?php
include '../../Config/DataBase.php';

if (isset($_POST['modelo_id'])) {
    $modelo_id = $_POST['modelo_id'];

    $database = new Database();
    $db = $database->getConnection();

    $query = "SELECT tipos_vehiculo.id, tipos_vehiculo.nombre 
              FROM tipos_vehiculo 
              JOIN modelos ON tipos_vehiculo.id = modelos.tipo_vehiculo_id 
              WHERE modelos.id = :modelo_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':modelo_id', $modelo_id);
    $stmt->execute();

    $tipos_vehiculo = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($tipos_vehiculo);
}
?>