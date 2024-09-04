<?php
include 'templates/header.php';
include 'includes/Database.php';
include 'includes/Automovil.php';

$database = new Database();
$db = $database->getConnection();

$id = $_GET['id'];
$sql = "SELECT * FROM automoviles WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

$automovil = $stmt->fetch(PDO::FETCH_ASSOC);

if ($automovil) {
    // Crear una instancia de Automovil
    $automovil_obj = new Automovil($db);
    
    // Rellenar los valores del objeto
    $automovil_obj->id = $automovil['id'];
    $automovil_obj->marca = $automovil['marca'];
    $automovil_obj->modelo = $automovil['modelo'];
    $automovil_obj->anio = $automovil['anio'];
    $automovil_obj->color = $automovil['color'];


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $anio = $_POST['anio'];
        $color = $_POST['color'];
    
        $automovil_obj = new Automovil($db);
        $automovil_obj->id = $id;
        $automovil_obj->marca = $marca;
        $automovil_obj->modelo = $modelo;
        $automovil_obj->anio = $anio;
        $automovil_obj->color = $color;
    
        if ($automovil_obj->actualizar()) {
            header("Location: modificar_automovil.php");
            exit();
        } else {
            echo "<script>alert('Error al actualizar el automóvil');</script>";
        }
    }
    // Mostrar formulario prellenado con los datos actuales del automóvil
    
?>
<div class="container">
    <h2 class="form-update">Modificar Automóvil</h2>

    <form action="" method="post" class="update-form">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($automovil["id"]); ?>">
        
        <label for="marca">Marca:</label>
        <input type="text" id="marca" name="marca" value="<?php echo htmlspecialchars($automovil_obj->marca); ?>">

        <label for="modelo">Modelo:</label>
        <input type="text" id="modelo" name="modelo" value="<?php echo htmlspecialchars($automovil_obj->modelo); ?>">

        <label for="anio">Año:</label>
        <input type="number" id="anio" name="anio" value="<?php echo htmlspecialchars($automovil_obj->anio); ?>">

        <label for="color">Color:</label>
        <input type="text" id="color" name="color" value="<?php echo htmlspecialchars($automovil_obj->color); ?>">

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>

<?php
} else {
    echo "Automóvil no encontrado.";
}

include 'templates/footer.php';
?>
