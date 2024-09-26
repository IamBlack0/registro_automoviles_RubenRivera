<?php
// Verificar rutas
$databasePath = realpath('../../Config/DataBase.php');
$automovilPath = realpath('../Models/Automovil.php');

if (!$databasePath) {
    die('Error: No se encontró el archivo DataBase.php en la ruta especificada.');
}
if (!$automovilPath) {
    die('Error: No se encontró el archivo Automovil.php en la ruta especificada.');
}

include $databasePath;
include $automovilPath;

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