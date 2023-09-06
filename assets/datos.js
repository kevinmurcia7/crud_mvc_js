// console.log("hola mundo");
var tabla;

function init() {

    $("#emplea_form").on("submit", function (e) {
        e.preventDefault(); // Previene el envío predeterminado del formulario
        // Verifica qué botón se hizo clic
        if ($("#btn_nuevo").is(":focus")) {
            validar_form(e);
            //guardar(e); // Ejecuta la función guardar
        } else if ($("#btn_update").is(":focus")) {
            // Ejecuta la función actualizar
            update(e);
        }
    });

}

$(document).ready(function () {
    tabla = $('#tabla_menu').DataTable({
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        "ajax": {
            url: "controller/index_controller.php?op=listar",
            type: "post",
            error: function (e) {
                console.log(e.responseText);
            },
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]],
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
    });

    $.ajax({
        url: 'controller/index_controller.php?op=listar_cargos', // Cambia la URL según tu controlador
        type: 'POST',
        data: { action: 'listar_cargos' }, // Envía el nombre de la acción al controlador
        dataType: 'json',
        success: function (data) {
            if (data && data.aaData) {
                $('#cargos').selectize({
                    options: data.aaData,
                    valueField: 'value',
                    labelField: 'text',
                    searchField: 'text',
                    create: false,
                    placeholder: 'Elige un cargo'
                });
            }
        }
    });

    $.ajax({
        url: 'controller/index_controller.php?op=listar_documentos', // Cambia la URL según tu controlador
        type: 'POST',
        data: { action: 'listar_cargos' }, // Envía el nombre de la acción al controlador
        dataType: 'json',
        success: function (data) {
            if (data && data.aaData) {
                $('#documentos').selectize({
                    options: data.aaData,
                    valueField: 'value',
                    labelField: 'text',
                    searchField: 'text',
                    create: false,
                    placeholder: 'Elige un tipo de documento'
                });
            }
        }
    });
});

function limpiar() {
    document.getElementById("emplea_form").reset();
    // Restablecer los elementos selectize
    var documentosSelectize = $('#documentos')[0].selectize;
    var cargosSelectize = $('#cargos')[0].selectize;
    documentosSelectize.clear();
    cargosSelectize.clear();
}

document.getElementById("btn_limpiar").addEventListener("click", limpiar);

function cancelar() {
    $('#emplea_form')[0].reset();
    var documentosSelectize = $('#documentos')[0].selectize;
    var cargosSelectize = $('#cargos')[0].selectize;
    documentosSelectize.clear();
    cargosSelectize.clear();
    //$('#tabla_menu').DataTable().ajax.reload();
    var documentosSelectize = $('#documentos')[0].selectize;
    const input1 = document.getElementById("btn_nuevo");
    const input2 = document.getElementById("btn_update");
    const input3 = document.getElementById("btn_cancelar");
    const input4 = document.getElementById("btn_limpiar");
    input1.disabled = false;
    input3.disabled = true;
    input3.style.display = "none";
    input1.style.display = "inline";
    input2.style.display = "none";
    input2.disabled = true;
    input3.disabled = true;
    input4.disabled = false;
    documentosSelectize.enable();
    input4.style.display = "inline";
    $('#num_doc').prop('disabled', false);
}

document.getElementById("btn_cancelar").addEventListener("click", cancelar);

function eliminar(documento) {
    console.log(documento);
    swal.fire({
        title: "Eliminar!",
        text: "Desea eliminar el registro?",
        icon: "error",
        confirmButtonText: "<span><i class='la la-check'></i><span>Si</span></span>",
        confirmButtonClass: "btn btn-danger kt-btn kt-btn--pill kt-btn--air kt-btn--icon",
        showCancelButton: true,
        cancelButtonText: "<span><i class='la la-close'></i><span>No</span></span>",
        cancelButtonClass: "btn btn-secondary kt-btn kt-btn--pill kt-btn--icon"
    }).then((result) => {
        if (result.value) {
            $.post("controller/index_controller.php?op=eliminar", { documento: documento }, function (data, status) {
                $('#tabla_menu').DataTable().ajax.reload();
                Swal.fire('Eliminado!', 'Registro eliminado correctamente.', 'success');
            });
        }
    });
}

