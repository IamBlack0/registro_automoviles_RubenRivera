$(document).ready(function() {
    var editor = new $.fn.dataTable.Editor({
        ajax: "php/tabla_Automoviles.php",
        table: "#tabla-automoviles",
        fields: [
            { label: "Placa", name: "placa" },
            { label: "Marca", name: "marca" },
            { label: "Modelo", name: "modelo" },
            { label: "Año", name: "ano" },
            { label: "Color", name: "color" },
            { label: "Número de motor", name: "numero_motor" },
            { label: "Número de chasis", name: "numero_chasis" },
            { label: "Tipo de vehículo", name: "tipo_vehiculo" }
        ]
    });

    $('#tabla-automoviles').DataTable({
        dom: "Bfrtip",
        ajax: "php/tabla_Automoviles.php",
        columns: [
            { data: "id" },
            { data: "placa" },
            { data: "marca" },
            { data: "modelo" },
            { data: "ano" },
            { data: "color" },
            { data: "numero_motor" },
            { data: "numero_chasis" },
            { data: "tipo_vehiculo" },
            {
                data: null,
                defaultContent: '<button class="editor-edit btn btn-primary btn-sm">Editar</button> <button class="editor-remove btn btn-danger btn-sm">Eliminar</button>',
                className: 'dt-center',
                orderable: false
            }
        ],
        select: true,
        buttons: [
            { extend: "create", editor: editor, text: 'Crear' },
            { extend: "edit", editor: editor, text: 'Editar' },
            { extend: "remove", editor: editor, text: 'Eliminar' }
        ]
    });

    $('#tabla-automoviles').on('click', 'button.editor-edit', function (e) {
        e.preventDefault();
        editor.edit($(this).closest('tr'), {
            title: 'Editar registro',
            buttons: 'Actualizar'
        });
    });

    $('#tabla-automoviles').on('click', 'button.editor-remove', function (e) {
        e.preventDefault();
        editor.remove($(this).closest('tr'), {
            title: 'Eliminar registro',
            message: '¿Estás seguro de que deseas eliminar este registro?',
            buttons: 'Eliminar'
        });
    });
});