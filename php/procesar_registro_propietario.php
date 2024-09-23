<?php
include('../templates/header.php');
include '../includes/Database.php';
include '../includes/Propietario.php';

$database = new Database();
$db = $database->getConnection();

$propietario = new Propietario($db);

// Obtener los datos del formulario
$propietario->nombre = $_POST['nombre'];
$propietario->apellido = $_POST['apellido'];
$propietario->telefono = $_POST['telefono'];
$propietario->documentacion = $_POST['documentacion'];
$propietario->tipo_propietario = $_POST['tipo_propietario'];

// Registrar el propietario
if ($propietario->registrar()) {
    // Mensaje de redirección y redirección con contador de segundos
    echo "<div style='position: fixed; top: 0; left: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; background-color: rgba(255, 255, 255, 1); z-index: 9999;'>
            <h1>Propietario registrado exitosamente. Redirigiendo en <span id='contador'>5</span> segundos...</h1>
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
                window.location.href = 'tabla_propietarios.php';
            }
        }, 1000); // 1000 ms = 1 segundo
    </script>";
} else {
    echo "<div style='position: fixed; top: 0; left: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; background-color: rgba(255, 255, 255, 1); z-index: 9999;'>
            <h1>Error al registrar el propietario. Por favor, inténtelo nuevamente.</h1>
          </div>";
}

include('../templates/footer.php');
?>