function guardar(e) {
    e.preventDefault();
    var formData = new FormData($("#emplea_form")[0]);
    $.ajax({
        url: "controller/index_controller.php?op=guardar_empleado",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            $('#emplea_form')[0].reset();
            var documentosSelectize = $('#documentos')[0].selectize;
            var cargosSelectize = $('#cargos')[0].selectize;
            documentosSelectize.clear();
            cargosSelectize.clear();
            $('#tabla_menu').DataTable().ajax.reload();
            Swal.fire('Guardado!', 'Registro guardado correctamente.', 'success')
        }
    });
}

function update(e) {
    //Activa el input del documento para que este sea enviado
    $('#num_doc').prop('disabled', false);
    e.preventDefault();
    var formData = new FormData($("#emplea_form")[0]);
    $.ajax({
        url: "controller/index_controller.php?op=update_emplea",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            $('#emplea_form')[0].reset();
            var documentosSelectize = $('#documentos')[0].selectize;
            var cargosSelectize = $('#cargos')[0].selectize;
            documentosSelectize.clear();
            cargosSelectize.clear();
            $('#tabla_menu').DataTable().ajax.reload();
            var documentosSelectize = $('#documentos')[0].selectize;
            const input1 = document.getElementById("btn_nuevo");
            const input2 = document.getElementById("btn_update");
            const input3 = document.getElementById("btn_cancelar");
            const input4 = document.getElementById("btn_limpiar");
            input1.disabled = false;
            input3.disabled = true;
            input3.style.display = "none";
            input1.style.display = "inline";
            input2.style.display = "none";
            input2.disabled = true;
            input3.disabled = true;
            input4.disabled = false;
            documentosSelectize.enable();
            input4.style.display = "inline";
            $('#num_doc').prop('disabled', false);
            Swal.fire('Actualizado!', 'Registro actualizado correctamente.', 'success')
        }
    });
}

function editar(documento) {
    const input1 = document.getElementById("btn_nuevo");
    const input2 = document.getElementById("btn_update");
    const input3 = document.getElementById("btn_cancelar");
    const input4 = document.getElementById("btn_limpiar");
    input1.disabled = true;
    input3.disabled = false;
    input3.style.display = "inline";
    input1.style.display = "none";
    input2.style.display = "inline";
    input2.disabled = false;
    input3.disabled = false;
    input4.disabled = true;
    input4.style.display = "none";
    $.post("controller/index_controller.php?op=mostrar", { documento: documento }, function (data, status) {
        data = JSON.parse(data);
        var documentosSelectize = $('#documentos')[0].selectize;
        var cargosSelectize = $('#cargos')[0].selectize;
        documentosSelectize.disable();
        documentosSelectize.setValue(data.tip_documento);
        cargosSelectize.setValue(data.id_cargo);
        $('#num_doc').prop('disabled', true);
        $('#num_doc').val(data.documento);
        $('#nombre_emplea').val(data.nombre);
        $('#correo').val(data.correo);
        $('#fecha_nac').val(data.fecha_nac);
        $('#celular').val(data.celular);
        $('#direccion').val(data.direccion);
    });
}

function validar_form(e){

    // alert("Hola mundo");

    var documento = $("#num_doc").val();
    
    $.ajax({
        url: "controller/index_controller.php?op=validar_duplicado",
        method: "POST",
        data: { documento: documento },
        success: function(response) {
            if (response === 'false') {
                Swal.fire('Error!', 'Este documento ya existe', 'error')
            } else if (response === 'true'){
                guardar(e); // Ejecutar la función para guardar
            }
        }
    });
}

function cambio_input() {
    const form = document.getElementById("emplea_form");
    const originalValues = {};

    // Al cargar la página, guardamos los valores iniciales de los campos
    form.querySelectorAll("input").forEach(input => {
        originalValues[input.id] = input.value;
    });

    let changesDetected = false; // Variable para rastrear cambios
    form.querySelectorAll("input").forEach(input => {
        if (input.value !== originalValues[input.id]) {
            changesDetected = true; 
        }
    });

    if (changesDetected) {
        // Llamar a la función 'update' con algún argumento 'e'
        // Aquí debes definir qué es 'e' y cómo lo obtienes
        // Por ejemplo, puedes crear un evento 'e' y dispararlo
        // o pasar algún dato necesario a 'update'
        update(e);
    } else {
        alert("No se ha realizado ningún cambio");
    }
}


init();