<?php include('../templates/header.php'); ?>
<?php
include '../includes/Database.php';
include '../includes/Automovil.php';

$database = new Database();
$db = $database->getConnection();

$automovil = new Automovil($db);

// Obtener los datos del formulario
$automovil->marca_id = $_POST['marca'];
$automovil->modelo_id = $_POST['modelo'];
$automovil->tipo_vehiculo_id = $_POST['tipo_vehiculo'];
$automovil->anio = $_POST['anio'];
$automovil->color = $_POST['color'];

// Registrar el automóvil
if ($automovil->registrar()) {
    // Mensaje de redirección y redirección con contador de segundos
    echo "<div style='position: fixed; top: 0; left: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; background-color: rgba(255, 255, 255, 1); z-index: 9999;'>
            <h1>Automóvil registrado exitosamente. Redirigiendo en <span id='contador'>5</span> segundos...</h1>
          </div>";

    echo "<script>
        // Tiempo inicial en segundos
        var tiempoRestante = 5;

        // Actualizar el contador cada segundo
        var intervalo = setInterval(function() {
            tiempoRestante--;
            document.getElementById('contador').innerText = tiempoRestante;

            // Cuando el tiempo se acaba, redirigir
            if (tiempoRestante <= 0) {
                clearInterval(intervalo);
                window.location.href = 'tabla_automovil.php';
            }
        }, 1000); // 1000 ms = 1 segundo
    </script>";
} else {
    echo "<div style='position: fixed; top: 0; left: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; background-color: rgba(255, 255, 255, 1); z-index: 9999;'>
            <h1>Error al registrar el automóvil. Por favor, inténtelo nuevamente.</h1>
          </div>";
}
?>
<?php include('../templates/footer.php'); ?>
