<?php

require_once('/xampp/htdocs/Crud_mvc_js/config/config.php');
require_once('/xampp/htdocs/Crud_mvc_js/model/index_model.php');

$menu = new index_Model();

switch ($_GET["op"]) {

    case "listar":
        $datos = $menu->listarEmplea();
        $n = 1;
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $n++;
            $sub_array[] = $row["documento"];
            $sub_array[] = $row["nombre"];
            $sub_array[] = $row["correo"];
            $sub_array[] = $row["cargo"];
            $sub_array[] = $row["celular"];
            $sub_array[] = '<button type="button" onClick="editar(' . $row["id_emplea"] . ');"  id="' . $row["id_emplea"] . '" class="btn btn-outline-warning btn-icon"><div><i class="fa fa-edit"></i></div></button>' .
                '<button type="button" onClick="eliminar(' . $row["id_emplea"] . ');"  id="' . $row["id_emplea"] . '" class="btn btn-outline-danger btn-icon"><div><i class="fa fa-trash"></i></div></button>';
            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    case "eliminar":
        $borrar = $menu->obtenerEmplea($_POST["documento"]);
        if (is_array($borrar) == true and count($borrar) > 0) {
            $menu->borrarEmplea($_POST["documento"]);
        }
        break;

    case "listar_cargos":
        $datos = $menu->listarCargos();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array(
                "value" => $row["cargo"],
                "text" => $row["nombre_cargo"]
            );
            $data[] = $sub_array;
        }

        $results = array(
            // "sEcho" => 1,
            // "iTotalRecords" => count($data),
            // "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    case "listar_documentos":
        $datos = $menu->listarTiposID();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array(
                "value" => $row["identificacion"],
                "text" => $row["identificacion"]
            );
            $data[] = $sub_array;
        }

        $results = array(
            // "sEcho" => 1,
            // "iTotalRecords" => count($data),
            // "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    case "guardar_empleado":
        if (!empty($_POST["documento"])) {
            $menu->guardarEmplea($_POST["select_doc"], $_POST["documento"], $_POST["nombre"], $_POST["correo"], $_POST["fecha_nac"], $_POST["select_cargo"], $_POST["celular"], $_POST["direccion"]);
        }
        break;

    case "update_emplea":
        if (!empty($_POST["documento"])) {
            $menu->actualizarEmplea($_POST["documento"], $_POST["nombre"], $_POST["correo"], $_POST["fecha_nac"], $_POST["select_cargo"], $_POST["celular"], $_POST["direccion"]);
        }
        break;
    case 'mostrar':
        $datos = $menu->obtenerEmplea($_POST["documento"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["tip_documento"] = $row["tip_documento"];
                $output["documento"] = $row["documento"];
                $output["nombre"] = $row["nombre"];
                $output["correo"] = $row["correo"];
                $output["direccion"] = $row["direccion"];
                $output["fecha_nac"] = $row["fecha_nac"];
                $output["id_cargo"] = $row["id_cargo"];
                $output["celular"] = $row["celular"];
            }
            echo json_encode($output);
        }
        break;

    case 'validar_duplicado':
        $documento = $_POST["documento"];
        $conteo = $menu->validar_doc_duplicado($documento);

        // Si hay duplicado, devuelve "false", de lo contrario, "true"
        echo $conteo >= 1 ? "false" : "true";
        break;
    default:
        echo "La opción no coincide con ningún caso";
        break;
}
