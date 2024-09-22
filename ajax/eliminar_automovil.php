<?php
include '../includes/Database.php';
include '../includes/Automovil.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $database = new Database();
    $db = $database->getConnection();
    $automovil = new Automovil($db);

    if ($automovil->eliminar($id)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>