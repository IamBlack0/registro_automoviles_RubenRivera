<?php
include 'templates/header.php';
include 'includes/Database.php';
include 'includes/Automovil.php';

$database = new Database();
$db = $database->getConnection();
$sql = "SELECT * FROM automoviles";
$result = $db->query($sql);

function eliminarAutomovil($id) {
    global $db; // Declaramos explícitamente que db es una variable global
    $automovil = new Automovil($db);
    return $automovil->eliminar($id);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    if (eliminarAutomovil($id)) {
        header("Location: eliminar_automovil.php");
        exit();
    } else {
        echo "Error al eliminar el automóvil.";
    }
}
?>

<div class="container">
    <h2 class="form-title">Eliminar Automóvil</h2>

<?php if ($result->rowCount() > 0): ?>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th><th>Marca</th><th>Modelo</th><th>Año</th><th>Color</th><th>Placa</th><th>Acción</th>
            </tr>
        </thead>
        <tbody>
<?php while($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row["id"]); ?></td>
                <td><?php echo htmlspecialchars($row["marca"]); ?></td>
                <td><?php echo htmlspecialchars($row["modelo"]); ?></td>
                <td><?php echo htmlspecialchars($row["anio"]); ?></td>
                <td><?php echo htmlspecialchars($row["color"]); ?></td>
                <td><?php echo htmlspecialchars($row["placa"]); ?></td>
                <td>
                    <form action="" method="post" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este automóvil?');">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row["id"]); ?>">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
<?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No hay automóviles registrados.</p>
<?php endif; ?>

<a href="index.php" class="button">Volver al inicio</a>
</div>

<?php include 'templates/footer.php'; ?>