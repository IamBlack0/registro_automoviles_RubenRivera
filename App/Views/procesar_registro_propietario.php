<?php
session_start(); // Iniciar la sesión

// Verificar rutas
$databasePath = realpath('../../Config/DataBase.php');
$propietarioPath = realpath('../Models/Propietario.php');

if (!$databasePath) {
    die('Error: No se encontró el archivo DataBase.php en la ruta especificada.');
}
if (!$propietarioPath) {
    die('Error: No se encontró el archivo propietario.php en la ruta especificada.');
}

include $databasePath;
include $propietarioPath;

$database = new Database();
$db = $database->getConnection();

$propietario = new Propietario($db);

$propietario->nombre = $_POST['nombre'];
$propietario->apellido = $_POST['apellido'];
$propietario->telefono = $_POST['telefono'];
$propietario->documentacion = $_POST['documentacion'];
$propietario->tipo_propietario = $_POST['tipo_propietario'];

if ($propietario->registrar()) {
    $_SESSION['mensaje'] = "Propietario registrado exitosamente.";
    $_SESSION['tipo_mensaje'] = "success";
} else {
    $_SESSION['mensaje'] = "Error: La documentación ya existe. Por favor, inténtelo nuevamente.";
    $_SESSION['tipo_mensaje'] = "danger";
}

header("Location: agregar_Propietario.php");
exit();
?>