<?php include('../templates/header.php'); ?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 mt-5 mb-0">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">Agregar Automóvil</h2>
                </div>
                <div class="card-body">
                    <!-- Vertical Form -->
                    <form class="row g-3" action="procesar_Registro_Automovil.php" method="post">
                        <div class="col-12">
                            <label for="marca" class="form-label">Marca</label>
                            <select class="form-select" id="marca" name="marca" required>
                                <option selected disabled value="">Seleccione una marca</option>
                                <?php
                                include '../includes/Database.php';
                                $database = new Database();
                                $db = $database->getConnection();

                                $query = "SELECT id, nombre FROM marcas";
                                $stmt = $db->prepare($query);
                                $stmt->execute();

                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="modelo" class="form-label">Modelo</label>
                            <select class="form-select" id="modelo" name="modelo" required>
                                <option selected disabled value="">Seleccione un modelo</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="tipo_vehiculo" class="form-label">Tipo de vehículo</label>
                            <select class="form-select" id="tipo_vehiculo" name="tipo_vehiculo" required>
                                <option selected disabled value="">Seleccione el tipo de vehículo</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="anio" class="form-label">Año</label>
                            <input type="number" id="anio" name="anio" class="form-control" placeholder="Ingrese el año del vehículo" required min="2000" max="2030">
                        </div>
                        <div class="col-12">
                            <label for="color" class="form-label">Color</label>
                            <input type="text" id="color" name="color" class="form-control" placeholder="Ingrese el color del vehículo" required>
                        </div>
                        <div class="col-12">
                            <label for="propietario" class="form-label">Propietario</label>
                            <select class="form-select" id="propietario" name="propietario" required>
                                <option selected disabled value="">Seleccione un propietario</option>
                                <?php
                                $query = "SELECT id, documentacion FROM propietarios";
                                $stmt = $db->prepare($query);
                                $stmt->execute();

                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['documentacion'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button type="reset" class="btn btn-danger">Reset</button>
                            <a href="tabla_Automoviles.php" class="btn btn-secondary">Volver</a>
                        </div>
                    </form>
                    <!-- Vertical Form -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('marca').addEventListener('change', function() {
    var marcaId = this.value;
    if (marcaId) {
        fetchModelos(marcaId);
    }
});

document.getElementById('modelo').addEventListener('change', function() {
    var modeloId = this.value;
    if (modeloId) {
        fetchTiposVehiculo(modeloId);
    }
});

document.getElementById('anio').addEventListener('input', function() {
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
    xhr.onload = function() {
        if (this.status == 200) {
            var modelos = JSON.parse(this.responseText);
            var modeloSelect = document.getElementById('modelo');
            modeloSelect.innerHTML = '<option selected disabled value="">Seleccione un modelo</option>';
            modelos.forEach(function(modelo) {
                var option = document.createElement('option');
                option.value = modelo.id;
                option.textContent = modelo.nombre;
                modeloSelect.appendChild(option);
            });
        }
    };
    xhr.send('marca_id=' + marcaId);
}

document.getElementById('modelo').addEventListener('change', function() {
    var modeloId = this.value;
    if (modeloId) {
        fetchTiposVehiculo(modeloId);
    }
});

function fetchTiposVehiculo(modeloId) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../ajax/obtener_tipos_vehiculo.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status == 200) {
            var tiposVehiculo = JSON.parse(this.responseText);
            var tipoVehiculoSelect = document.getElementById('tipo_vehiculo');
            tipoVehiculoSelect.innerHTML = '<option selected disabled value="">Seleccione el tipo de vehículo</option>';
            tiposVehiculo.forEach(function(tipoVehiculo) {
                var option = document.createElement('option');
                option.value = tipoVehiculo.id;
                option.textContent = tipoVehiculo.nombre;
                tipoVehiculoSelect.appendChild(option);
            });
        }
    };
    xhr.send('modelo_id=' + modeloId);
}

$(document).ready(function() {
    $('#propietario').select2({
        placeholder: "Seleccione un propietario",
        allowClear: true
    });
});
</script>

<?php include('../templates/footer.php'); ?>