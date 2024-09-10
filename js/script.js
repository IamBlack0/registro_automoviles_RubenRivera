document.getElementById('buscador').addEventListener('keyup', function() {
    var input = this.value.toLowerCase();
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "buscar_automovil.php?q=" + input, true); 
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById('tabla-automoviles').innerHTML = xhr.responseText;
        }
    };
    xhr.send();
});



    document.getElementById('marca').addEventListener('change', function() {
        let marcaId = this.value;
    
        fetch('obtener_modelos.php?marca_id=' + marcaId)
            .then(response => response.json())
            .then(data => {
                let modeloSelect = document.getElementById('modelo');
                modeloSelect.innerHTML = '<option selected>Seleccione un modelo</option>';
    
                data.forEach(function(modelo) {
                    let option = document.createElement('option');
                    option.value = modelo.id;
                    option.textContent = modelo.nombre;
                    modeloSelect.appendChild(option);
                });
            });
    });
    

