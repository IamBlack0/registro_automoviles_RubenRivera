<?php
ob_start();  // Inicia el almacenamiento en el buffer de salida
include '../templates/header.php';
include '../includes/Database.php';
include '../includes/Automovil.php';

$database = new Database();
$db = $database->getConnection();

$id = $_GET['id'];
$sql = "SELECT * FROM automoviles WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

$automovil = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$automovil) {
    echo "Automóvil no encontrado";
    exit;
}

// Procesar el formulario al hacer submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $marca_id = $_POST['marca'];
    $modelo_id = $_POST['modelo'];
    $tipo_vehiculo_id = $_POST['tipo_vehiculo'];
    $anio = $_POST['anio'];
    $color = $_POST['color'];

    $automovil_obj = new Automovil($db);
    $automovil_obj->id = $id;
    $automovil_obj->marca_id = $marca_id;
    $automovil_obj->modelo_id = $modelo_id;
    $automovil_obj->tipo_vehiculo_id = $tipo_vehiculo_id;
    $automovil_obj->anio = $anio;
    $automovil_obj->color = $color;

    if ($automovil_obj->actualizar()) {
        header("Location: tabla_Automoviles.php");
        exit();
    } else {
        echo "<script>alert('Error al actualizar el automóvil');</script>";
    }
}
?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 mt-5 mb-0">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">Modificar Automóvil</h2>
                </div>
                <div class="card-body">
                    <form class="row g-3" action="" method="post">
                        <div class="col-12">
                            <label for="marca" class="form-label">Marca</label>
                            <select class="form-select" id="marca" name="marca" required>
                                <option disabled value="">Seleccione una marca</option>
                                <?php
                                $query = "SELECT id, nombre FROM marcas";
                                $stmt = $db->prepare($query);
                                $stmt->execute();
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = $row['id'] == $automovil['marca_id'] ? 'selected' : '';
                                    echo "<option value='" . $row['id'] . "' $selected>" . $row['nombre'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="modelo" class="form-label">Modelo</label>
                            <select class="form-select" id="modelo" name="modelo" required>
                                <option disabled value="">Seleccione un modelo</option>
                                <?php
                                $query = "SELECT id, nombre FROM modelos WHERE marca_id = :marca_id";
                                $stmt = $db->prepare($query);
                                $stmt->bindParam(':marca_id', $automovil['marca_id']);
                                $stmt->execute();
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = $row['id'] == $automovil['modelo_id'] ? 'selected' : '';
                                    echo "<option value='" . $row['id'] . "' $selected>" . $row['nombre'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="tipo_vehiculo" class="form-label">Tipo de vehículo</label>
                            <select class="form-select" id="tipo_vehiculo" name="tipo_vehiculo" required>
                                <option disabled value="">Seleccione el tipo de vehículo</option>
                                <?php
                                $query = "SELECT id, nombre FROM tipos_vehiculo";
                                $stmt = $db->prepare($query);
                                $stmt->execute();
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = $row['id'] == $automovil['tipo_vehiculo_id'] ? 'selected' : '';
                                    echo "<option value='" . $row['id'] . "' $selected>" . $row['nombre'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="anio" class="form-label">Año</label>
                            <input type="number" id="anio" name="anio" class="form-control"
                                value="<?php echo htmlspecialchars($automovil['ano']); ?>" required min="2000"
                                max="2030">
                        </div>
                        <div class="col-12">
                            <label for="color" class="form-label">Color</label>
                            <input type="text" id="color" name="color" class="form-control"
                                value="<?php echo htmlspecialchars($automovil['color']); ?>" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                            <button type="reset" class="btn btn-danger">Reset</button>
                            <a href="tabla_Automoviles.php" class="btn btn-secondary">Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('marca').addEventListener('change', function () {
        var marcaId = this.value;
        if (marcaId) {
            fetchModelos(marcaId);
        }
    });

    document.getElementById('modelo').addEventListener('change', function () {
        var modeloId = this.value;
        if (modeloId) {
            fetchTiposVehiculo(modeloId);
        }
    });

    document.getElementById('anio').addEventListener('input', function () {
        var anio = this.value;
        if (anio < 2000 || anio > 2030) {
            alert('El año debe estar entre 2000 y 2030.');
            this.value = '';
        }
        if (anio < 0) {
            alert('El año no puede ser negativo.');
            this.value = '';
        }
    });

    function fetchModelos(marcaId) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../ajax/obtener_modelos.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (this.status == 200) {
                var modelos = JSON.parse(this.responseText);
                var modeloSelect = document.getElementById('modelo');
                modeloSelect.innerHTML = '<option selected disabled value="">Seleccione un modelo</option>';
                modelos.forEach(function (modelo) {
                    var option = document.createElement('option');
                    option.value = modelo.id;
                    option.textContent = modelo.nombre;
                    modeloSelect.appendChild(option);
                });
            }
        };
        xhr.send('marca_id=' + marcaId);
    }

    function fetchTiposVehiculo(modeloId) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../ajax/obtener_tipos_vehiculo.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (this.status == 200) {
                var tiposVehiculo = JSON.parse(this.responseText);
                var tipoVehiculoSelect = document.getElementById('tipo_vehiculo');
                tipoVehiculoSelect.innerHTML = '<option selected disabled value="">Seleccione el tipo de vehículo</option>';
                tiposVehiculo.forEach(function (tipoVehiculo) {
                    var option = document.createElement('option');
                    option.value = tipoVehiculo.id;
                    option.textContent = tipoVehiculo.nombre;
                    tipoVehiculoSelect.appendChild(option);
                });
            }
        };
        xhr.send('modelo_id=' + modeloId);
    }

    // Inicializar los modelos y tipos de vehículo al cargar la página
    document.addEventListener('DOMContentLoaded', function () {
        var marcaId = document.getElementById('marca').value;
        var modeloId = document.getElementById('modelo').value;
        if (marcaId) {
            fetchModelos(marcaId);
        }
        if (modeloId) {
            fetchTiposVehiculo(modeloId);
        }
    });
</script>

<?php
ob_end_flush();
include '../templates/footer.php';
?>