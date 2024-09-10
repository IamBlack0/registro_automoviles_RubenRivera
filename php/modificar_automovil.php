<?php
ob_start();  // Inicia el almacenamiento en el buffer de salida
include '../templates/header.php';
include '../includes/Database.php';
include '../includes/Automovil.php';

$database = new Database();
$db = $database->getConnection();

$limite = isset($_GET['limite']) ? intval($_GET['limite']) : 5; // Default a 5 si no se selecciona nada
$pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$offset = ($pagina - 1) * $limite;
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

// Modificar la consulta principal para incluir el límite, offset y búsqueda
$sql = "SELECT a.id, a.placa, m.nombre AS marca, mo.nombre AS modelo, a.ano, a.color, a.numero_motor, a.numero_chasis, tv.nombre AS tipo_vehiculo
        FROM automoviles a
        LEFT JOIN marcas m ON a.marca_id = m.id
        LEFT JOIN modelos mo ON a.modelo_id = mo.id
        LEFT JOIN tipos_vehiculo tv ON a.tipo_vehiculo_id = tv.id
        WHERE a.placa LIKE :busqueda
        LIMIT $limite OFFSET $offset";

$stmt = $db->prepare($sql);
$stmt->bindValue(':busqueda', "%$busqueda%");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener el total de registros filtrados
$sql_count = "SELECT COUNT(*) AS total FROM automoviles WHERE placa LIKE :busqueda";
$stmt_count = $db->prepare($sql_count);
$stmt_count->bindValue(':busqueda', "%$busqueda%");
$stmt_count->execute();
$total_registros = $stmt_count->fetch(PDO::FETCH_ASSOC)['total'];

$total_paginas = ceil($total_registros / $limite);

function eliminarAutomovil($id) {
    global $db; 
    $automovil = new Automovil($db);
    return $automovil->eliminar($id);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    if (eliminarAutomovil($id)) {
        header("Location: modificar_automovil.php");
        exit();
    } else {
        echo "Error al eliminar el automóvil.";
    }
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
        <h2 class="h4">Inventario</h2>
        <p class="mb-0">Panel de control del inventario</p>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="registrar_automovil.php" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
            Agregar automóvil
        </a>
    </div>
</div>

<div class="table-settings mb-4">
    <div class="row align-items-center justify-content-between">
        <div class="col col-md-6 col-lg-3 col-xl-4">
            <div class="input-group me-2 me-lg-3 fmxw-400">
                <span class="input-group-text">
                    <svg class="icon icon-xs" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </span>
                <input type="text" id="buscador" class="form-control" placeholder="Buscar por placa" value="<?php echo htmlspecialchars($busqueda); ?>">
            </div>
        </div>
        <div class="col-4 col-md-2 col-xl-1 ps-md-0 text-end">
            <div class="dropdown">
                <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
                </button>
                <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end pb-0">
                    <a class="dropdown-item d-flex align-items-center fw-bold" href="?limite=5&busqueda=<?php echo urlencode($busqueda); ?>">5</a>
                    <a class="dropdown-item d-flex align-items-center fw-bold" href="?limite=10&busqueda=<?php echo urlencode($busqueda); ?>">10</a>
                    <a class="dropdown-item d-flex align-items-center fw-bold" href="?limite=20&busqueda=<?php echo urlencode($busqueda); ?>">20</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card card-body border-0 shadow table-wrapper table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Placa</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Año</th>
                <th>Color</th>
                <th>Número de motor</th>
                <th>Número de chasis</th>
                <th>Tipo de vehículo</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody id="tabla-automoviles">
            <?php foreach($result as $row): ?>
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
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                Acciones
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <a class="dropdown-item text-primary" href="actualizar_automovil.php?id=<?php echo $row['id']; ?>">Modificar</a>
                                </li>
                                <li>
                                    <form action="" method="post" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este automóvil?');">
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
    <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
        <nav aria-label="Page navigation example">
            <ul class="pagination mb-0">
                <?php if ($pagina > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?pagina=<?php echo $pagina - 1; ?>&limite=<?php echo $limite; ?>&busqueda=<?php echo urlencode($busqueda); ?>">Previous</a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <a class="page-link">Anterior</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                    <li class="page-item <?php echo ($i == $pagina) ? 'active' : ''; ?>">
                        <a class="page-link" href="?pagina=<?php echo $i; ?>&limite=<?php echo $limite; ?>&busqueda=<?php echo urlencode($busqueda); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($pagina < $total_paginas): ?>
                    <li class="page-item">
                        <a class="page-link" href="?pagina=<?php echo $pagina + 1; ?>&limite=<?php echo $limite; ?>&busqueda=<?php echo urlencode($busqueda); ?>">Next</a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <a class="page-link">Siguiente</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <div class="fw-normal small mt-4 mt-lg-0">
            Mostrando <b><?php echo $limite; ?></b> de <b><?php echo $total_registros; ?></b> entradas
        </div>
    </div>
</div>

<script>
document.getElementById('buscador').addEventListener('keyup', function() {
    var input = this.value;
    window.location.href = '?busqueda=' + encodeURIComponent(input) + '&limite=<?php echo $limite; ?>';
});
</script>

<?php
ob_end_flush(); 
include '../templates/footer.php'; ?>
