<?php
// Verificar rutas
$databasePath = realpath('../../Config/DataBase.php');
$propietarioPath = realpath('../Models/Propietario.php');

if (!$databasePath) {
    die('Error: No se encontró el archivo DataBase.php en la ruta especificada.');
}
if (!$propietarioPath) {
    die('Error: No se encontró el archivo Propietario.php en la ruta especificada.');
}

include $databasePath;
include $propietarioPath;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $database = new Database();
    $db = $database->getConnection();
    $propietario = new Propietario($db);

    if ($propietario->eliminar($id)) {
        // Eliminar registros relacionados en la tabla propietario_automovil
        $query = "DELETE FROM propietario_automovil WHERE documentacion = (SELECT documentacion FROM propietarios WHERE id = :id)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>