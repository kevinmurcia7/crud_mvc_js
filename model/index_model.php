<?php

class index_Model extends conectar
{

    public function listarEmplea()
    {
        $conexion = parent::conexion();
        $sql = "SELECT 
        CONCAT(emp.tipo_documento,' ',emp.id_empleado) AS documento, 
        emp.nombre_emplea AS nombre, 
        emp.correo AS correo, 
        car.cargo AS cargo,     
        emp.celular AS celular,
        emp.id_empleado AS id_emplea
        FROM empleados emp 
        INNER JOIN cargos car ON car.id_cargo = emp.id_cargo
        WHERE
        estado_emplea=1";

        $sql = $conexion->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function guardarEmplea($tipo_documento, $id_empleado, $nombre_empleado, $correo, $fecha_nac, $cargo, $celular, $direccion)
    {
        $conexion = parent::conexion();
        $sql = "INSERT INTO 
        empleados
        (tipo_documento,id_empleado,nombre_emplea,id_cargo,correo,celular,direccion,nac_emplea)
        VALUES
        (?,?,?,?,?,?,?,?)";

        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $tipo_documento);
        $sql->bindValue(2, $id_empleado);
        $sql->bindValue(3, $nombre_empleado);
        $sql->bindValue(4, $cargo);
        $sql->bindValue(5, $correo);
        $sql->bindValue(6, $celular);
        $sql->bindValue(7, $direccion);
        $sql->bindValue(8, $fecha_nac);
        $sql->execute();
    }

    public function actualizarEmplea($id_empleado, $nombre_empleado, $correo, $fecha_nac, $cargo, $celular, $direccion)
    {
        $conexion = parent::conexion();
        $sql = "UPDATE
        empleados
        SET
        nombre_emplea = ?,
        id_cargo = ?,
        correo = ?,
        celular = ?,
        direccion = ?,
        nac_emplea = ?
        WHERE
        id_empleado = ?";

        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $nombre_empleado);
        $sql->bindValue(2, $cargo);
        $sql->bindValue(3, $correo);
        $sql->bindValue(4, $celular);
        $sql->bindValue(5, $direccion);
        $sql->bindValue(6, $fecha_nac);
        $sql->bindValue(7, $id_empleado);
        $sql->execute();
    }

    public function borrarEmplea($id_empleado)
    {
        $conexion = parent::conexion();
        $sql = "UPDATE
        empleados
        SET
        estado_emplea=0
        WHERE
        id_empleado = ?";

        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $id_empleado);
        $sql->execute();
    }

    public function obtenerEmplea($id_empleado)
    {
        $conexion = parent::conexion();
        $sql = "SELECT 
        emp.tipo_documento AS tip_documento,
        emp.id_empleado AS documento, 
        emp.nombre_emplea AS nombre, 
        emp.correo AS correo, 
        emp.direccion AS direccion, 
        emp.nac_emplea AS fecha_nac, 
        car.id_cargo AS id_cargo,   
        car.cargo AS cargo,     
        emp.celular AS celular
        FROM empleados emp 
        INNER JOIN cargos car ON car.id_cargo = emp.id_cargo
        WHERE 
        emp.id_empleado = ?";

        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $id_empleado);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function listarCargos()
    {
        $conexion = parent::conexion();
        $sql = "SELECT 
        id_cargo AS cargo,
        cargo AS nombre_cargo
        FROM
        cargos";

        $sql = $conexion->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function listarTiposID()
    {
        $conexion = parent::conexion();
        $sql = "SELECT 
        tipo_identificacion AS identificacion
        FROM
        tipos_identificacion";

        $sql = $conexion->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function validar_doc_duplicado($id_empleado)
    {
        $conexion = parent::conexion();
        $sql = "SELECT
        COUNT(*) 
        FROM
        empleados 
        WHERE 
        id_empleado = ?";

        $sql = $conexion->prepare($sql);
        $sql->bindValue(1, $id_empleado);
        $sql->execute();
        $conteo = $sql->fetchColumn(); // Obtener el valor del conteo
        return $conteo;
    }
}
