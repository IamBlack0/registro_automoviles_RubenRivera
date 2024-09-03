<?php include('templates/header.php'); ?>

    <div class="form-container">
        <h2 class="form-title">Registrar un nuevo vehículo</h2>
        <form action="procesar_registro.php" method="post">
           
                <div class="form-field">
                    <label for="marca">Marca</label>
                    <input type="text" id="marca" name="marca" required>
                </div>
                <div class="form-field">
                    <label for="modelo">Modelo</label>
                    <input type="text" id="modelo" name="modelo" required>
                </div>
         
                <div class="form-field">
                    <label for="anio">Año</label>
                    <input type="number" id="anio" name="anio" required>
                </div>
                <div class="form-field">
                    <label for="color">Color</label>
                    <input type="text" id="color" name="color" required>
                </div>
        
            <input type="submit" value="Guardar" class="submit-button">
        </form>
    </div>
    
    <?php include('templates/footer.php'); ?>