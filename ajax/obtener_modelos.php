<?php
include '../includes/Database.php';

if (isset($_POST['marca_id'])) {
    $marca_id = $_POST['marca_id'];

    $database = new Database();
    $db = $database->getConnection();

    $query = "SELECT id, nombre FROM modelos WHERE marca_id = :marca_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':marca_id', $marca_id);
    $stmt->execute();

    $modelos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($modelos);
}
?>