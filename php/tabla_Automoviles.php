<?php
ob_start();  // Inicia el almacenamiento en el buffer de salida
include '../templates/header.php';
include '../includes/Database.php';
include '../includes/Automovil.php';

$database = new Database();
$db = $database->getConnection();
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

// Modificar la consulta principal para incluir el límite, offset y búsqueda
$sql = "SELECT a.id, a.placa, m.nombre AS marca, mo.nombre AS modelo, a.ano, a.color, a.numero_motor, a.numero_chasis, tv.nombre AS tipo_vehiculo
        FROM automoviles a
        LEFT JOIN marcas m ON a.marca_id = m.id
        LEFT JOIN modelos mo ON a.modelo_id = mo.id
        LEFT JOIN tipos_vehiculo tv ON a.tipo_vehiculo_id = tv.id
        WHERE a.placa LIKE :busqueda";

$stmt = $db->prepare($sql);
$stmt->bindValue(':busqueda', "%$busqueda%");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

function eliminarAutomovil($db, $id)
{
  $automovil = new Automovil($db);
  return $automovil->eliminar($id);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];
  eliminarAutomovil($db, $id);
}
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
    <h1>Tabla Automovil</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Inicio</a></li>
        <li class="breadcrumb-item">Tablas</li>
        <li class="breadcrumb-item active">Automoviles</li>
      </ol>
    </nav>
  </div>
  <!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <!-- Agregar un boton de agregar automovil -->

          <div class="card-body">
            <h5 class="card-title">Inventario</h5>
            <div class="d-flex justify-content-end mb-3">
              <!-- Botón de agregar automóvil alineado a la derecha -->
              <a href="agregar_Automovil.php" class="btn btn-primary">Agregar Automóvil</a>
            </div>

            <!-- Table with stripped rows -->
            <table class="table datatable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Placa</th>
                  <th>Marca</th>
                  <th>Modelo</th>
                  <th>Año</th>
                  <th>Color</th>
                  <th>Núm motor</th>
                  <th>Núm chasis</th>
                  <th>Tipo</th>
                  <th>Acción</th>
                </tr>
              </thead>
              <tbody id="tabla-automoviles">
                <?php foreach ($result as $row): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($row["id"]); ?></td>
                    <td><?php echo htmlspecialchars($row["placa"]); ?></td>
                    <td><?php echo htmlspecialchars($row["marca"]); ?></td>
                    <td><?php echo htmlspecialchars($row["modelo"]); ?></td>
                    <td><?php echo htmlspecialchars($row["ano"]); ?></td>
                    <td><?php echo htmlspecialchars($row["color"]); ?></td>
                    <td><?php echo htmlspecialchars($row["numero_motor"]); ?></td>
                    <td><?php echo htmlspecialchars($row["numero_chasis"]); ?></td>
                    <td><?php echo htmlspecialchars($row["tipo_vehiculo"]); ?></td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                          data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <li>
                            <a class="dropdown-item text-primary"
                              href="actualizar_automovil.php?id=<?php echo $row['id']; ?>">Modificar</a>
                          </li>
                          <li>
                            <form action="eliminar_automovil.php" method="post" class="eliminar-automovil-form"
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

      </div>
    </div>
  </section>

</main>
<!-- End #main -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.eliminar-automovil-form').forEach(function(form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            if (confirm('¿Estás seguro de que deseas eliminar este automóvil?')) {
                var formData = new FormData(form);
                var id = form.getAttribute('data-id');

                fetch('../ajax/eliminar_automovil.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Eliminar la fila de la tabla
                        var row = document.querySelector('form[data-id="' + id + '"]').closest('tr');
                        row.remove();
                    } else {
                        alert('Error al eliminar el automóvil.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al eliminar el automóvil.');
                });
            }
        });
    });
});
</script>

<!-- ======= Footer ======= -->
<?php
ob_end_flush();
include '../templates/footer.php'; ?>