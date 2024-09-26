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

$database = new Database();
$db = $database->getConnection();

// Obtener los datos del formulario
$marca_id = $_POST['marca'];
$modelo_id = $_POST['modelo'];
$tipo_vehiculo_id = $_POST['tipo_vehiculo'];
$anio = $_POST['anio'];
$color = $_POST['color'];
$propietario_id = $_POST['propietario'];

// Crear una instancia de la clase Automovil
$automovil = new Automovil($db);
$automovil->marca_id = $marca_id;
$automovil->modelo_id = $modelo_id;
$automovil->tipo_vehiculo_id = $tipo_vehiculo_id;
$automovil->anio = $anio;
$automovil->color = $color;

// Registrar el automóvil y generar la placa automáticamente
if ($automovil->registrar()) {
    // Obtener el ID del automóvil insertado
    $automovil_id = $db->lastInsertId();

    // Obtener la documentación del propietario
    $query = "SELECT documentacion FROM propietarios WHERE id = :propietario_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':propietario_id', $propietario_id);
    $stmt->execute();
    $propietario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Insertar en la tabla propietario_automovil
    $query = "INSERT INTO propietario_automovil (documentacion, placa) VALUES (:documentacion, :placa)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':documentacion', $propietario['documentacion']);
    $stmt->bindParam(':placa', $automovil->placa);

    if ($stmt->execute()) {
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
                    window.location.href = 'tabla_Automoviles.php';
                }
            }, 1000); // 1000 ms = 1 segundo
        </script>";
    } else {
        echo "<div style='position: fixed; top: 0; left: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; background-color: rgba(255, 255, 255, 1); z-index: 9999;'>
                <h1>Error al registrar el propietario del automóvil. Por favor, inténtelo nuevamente.</h1>
              </div>";
    }
} else {
    echo "<div style='position: fixed; top: 0; left: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; background-color: rgba(255, 255, 255, 1); z-index: 9999;'>
            <h1>Error al registrar el automóvil. Por favor, inténtelo nuevamente.</h1>
          </div>";
}
?>