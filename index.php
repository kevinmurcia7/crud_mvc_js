<!DOCTYPE html>
<html lang="en">
<?php
require_once('/xampp/htdocs/Crud_mvc_js/config/config.php');
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/fad48531c5.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.js"></script>
    <link href="https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css" integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Crud_Kevin</title>
</head>

<body>
    <h1 class="text-center p-2">Bienvenido</h1>
    <br>
    <div class="container-fluid row p-8 justify-content-center">
        <form id="emplea_form" class="col-3" method="POST">
            <div class="mb-3">
                <h4 class="text-center">REGISTRO DE COLABORADOR</h4>
                <label for="exampleInputEmail1" class="form-label">Tipo de documento</label>
                <select id="documentos" name="select_doc" required></select>
                <label for="exampleInputEmail1" class="form-label">Número de documento</label>
                <input type="text" id="num_doc" class="form-control" name="documento" required>
                <label for="exampleInputEmail1" class="form-label">Nombre</label>
                <input type="text" id="nombre_emplea" class="form-control" name="nombre" required>
                <label for="exampleInputEmail1" class="form-label">Correo</label>
                <input type="email" id="correo" class="form-control" name="correo" required>
                <label for="exampleInputEmail1" class="form-label">Fecha de nacimiento</label>
                <input type="date" id="fecha_nac" class="form-control" name="fecha_nac">
                <label for="exampleInputEmail1" class="form-label">Cargo</label>
                <select id="cargos" name="select_cargo"></select>
                <label for="exampleInputEmail1" class="form-label">Celular</label>
                <input type="text" id="celular" class="form-control" name="celular" required>
                <label for="exampleInputEmail1" class="form-label">Dirección</label>
                <input type="text" id="direccion" class="form-control" name="direccion">
            </div>
            <button type="submit" id="btn_nuevo" class="btn btn-primary">Registrar</button>
            <button type="submit" id="btn_update" class="btn btn-primary" disabled style="display: none;">Modificar</button>
            <button id="btn_cancelar" type="button" class="btn btn-warning" disabled style="display: none;">Cancelar</button>
            <button id="btn_limpiar" type="button" class="btn btn-warning">Limpiar</button>
        </form>
        <div class="p-1 vr col-4"></div>
        <div class="p-2 col-7">
            <table id="tabla_menu" class="table text-center table table-sm">
                <thead class="bg-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Documento</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Cargo</th>
                        <th scope="col">Celular</th>
                        <th scope="col">Acción</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    <script type="text/javascript" src="assets/datos.js"></script>
</body>

</html>