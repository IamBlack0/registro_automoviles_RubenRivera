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
        header("Location: modificar_automovil.php");
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
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="marca">Marca</label>
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

                        <div class="form-group">
                            <label for="modelo">Modelo</label>
                            <select class="form-select" id="modelo" name="modelo" required>
                                <option disabled value="">Seleccione un modelo</option>
                                <?php
                                $query = "SELECT id, nombre FROM modelos";
                                $stmt = $db->prepare($query);
                                $stmt->execute();
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = $row['id'] == $automovil['modelo_id'] ? 'selected' : '';
                                    echo "<option value='" . $row['id'] . "' $selected>" . $row['nombre'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tipo_vehiculo">Tipo de vehículo</label>
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

                        <div class="form-group">
                            <label for="anio">Año</label>
                            <input type="number" id="anio" name="anio" class="form-control" value="<?php echo htmlspecialchars($automovil['ano']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="color">Color</label>
                            <input type="text" id="color" name="color" class="form-control" value="<?php echo htmlspecialchars($automovil['color']); ?>" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-3">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
ob_end_flush(); 
include '../templates/footer.php';
?>
