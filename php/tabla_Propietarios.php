<?php
ob_start();  // Inicia el almacenamiento en el buffer de salida
include '../templates/header.php';
include '../includes/Database.php';
include '../includes/Propietario.php';

$database = new Database();
$db = $database->getConnection();

$propietario = new Propietario($db);
$stmt = $propietario->leer();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Consulta JOIN para obtener los datos de los propietarios y sus automóviles
$query = "
    SELECT 
        p.id,
        p.nombre, 
        p.apellido, 
        p.documentacion, 
        a.placa 
    FROM 
        propietario_automovil pa
    JOIN 
        propietarios p ON pa.documentacion = p.documentacion
    JOIN 
        automoviles a ON pa.placa = a.placa
";
$stmt = $db->prepare($query);
$stmt->execute();
$clientes_automoviles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link " href="../index.html">
        <i class="bi bi-grid"></i>
        <span>Inicio</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-layout-text-window-reverse"></i><span>Tablas</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="tabla_Automoviles.php">
            <i class="bi bi-circle"></i><span>Automoviles</span>
          </a>
        </li>
        <li>
          <a href="tabla_Propietarios.php">
            <i class="bi bi-circle"></i><span>Propietarios</span>
          </a>
        </li>
      </ul>
    </li>
    <!-- End Tables Nav -->
  </ul>

</aside>
<!-- End Sidebar-->

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Tabla Propietarios</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Inicio</a></li>
        <li class="breadcrumb-item">Tablas</li>
        <li class="breadcrumb-item active">Propietarios</li>
      </ol>
    </nav>
  </div>
  <!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Clientes</h5>
            <div class="d-flex justify-content-end mb-3">
              <a href="agregar_Propietario.php" class="btn btn-primary">Agregar Propietario</a>
            </div>
            <!-- Table with stripped rows -->
            <table class="table datatable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Apellido</th>
                  <th>Telefono</th>
                  <th>Tipo de Propietarios</th>
                  <th>Documentación</th>
                  <th>Acción</th>
                </tr>
              </thead>
              <tbody id="tabla-propietarios">
                <?php foreach ($result as $row): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($row["id"]); ?></td>
                    <td><?php echo htmlspecialchars($row["nombre"]); ?></td>
                    <td><?php echo htmlspecialchars($row["apellido"]); ?></td>
                    <td><?php echo htmlspecialchars($row["telefono"]); ?></td>
                    <td><?php echo htmlspecialchars($row["tipo_propietario"]); ?></td>
                    <td><?php echo htmlspecialchars($row["documentacion"]); ?></td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                          data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <li>
                            <a class="dropdown-item text-primary"
                              href="editar_Propietario.php?id=<?php echo $row['id']; ?>">Modificar</a>
                          </li>
                          <li>
                            <form action="eliminar_Propietario.php" method="post" class="eliminar-propietario-form"
                              data-id="<?php echo htmlspecialchars($row['id']); ?>">
                              <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                              <button type="submit" class="dropdown-item text-danger">Eliminar</button>
                            </form>
                          </li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            <!-- End Table with stripped rows -->

          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Clientes y sus automoviles</h5>
            <!-- Table with stripped rows -->
            <table class="table datatable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Apellido</th>
                  <th>Documentación</th>
                  <th>Placa</th>
                </tr>
              </thead>
              <tbody id="tabla-clientes-automoviles">
                <?php foreach ($clientes_automoviles as $row): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($row["id"]); ?></td>
                    <td><?php echo htmlspecialchars($row["nombre"]); ?></td>
                    <td><?php echo htmlspecialchars($row["apellido"]); ?></td>
                    <td><?php echo htmlspecialchars($row["documentacion"]); ?></td>
                    <td><?php echo htmlspecialchars($row["placa"]); ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            <!-- End Table with stripped rows -->

          </div>
        </div>
      </div>
    </div>
  </section>

</main>
<!-- End #main -->

<!-- ======= Footer ======= -->
<?php
ob_end_flush();
include '../templates/footer.php';
?>