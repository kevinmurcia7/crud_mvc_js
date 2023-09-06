<?php

class conectar
{
    protected function conexion(){
        $dsn = "mysql:host=localhost;dbname=prueba";
        $usuario = "root";
        $contrasena = "";

        try {
            $conexion = new PDO($dsn, $usuario, $contrasena);
            // Configurar opciones de conexión si es necesario
            return $conexion;
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    }
}
