<?php include('../templates/header.php'); ?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 mt-5 mb-0">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">Agregar Propietario</h2>
                </div>
                <div class="card-body">
                    <!-- Vertical Form -->
                    <form class="row g-3" action="procesar_registro_propietario.php" method="post">
                        <div class="col-12">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingrese el nombre" required>
                        </div>
                        <div class="col-12">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" id="apellido" name="apellido" class="form-control" placeholder="Ingrese el apellido" required>
                        </div>
                        <div class="col-12">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Ingrese el teléfono" required>
                        </div>
                        <div class="col-12">
                            <label for="tipo_propietario" class="form-label">Tipo de Propietario</label>
                            <select class="form-select" id="tipo_propietario" name="tipo_propietario" required>
                                <option selected disabled value="">Seleccione el tipo de propietario</option>
                                <option value="natural">Natural</option>
                                <option value="juridico">Jurídico</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="documentacion" class="form-label">Documentación</label>
                            <input type="text" id="documentacion" name="documentacion" class="form-control" placeholder="Ingrese la documentación" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button type="reset" class="btn btn-danger">Reset</button>
                            <a href="tabla_Propietarios.php" class="btn btn-secondary">Volver</a>
                        </div>
                    </form>
                    <!-- Vertical Form -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../templates/footer.php'); ?>