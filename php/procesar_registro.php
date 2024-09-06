<?php include('../templates/header.php'); ?>
<?php
// Incluir archivos de conexión y clase Automovil
include '../includes\Database.php';
include '../includes\Automovil.php';

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$db = $database->getConnection();

// Crear una instancia de la clase Automovil
$automovil = new Automovil($db);

// Obtener los datos del formulario
$automovil->marca = $_POST['marca'];
$automovil->modelo = $_POST['modelo'];
$automovil->anio = $_POST['anio'];
$automovil->color = $_POST['color'];

// Registrar el automóvil
if ($automovil->registrar()) {
    echo "Automóvil registrado exitosamente.";
} else {
    echo "Error al registrar el automóvil.";
}
?>
 <a href="../index.php">VOLVER A INICIO</a>


<?php include('../templates/footer.php'); ?>
