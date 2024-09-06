<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Automóviles</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<div class="header">
        <div class="logo">
            <a href="index.php"><span>SA</span></a>
        </div>
        <h1>Sistema de Gestión de Automóviles</h1>
    </div>

    <div class="container">
        <a href="php\registrar_automovil.php"class="button" >Registrar un nuevo automóvil</a>
        <a href="php\modificar_automovil.php" class="button">Actualizar informacion de automovil</a>
    </div>

    <div class="footer">
        © <?php echo date("Y"); ?> Sistema de Gestión de Automóviles. Ruben Rivera / 8-1003-856 / 1LS131
    </div>
</body>
</html>