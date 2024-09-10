<?php include('../templates/header.php'); ?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 mt-5 mb-0">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">Agregar Automóvil</h2>
                </div>
                <div class="card-body">
                    <form action="procesar_registro.php" method="post">
                        <div class="form-group">
                            <label for="marca">Marca</label>
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

                        <div class="form-group">
                            <label for="modelo">Modelo</label>
                            <select class="form-select" id="modelo" name="modelo" required>
                                <option selected disabled value="">Seleccione un modelo</option>
                                <?php
                                $query = "SELECT id, nombre FROM modelos";
                                $stmt = $db->prepare($query);
                                $stmt->execute();

                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tipo_vehiculo">Tipo de vehículo</label>
                            <select class="form-select" id="tipo_vehiculo" name="tipo_vehiculo" required>
                                <option selected disabled value="">Seleccione el tipo de vehículo</option>
                                <?php
                                $query = "SELECT id, nombre FROM tipos_vehiculo";
                                $stmt = $db->prepare($query);
                                $stmt->execute();

                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="anio">Año</label>
                            <input type="number" id="anio" name="anio" class="form-control" placeholder="Ingrese el año del vehículo" required>
                        </div>

                        <div class="form-group">
                            <label for="color">Color</label>
                            <input type="text" id="color" name="color" class="form-control" placeholder="Ingrese el color del vehículo" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-3">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




    
<?php include('../templates/footer.php'); ?>